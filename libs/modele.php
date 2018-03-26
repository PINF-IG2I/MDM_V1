<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");
include_once("maLibUtils.php");

function listUsers()
{
	$SQL = "select id_user,first_name,last_name,status,language,isConnected from users ORDER BY id_user";

	return parcoursRs(SQLSelect($SQL));

}

// Collect informations from every document
function listerDocs() {
	$SQL = "SELECT document.id_doc,version,initial_language,name,subject,site,PIC,document_version.status,component_name,subsystem_name,GATC_baseline,language,project,translator,previous_doc,installation,maintenance,x_link,aec_link,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4 FROM document,document_version,document_language,document_reference,gatc_baseline,association_table, components, etcs_subsystem WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_document=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document_reference.product=etcs_subsystem.id AND document_reference.component=components.id  ";
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
	$SQL="SELECT name FROM document_reference";
	$res["name"]=parcoursRs(SQLSelect($SQL));
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
	$SQL="SELECT name,subject,version,initial_language,language,project,translator,previous_doc,product,component,GATC_baseline,UNISIG_baseline,site,pic,installation,maintenance,status,availability_x,availability_aec,availability_ftp,availability_sharepoint_vbn,availability_sharepoint_blq,x_link,aec_link,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4,document.id_doc,id_document_language,id_document_version,id_document_reference,association_table.id,gatc_baseline.id_baseline  FROM document,document_version,document_language,document_reference,gatc_baseline,association_table WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline   ";
	foreach ($data as $key => $value) {
		if(!is_array($value)){
			$SQL.=" AND `".protect(trim($key))."` LIKE '".protect(trim($value))."'";	
		} else {
			if($key=="type"){
				foreach ($value as $content) {
					$SQL.= " AND `".protect(trim($content)) ."` = '1' ";
				}
			} else if ($key=="initial_language"){ //filtering by language is a bit different, the query must search in both document_reference and document_language tables
				$SQL.="AND (`initial_language` IN(";
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
	fputcsv($file,array_keys($data[0]));

	foreach($data as $row){
		fputcsv($file, $row);
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

?>
