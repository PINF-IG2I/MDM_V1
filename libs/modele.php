<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");
include_once("maLibUtils.php");
include_once("config.php");

function listUsers()
{
	$SQL = "select id_user,first_name,last_name,status,language,isConnected from users ORDER BY id_user";

	return parcoursRs(SQLSelect($SQL));

}

// Collect informations from every document
function listerDocs() {
	$SQL = "SELECT document.id_doc,version,initial_language,reference,subject,site,PIC,document_version.status,component_name,subsystem_name,GATC_baseline,language,project,translator,previous_doc,installation,maintenance,x_link,aec_link,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4 FROM document,document_version,document_language,document_reference,gatc_baseline,association_table, components, etcs_subsystem WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_document=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document_reference.product=etcs_subsystem.id AND document_reference.component=components.id  ";
	return parcoursRs(SQLSelect($SQL));
}



function checkUserDB($login,$password)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT * FROM users WHERE last_name='$login'  AND password='$password'";
	return parcoursRs(SQLSelect($SQL));
}


/**
* Fonction permettant d'update l'attribut isConnected dans la table
* $value doit valoir 0 ou 1.
*
*/
function updateStatus($id,$value){
	if(secure("isConnected","SESSION")){
		$SQL="UPDATE users SET isConnected =$value WHERE id_user='$id'";
		return SQLUpdate($SQL);
	}
}

function getIsConnected($id){
	$SQL="SELECT isConnected FROM users WHERE id_user='$id'";
	return SQLGetChamp($SQL);
}


// Update the language of a user
function updateLanguage($language,$id){
	$SQL="UPDATE users SET language='$language' WHERE id_user=$id";

	return SQLUpdate($SQL);
}

// Collect datas from a search
function getSearchDatas(){

	/* Datas for Input*/
	$SQL="SELECT reference AS reference FROM document_reference UNION DISTINCT SELECT subject FROM document_reference;";
	$res["reference"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT previous_doc FROM document_reference";
	$res["previous_doc"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT version FROM document_version";
	$res["version"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT pic FROM document_version";
	$res["pic"]=parcoursRs(SQLSelect($SQL));

	/* Datas for Select*/
	$SQL="SELECT * FROM gatc_baseline";
	$res["baseline"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT site FROM document_version";
	$res["site"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT product FROM document_reference";
	$res["product"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT component FROM document_reference";
	$res["component"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT initial_language AS initial_language FROM document_reference UNION DISTINCT SELECT language FROM document_language ;";
	$res["language"]=parcoursRs(SQLSelect($SQL));
	return $res;
}

function getResultsFromQuery($data,$status){
	$SQL="SELECT reference,subject,version,initial_language,language,project,translator,previous_doc,product,component,GATC_baseline,UNISIG_baseline,site,pic,installation,maintenance,status,availability_x,availability_aec,availability_ftp,availability_sharepoint_vbn,availability_sharepoint_blq,x_link,aec_link,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4,document.id_doc,id_document_language,id_document_version,id_document_reference,association_table.id,gatc_baseline.id_baseline  FROM document,document_version,document_language,document_reference,gatc_baseline,association_table WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline   ";
	foreach ($data as $key => $value) {
		if(!is_array($value) && $key!="reference"){
			$SQL.=" AND `".protect(trim($key))."` LIKE '".protect(trim($value))."'";	
		}else if ($key=="reference"){ //searching by document "reference" is a bit different, the user is allowed to perform a query on both a document reference and a document title.
		$SQL.=" AND (`".protect(trim($key))."` LIKE  '".protect(trim($value))."' OR `subject` LIKE '".protect(trim($value))."')";
	}else {
		if($key=="type"){
			foreach ($value as $content) {
				$SQL.= " AND `".protect(trim($content)) ."` = '1' ";
			}
			} else if ($key=="initial_language"){ //filtering by language is a bit different, the query must search in both document_reference and document_language tables
				$SQL.=" AND (`initial_language` IN(";
				foreach($value as $content){
					$SQL.="'".protect(trim($content))."',";
				}
				$SQL=substr($SQL,0,-1);
				$SQL.=") ";
				$SQL.="OR `language` IN(";
				foreach($value as $content){
					$SQL.="'".protect(trim($content))."',";

				}
				$SQL=substr($SQL,0,-1);
				$SQL.=") )";
			} else {
				$SQL.= " AND `".protect(trim($key))."` IN (";
				foreach ($value as $content) {
					$SQL.="'".protect(trim($content))."',";
				}
				$SQL=substr($SQL,0,-1);
				$SQL.=") ";

			}
		}
	}
	if($status == "External") //if the user has the status "external", only public documents are displayed.
	$SQL.= " AND status = 'Public'";
	return parcoursRs(SQLSelect($SQL));

}

function editDocument($data) {
	$SQL="SET foreign_key_checks = 0;
	UPDATE document,document_version,document_language,document_reference,gatc_baseline,association_table  SET ";
	foreach($data as $key=>$value) {
		$SQL.=protect(trim($key))."='".protect(trim($value))."',";
	}
	$SQL=substr($SQL,0,-1);
	$SQL.=" WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document.id_doc=".protect($data["document.id_doc"]).";SET foreign_key_checks = 1;";
	return SQLUpdate($SQL);
}

function getUsersFromQuery($data){
	$SQL="SELECT * FROM users WHERE last_name LIKE '%$data%' OR first_name LIKE '%$data%'";
	return parcoursRs(SQLSelect($SQL));
}

// Edit the informations of a specified user
function editUser($id,$lastname,$firstname,$status,$language,$password=""){
	$SQL="UPDATE users SET last_name='$lastname', first_name='$firstname', status='$status', language='$language' ";
	if($password!="") $SQL.= ", password='$password' ";
	$SQL.= " WHERE id_user='$id'";
	return SQLUpdate($SQL);
}

// Delete a specified user
function deleteUser($id){
	$SQL="DELETE FROM users WHERE id_user='$id'";
	return SQLDelete($SQL);
}

// Delete a specified document
function deleteDoc($id){ 
	$SQL="DELETE FROM association_table WHERE id_doc='$id'";
	return SQLDelete($SQL);
}

function managerConnected(){
	$SQL="SELECT isConnected FROM users WHERE status='Manager' AND isConnected='1'";
	return parcoursRs(SQLSelect($SQL));
}

// Create a user
function createUser($lastName, $firstName, $password, $status, $language) {
	$SQL="INSERT INTO users (last_name, first_name, password, status, language, isConnected) VALUES ('$lastName', '$firstName', '$password', '$status', '$language', 0)";
	return SQLInsert($SQL);
}

// Delete all the data from the database
function deleteDatabase() {
	$SQL="SET FOREIGN_KEY_CHECKS = 0; 
	DELETE FROM document; 
	DELETE FROM document_language; 
	DELETE FROM association_table; 
	DELETE FROM components; 
	DELETE FROM document_reference; 
	DELETE FROM document_version; 
	DELETE FROM etcs_subsystem; 
	DELETE FROM gatc_baseline; 
	DELETE FROM users WHERE status NOT LIKE 'Administrator'; 
	SET FOREIGN_KEY_CHECKS = 1;";
	return SQLUpdate($SQL);
}

function exportResults($data){
	$file=fopen("php://output","w");
	fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
	foreach ($data as $key => $value) {
		foreach ($data[$key] as $insideKey=> $insideValue) {
			if(substr($insideKey,0,2)=="id")
				unset($data[$key][$insideKey]);
		}
	}
	fputcsv($file,array_keys($data[0]),";");

	foreach($data as $row){
		fputcsv($file, $row,";");
	}
	fclose($file);
	header("Content-Encoding: UTF-8");
	header("Content-type:text/csv; charset=UTF-8");
	header('Content-Disposition: attachment; filename="result.csv"');
	header('Pragma: no-cache');
	header('Expires: 0');
	exit;
}

function checkInFile($propertyName){

	if(!file_exists("./properties.txt")){ //In case the file does not exist, it is recreated with DEFAULT values
		$file=fopen("./properties.txt","r+");
		if($file){
			fwrite($file,"manager=\n");
			fwrite($file,"locked_database=1");
			fclose($file);
			return "problem";  
		}
	} else {

		$file=fopen("./properties.txt","r+");
		if($file){
			while(!feof($file)){
				$entry=array_map('trim', explode('=', fgets($file)));
				if($entry[0]==$propertyName){
					return $entry[1];
				}
			}
			fclose($file);
		}
		return NULL;
	}
}

function lockedDatabase(){
	return checkInFile("locked_database");
}

function connectedManager(){
	return checkInFile("manager");
}


function changeDatabaseStatus($status){
	if($status=="lock"){
		writeInFile("locked_database","1");
	} else
	writeInFile("locked_database","0");
	disconnectAll();

}

/** Disconnect all users except administrator*/
function disconnectAll(){
	$SQL="UPDATE users SET isConnected='0' WHERE status!='Administrator'";
	return SQLUpdate($SQL);
}


/** Write something in a file with the following pattern $propertyName=$value */
function writeInFile($propertyName,$value){
	if(!file_exists("./properties.txt")){ //In case the file does not exist, it is recreated with DEFAULT values
		$file=fopen("./properties.txt","w");
		if($file){
			fwrite($file,"manager=\r\n");
			fwrite($file,"locked_database=1\r\n");
			fclose($file);
			return "problem";  
		}
	} else {
		$text='';
		$file=fopen("./properties.txt","r+");
		if($file){
			while(!feof($file)){
				$line=fgets($file);
				$entry=explode("=",$line);
				if($entry[0]==$propertyName){
					$text.=$propertyName."=".$value."\r\n";

				} else $text.=$line;
			}
			fclose($file);
		}
		file_put_contents("./properties.txt",$text);
	}
}

//Execute queries from an SQL file
function importSQL($filesql) {
	deleteDatabase();
}

//import datas
function importDatas($tempname){
	//the aim of this function is to make the life of the user easier.
	//when creating his excel file, he has the possiblity to move around all the columns
	//also, he has the possibility to create new columns. as long as those new columns don't have the same name as an attribute in the database, this will work.
	//a lot of the treatments in this function may seem redundant, but they're essential.
	//as long as you keep in mind that this function must work with any disposition of the cells in the csv file, you'll understand how it works.


	global $BDD_base;
	//find csv delimiter
	$delimiter=findDelimiter($tempname); //we accept all kind of csv delimiters, tabs, commas or semicolons
	$csvAsArray=array_map(function($v) use($delimiter){return str_getcsv($v, $delimiter);}, file($tempname)); //anonymous function, we need to use the delimiter previously found
	print_r($csvAsArray);
	//checking if all columns name are in the database
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language','document_reference','document_version','gatc_baseline');";
	echo "<br>";
	$columns=parcoursRs(SQLSelect($SQL));
	print_r($columns);
	$finalColumns=array();
	foreach ($columns as $key => $value) {
		array_push($finalColumns, $value["COLUMN_NAME"]);

	}
	print_r($finalColumns);
	//in this part, we build the different queries that will be used to insert datas
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language');";
	$columns=parcoursRs(SQLSelect($SQL));
	print_r($columns);
	$languageColumns=array();
	foreach ($columns as $key => $value) {
		array_push($languageColumns, $value["COLUMN_NAME"]);

	}
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_version');";
	$columns=parcoursRs(SQLSelect($SQL));
	print_r($columns);
	$versionColumns=array();
	foreach ($columns as $key => $value) {
		array_push($versionColumns, $value["COLUMN_NAME"]);

	}
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_reference');";
	$columns=parcoursRs(SQLSelect($SQL));
	print_r($columns);
	$referenceColumns=array();
	foreach ($columns as $key => $value) {
		array_push($referenceColumns, $value["COLUMN_NAME"]);

	}
	echo "<br><br>";
	print_r($referenceColumns);
	print_r($languageColumns);
	print_r($versionColumns);
	echo "<br><br>";
	$fileColumns=$csvAsArray[0];
	foreach ($fileColumns as $key=>$value) { //avoid white spaces
		$fileColumns[$key]=trim($fileColumns[$key]);
	}
	$size=sizeof($fileColumns);
	$ignoredColumns=array();
    $fileColumns[0]=remove_utf8_bom($fileColumns[0]); //first character of the first data may contain utf_8 BOM, we have to remove it to make it work as intended.
    echo "<br><br>";
    print_r($fileColumns);
    for($i=0;$i<$size;$i++){
    	if(!in_array($fileColumns[$i],$finalColumns)){ //if one of the column name is unknown in the database, we just ignore this.
    		array_push($ignoredColumns, $i);
    	} else {
    	//also, some attributes are essential : for example, a baseline is essential, as well as a reference. we get the index of those columns in the csv
    		switch ($fileColumns[$i]) {
    			case 'reference':
    			$referenceColumn=$i;
    			break;
    			case 'GATC_baseline':
    			$baselineColumn=$i;
    			break;
    			case 'version':
    			$versionColumn=$i;
    			break;
    			case 'language':
    			$languageColumn=$i;
    			break;
    			case 'project':
    			$projectColumn=$i;
    			break;
    			case 'translator':
    			$translatorColumn=$i;
    			break;
    			default:

    			break;
    		}
    	}	
    }

    echo 'Baseline column :'.$baselineColumn.'<br>Reference column :'. $referenceColumn;
    print_r($ignoredColumns);
    //$ignoredColumns contains the indexes of the columns that need to be avoided.
    echo "<br><br>";
    //after all the ignored rows have been found, we build the different queries that will be used to insert datas into the database
    $SQL_doc_ref="INSERT INTO document_reference("; //doc reference
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$referenceColumns)){
    		$SQL_doc_ref.="`".$fileColumns[$i]."`,";
    	}
    }
    $SQL_doc_ref=substr($SQL_doc_ref,0,-1);
    $SQL_doc_ref.=") VALUES (";
    $SQL_doc_version="INSERT INTO document_version("; //doc version
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$versionColumns)){
    		$SQL_doc_version.="`".$fileColumns[$i]."`,";
    	}
    }
    $SQL_doc_version=substr($SQL_doc_version,0,-1);
    $SQL_doc_version.=") VALUES (";
    $SQL_doc_language="INSERT INTO document_language("; //doc language
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$languageColumns)){
    		$SQL_doc_language.="`".$fileColumns[$i]."`,";
    	}
    }
    $SQL_doc_language=substr($SQL_doc_language,0,-1);
    $SQL_doc_language.=") VALUES (";
    //checking data validity and insertion
    $sizeCsvArray=sizeof($csvAsArray);
    $ignoredRows=array();
    $rowsInserted=0;
    $docsInserted=0;
    for($j=1;$j<$sizeCsvArray;$j++){
    	if(empty($csvAsArray[$j][$referenceColumn]) || empty($csvAsArray[$j][$baselineColumn]) ||  !($idBaseline =unknownBaseline($csvAsArray[$j][$baselineColumn]))){ //if necessary informations are missing, we just ignore the row (the baseline is essential as well as the reference number of the document), also, if the baseline in the row doesnt exist in the database, the row is ignored. see specifications
    		array_push($ignoredRows, $j);    		
    	}else{
    		if(empty($csvAsArray[$j][$languageColumn])) {
    			$csvAsArray[$j][$languageColumn]='';
    			$csvAsArray[$j][$translatorColumn]='';
    			$csvAsArray[$j][$projectColumn]='';
    		}
    		if($csvAsArray[$j][$versionColumn]=='') $csvAsArray[$j][$versionColumn]='TBD';
    		echo $idBaseline;
    		if($idRef=referenceExists($csvAsArray[$j][$referenceColumn]))
    			$refQuery=false;
    		else 
    			$refQuery=$SQL_doc_ref;
    		if($idRef!=false && $idVersion=versionExists($idRef,$csvAsArray[$j][$versionColumn]))
    			$versionQuery=false;
    		else{
    			$versionQuery=$SQL_doc_version;
    		}
    		if($idLanguage=languageExists($csvAsArray[$j][$languageColumn],$csvAsArray[$j][$projectColumn],$csvAsArray[$j][$translatorColumn]))
    			$languageQuery=false;
    		else
    			$languageQuery=$SQL_doc_language;
    		for($k=0;$k<$size;$k++){

    			if(!in_array($k, $ignoredColumns) || $k!=$baselineColumn){
    				if($refQuery != false && in_array($fileColumns[$k],$referenceColumns)){
    					$refQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    				} else if( $languageQuery!=false && in_array($fileColumns[$k],$languageColumns)){
    					$languageQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    				} else if($versionQuery!=false && in_array($fileColumns[$k],$versionColumns)){
    					$versionQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    				}
    			}
    		}
    		if($refQuery){
    			$refQuery=substr($refQuery, 0,-1);
    			$refQuery.=");";
    			$idRef=SQLInsert($refQuery);
    			$rowsInserted++;
    		}
    		if($versionQuery){
    			$versionQuery=substr($versionQuery, 0,-1);
    			$versionQuery.=");";
    			$idVersion=SQLInsert($versionQuery);
    			$rowsInserted++;
    		}
    		if($languageQuery){
    			$languageQuery=substr($languageQuery, 0,-1);
    			$languageQuery.=");";
    			$idLanguage=SQLInsert($languageQuery);
    			$rowsInserted++;
    		}
    		echo"<br>Newdoc<hr>";
    		echo "<br>".$refQuery." ".$idRef;
    		echo "<br>".$versionQuery." ".$idVersion;
    		echo "<br>".$languageQuery." ".$idLanguage;
    		echo "<br><br>";

    		if(!($idDoc=docExists($idRef,$idVersion,$idLanguage))){
    			$SQL="INSERT INTO document(`id_document_language`,`id_document_version`,`id_document_reference`) VALUES ('".$idLanguage."','".$idVersion."','".$idRef."');";
    			$idDoc=SQLInsert($SQL);
    			$docsInserted++;
    		}
    		echo "id_doc :".$idDoc;
    		if(!($idAssociationTable = associationTableEntry($idBaseline,$idDoc))){
    			$SQL="INSERT INTO association_table (`id_doc`,`id_baseline`) VALUES ('".$idDoc."','".$idBaseline."');";
    			$res=SQLInsert($SQL);
    			$rowsInserted++;
    		}
    		
    	}
    }
    echo "<br>";
    print_r($ignoredRows);
    echo "<br>".$rowsInserted ." enregistrements<br>";
    echo $docsInserted." documents ajoutés<br>";
}

//seeks for the delimiter used in the file format, this is done by searching the most occured delimiter in the file
function findDelimiter($tempname){
	$delimiters = array(
		'semicolon' => ";",
		'tab'       => "\t",
		'comma'     => ",",
	);
	$csv = file_get_contents($tempname);
	foreach ($delimiters as $key => $delim) {
		$res[$key] = substr_count($csv, $delim);
	}

	//reverse sort the values, so the [0] element has the most occured delimiter
	arsort($res);

	reset($res);
	$first_key = key($res);

	return $delimiters[$first_key]; 
}

	

//removes utf8 BOM from csv file
function remove_utf8_bom($text){
	$bom=pack('H*','EFBBBF');
	$text=preg_replace("/^$bom/",'', $text);
	return $text;
}

//seeks if the baseline exists or not
function unknownBaseline($baseline){
	$SQL="SELECT id_baseline from gatc_baseline WHERE gatc_baseline='".protect(htmlspecialchars(trim($baseline)))."'";
	echo $SQL;
	return SQLGetChamp($SQL);
}

function referenceExists($reference){
	$SQL="SELECT id_ref FROM document_reference WHERE reference='".protect(trim($reference))."'";
	return SQLGetChamp($SQL);
}

function versionExists($idRef,$version){
	$SQL="SELECT DISTINCT id_version FROM document_reference,document_version,document WHERE document.id_document_reference=id_ref AND document.id_document_version=id_version AND  id_ref='$idRef' AND version='".protect(htmlspecialchars(trim($version)))."'";
	return SQLGetChamp($SQL);
}

function languageExists($language,$project,$translator){
	$SQL="SELECT id_entry FROM document_language WHERE 	language='".protect(htmlspecialchars(trim($language)))."' AND project='".protect(htmlspecialchars(trim($project)))."'AND translator='".protect(htmlspecialchars(trim($translator)))."'";
	return SQLGetChamp($SQL);
}

function docExists($idRef,$idVersion,$idLanguage){
	$SQL="SELECT id_doc FROM document WHERE id_document_reference='$idRef' AND id_document_version='$idVersion' AND id_document_language='$idLanguage'";
	return SQLGetChamp($SQL);
}

function associationTableEntry($id_baseline,$id_doc){
	$SQL="SELECT id FROM association_table WHERE id_doc='$id_doc' AND id_baseline='$id_baseline'";
	return SQLSelect($SQL);
}

//seeks if the baseline exists or not
function unknownBaseline($baseline){
	$SQL="SELECT gatc_baseline from gatc_baseline WHERE gatc_baseline='".protect(trim($baseline))."'";
	return SQLGetChamp($SQL);
}


?>
