<?php
include_once "config.php";
include_once "maLibUtils.php";

session_start();

if (secure("status","SESSION")!="Administrator")
{
	header("Location:../index.php?view=search&message=".urlencode("You need to be Administrator."));
	die("");
}

error_reporting(E_ALL);
ini_set('display_errors', true);


/**
 * Save MySQL
 */
class BackupMySQL extends mysqli {
	
	/**
	 * Saves folder
	 * @var string
	 */
	protected $dossier;
	
	/**
	 * File name
	 * @var string
	 */
	protected $nom_fichier;
	
	/**
	 * Ressource of GZIP file
	 * @var ressource
	 */
	protected $gz_fichier;
	
	
	/**
	 * Constructor
	 * @param array $options
	 */
	public function __construct($options = array()) {
		$default = array(
			'host' => ini_get('mysqli.default_host'),
			'username' => ini_get('mysqli.default_user'),
			'passwd' => ini_get('mysqli.default_pw'),
			'dbname' => '',
			'port' => ini_get('mysqli.default_port'),
			'socket' => ini_get('mysqli.default_socket'),
			// other options
			'dossier' => './',
			'nbr_fichiers' => 5,
			'nom_fichier' => 'backup'
			);
		$options = array_merge($default, $options);
		extract($options);
		
		// Connection to db
		@parent::__construct($host, $username, $passwd, $dbname, $port, $socket);
		if($this->connect_error) {
			$this->message('Erreur de connexion (' . $this->connect_errno . ') '. $this->connect_error);
			return;
		}
		
		// Folder control
		$this->dossier = $dossier;
		if(!is_dir($this->dossier)) {
			$this->message('Erreur de dossier &quot;' . htmlspecialchars($this->dossier) . '&quot;');
			return;
		}
		
		// File control
		$this->nom_fichier = $nom_fichier . date('Ymd-His') . '.sql';
		$this->gz_fichier = fopen($this->dossier . $this->nom_fichier, 'w');
		/*if(!$this->gz_fichier) {
			$this->message('Erreur de fichier &quot;' . htmlspecialchars($this->nom_fichier) . '&quot;');
			return;
		}*/
		
		// Process start
		$this->sauvegarder();
		$this->purger_fichiers($nbr_fichiers);
	}
	
	protected function message($message = '&nbsp;') {
		echo '<p style="padding:0; margin:1px 10px; font-family:sans-serif;">'. $message .'</p>';
	}
	
	/**
	 * Quotes SQL protection
	 * @param string $string
	 * @return string
	 */
	protected function insert_clean($string) {
		// Ne pas changer l'ordre du tableau !!!
		$s1 = array( "\\"	, "'"	, "\r", "\n", );
		$s2 = array( "\\\\"	, "''"	, '\r', '\n', );
		return str_replace($s1, $s2, $string);
	}
	
	/**
	 * Tables save
	 */
	protected function sauvegarder() {
		$this->message('Sauvegarde...');
		
		$sql  = '--' ."\n";
		$sql .= '-- '. $this->nom_fichier ."\n";
		fwrite($this->gz_fichier, $sql);
		
		// Tables list
		$result_tables = $this->query('SHOW TABLE STATUS');
		if($result_tables && $result_tables->num_rows) {
			while($obj_table = $result_tables->fetch_object()) {
				$this->message('- ' . htmlspecialchars($obj_table->{'Name'}));
				
				// DROP ...
				$sql  = "\n\n";
				$sql .= 'DROP TABLE IF EXISTS `'. $obj_table->{'Name'} .'`' .";\n";

				// CREATE ...
				$result_create = $this->query('SHOW CREATE TABLE `'. $obj_table->{'Name'} .'`');
				if($result_create && $result_create->num_rows) {
					$obj_create = $result_create->fetch_object();
					$sql .= $obj_create->{'Create Table'} .";\n";
					$result_create->free_result();
				}

				// INSERT ...
				$result_insert = $this->query('SELECT * FROM `'. $obj_table->{'Name'} .'`');
				if($result_insert && $result_insert->num_rows) {
					$sql .= "\n";
					while($obj_insert = $result_insert->fetch_object()) {
						$virgule = false;
						
						$sql .= 'INSERT INTO `'. $obj_table->{'Name'} .'` VALUES (';
						foreach($obj_insert as $val) {
							$sql .= ($virgule ? ',' : '');
							if(is_null($val)) {
								$sql .= 'NULL';
							} else {
								$sql .= '\''. $this->insert_clean($val) . '\'';
							}
							$virgule = true;
						} // for
						
						$sql .= ')' .";\n";
						
					} // while
					$result_insert->free_result();
				}
				
				fwrite($this->gz_fichier, $sql);
			} // while
			$result_tables->free_result();
		}
		fclose($this->gz_fichier);
		$this->message('<strong style="color:green;">' . htmlspecialchars($this->nom_fichier) . '</strong>');
		
		$this->message('Sauvegarde termin&eacute;e !');
		
		header("Location:../saves/".$this->nom_fichier);
		die();
	}
	

	protected function purger_fichiers($nbr_fichiers_max) {
		$this->message();
		$this->message('Purge des anciens fichiers...');
		$fichiers = array();
		
		// On recupere le nom des fichiers gz
		if($dossier = dir($this->dossier)) {
			while(false !== ($fichier = $dossier->read())) {
				if($fichier != '.' && $fichier != '..') {
					if(is_dir($this->dossier . $fichier)) {
						// Ceci est un dossier ( et non un fichier )
						continue;
					} else {
						// On ne prend que les fichiers se terminant par ".gz"
						if(preg_match('/\.gz$/i', $fichier)) {
							$fichiers[] = $fichier;
						}
					}
				}
			} // while
			$dossier->close();
		}
		
		$nbr_fichiers_total = count($fichiers);
		if($nbr_fichiers_total >= $nbr_fichiers_max) {
			// Inverser l'ordre des fichiers gz pour ne pas supprimer les derniers fichiers
			rsort($fichiers);
			
			// Suppression...
			for($i = $nbr_fichiers_max; $i < $nbr_fichiers_total; $i++) {
				$this->message('<strong style="color:red;">' . htmlspecialchars($fichiers[$i]) . '</strong>');
				unlink($this->dossier . $fichiers[$i]);
			}
		}
		$this->message('Purge termin&eacute;e !');
	}
	
}



// Class instance 
new BackupMySQL(array(
	'host' => $BDD_host,
	'username' => $BDD_user,
	'passwd' => $BDD_password,
	'dbname' => $BDD_base,
	'dossier' => '../saves/',
	'nom_fichier' => 'backup'
	));

?>