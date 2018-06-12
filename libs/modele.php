<?php
/**
* \file modele.php
* \author TOPINF team
* \version 1.0
* \brief This file contains all the necessary methods called in the controleur.php file. These methods are used to communicate between the client and the server.
*/

include_once("maLibSQL.pdo.php");
include_once("maLibUtils.php");
include_once("config.php");


/**
* \fn function listUsers()
* \brief This fonction is used to list all users (used in the administration panel)
* \param None.
* \return An array with all the datas of the users.
* \details This function returns all users, ordered by their id.
*/
function listUsers()
{
	$SQL = "select id_user,first_name,last_name,status,language,isConnected from users ORDER BY id_user";

	return parcoursRs(SQLSelect($SQL));

}

/**
*	\fn function checkUserDB($login,$password)
*	\brief This function checks if a user login exists, and if the password matches.
*	\param $login -> the login of the user \param $password --> the password of the user
*	\return the id of the user if this user exists, false if the user doesn't exist.
*/
function checkUserDB($login,$password)
{

	$SQL="SELECT * FROM users WHERE last_name='$login'  AND password='$password'";
	return parcoursRs(SQLSelect($SQL));
}


/**
*	\fn function updateStatus($id,$value)
*	\brief This function updates the value of the isConnected attribute for the user whose ID is $id.
*	\param $id --> the id of the user \param $value --> the new value of the isConnected attribute.
*	\return the number of rows which were updated, false if there was a problem.
*/
function updateStatus($id,$value){
	if(secure("isConnected","SESSION")){
		$SQL="UPDATE users SET isConnected =$value WHERE id_user='$id'";
		return SQLUpdate($SQL);
	}
}

/**
*	\fn function getIsConnected($id)
*	\brief This function fetches the value of the isConnected attribte for the specified user id.
*	\param $id --> the id of the user
*	\return the value of the isConnected attribute, false if the user doesn't exist.
*/
function getIsConnected($id){
	$SQL="SELECT isConnected FROM users WHERE id_user='$id'";
	return SQLGetChamp($SQL);
}



/**
*	\fn function updateLanguage($language,$id)
*	\brief This function updates the language of the specified user.
*	\param $language --> the new language \param $id --> the id of the user whose language must be updated.
*	\return the number of rows which were updated, false if there was a problem.
*/
function updateLanguage($language,$id){
	$SQL="UPDATE users SET language='$language' WHERE id_user=$id";

	return SQLUpdate($SQL);
}

// Collect datas from a search

/**
*	\fn function getSearchDatas()
*	\brief This function fetches the different values for the search filters.
*	\param None.
*	\return the number of rows which were updated, false if there was a problem.
*	\details This is used in the search page, to fill in the selects, as well as filling the autocomplete feature.
*/
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

/**
*	\fn function getResultsFromQuery($data,$status)
*	\brief This function fetches the different results corresponding to the datas.
*	\param $data --> associative array containing properties ans values \param $status --> status of the user
*	\return the result of the search query in an associative array
*	\details This is used in the search page. This function will return the results corresponding to the search filters the user chose.
*	To make it easier to implement new search filters, the associative array is composed of : the name of the input as the property, and the value of the input as the value.
*	See utils.js for more information on how the array is built.
*
*/
function getResultsFromQuery($data,$status){
	global $BDD_base;
	$SQL="SELECT `COLUMN_NAME`
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language','document_reference','document_version','gatc_baseline');";
	$columns=parcoursRs(SQLSelect($SQL));
	$finalColumns=array();
	foreach ($columns as $key => $value) {
		array_push($finalColumns, strtolower($value["COLUMN_NAME"]));
	} //we fetch all the different attributes in the database, to check if the user somehow changed the name of an input or not.
	//this is done to ensure maximum security.
	$SQL="SELECT reference,subject,version,initial_language,language,project,translator,previous_doc,product,component,GATC_baseline,UNISIG_baseline,site,pic,installation,maintenance,status,availability_x,availability_aec,availability_ftp,availability_sharepoint_vbn,availability_sharepoint_blq,x_link,aec_link,different_aec,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4,document.id_doc,id_document_language,id_document_version,id_document_reference,association_table.id,gatc_baseline.id_baseline  FROM document,document_version,document_language,document_reference,gatc_baseline,association_table WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline   "; //we start to build the query
	foreach ($data as $key => $value) { //loop through the $data array
		if(in_array($key, $finalColumns) || $key=='type'){ //if the property is actually the name of the column in the database, it is treated, else it is ignored.
			if(!is_array($value) && $key!="reference"){//if the data is not an array, it is not necessary to loop through it.
				$SQL.=" AND `".protect(trim($key))."` LIKE '".protect(htmlspecialchars(trim($value)))."'";	
			}else if ($key=="reference"){ //searching by document "reference" is a bit different, the user is allowed to perform a query on both a document reference and a document title.
				$SQL.=" AND (`".protect(trim($key))."` LIKE  '".protect(htmlspecialchars(trim($value)))."' OR `subject` LIKE '".protect(htmlspecialchars(trim($value)))."')"; 
			}else { 
				if($key=="type"){ 
					foreach ($value as $content) {
						$SQL.= " AND `".protect(htmlspecialchars(trim($content))) ."` = '1' ";
					}
				} else if ($key=="initial_language"){ //filtering by language is a bit different, the query must search in both document_reference and document_language tables
					$SQL.=" AND (`initial_language` IN(";
					foreach($value as $content){
						$SQL.="'".protect(htmlspecialchars(trim($content)))."',";
					}
					$SQL=substr($SQL,0,-1);
					$SQL.=") ";
					$SQL.="OR `language` IN(";
					foreach($value as $content){
						$SQL.="'".protect(htmlspecialchars(trim($content)))."',";

					}
					$SQL=substr($SQL,0,-1);
					$SQL.=") )";
				} else {
					$SQL.= " AND `".protect(trim($key))."` IN (";
					foreach ($value as $content) {
						$SQL.="'".protect(htmlspecialchars(trim($content)))."',";
					}
					$SQL=substr($SQL,0,-1);
					$SQL.=") ";

				}
			}
		}
	}
	if($status == "External") //if the user has the status "external", only public documents are displayed.
	$SQL.= " AND status = 'Public'";
	$SQL.=" ORDER BY reference ASC";
	return parcoursRs(SQLSelect($SQL));

}

/**
*	\fn function editDocument($data)
*	\brief This function allows an authorized manager or an administrator to edit a document.
*	\param $data --> associative array containing the values of the document.
*	\return the number of affected rows, or false if there was a problem with the query.
*	\details This function is used when a user wants to edit a document. 
*	See comments in the function for more details.
*
*/
function editDocument($data) {
	//searching for attributes names in the database
	//doing so maximizes security.
	global $BDD_base;
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_reference','document_version','gatc_baseline');";
	$columns=parcoursRs(SQLSelect($SQL));
	$finalColumns=array();
	foreach ($columns as $key => $value) {
		array_push($finalColumns, $value["COLUMN_NAME"]);

	}
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language');";
	$columns=parcoursRs(SQLSelect($SQL));
	$languageColumns=array();
	foreach ($columns as $key => $value) {
		array_push($languageColumns, $value["COLUMN_NAME"]);

	}

	$languageArray=array();
	$SQL="UPDATE document,document_version,document_reference,gatc_baseline,association_table  SET "; //the update query is built here.
	foreach($data as $key=>$value) { //we loop through the different datas
		if(in_array($key, $finalColumns)){ //if the name of the property is identical to a column in the database
			if($value!='') //and if the value is not empty
				$SQL.=$key."='".protect(htmlspecialchars(trim($value)))."',"; //we add it to the query
			else //else we use the default value of the column.
				$SQL.=$key."= DEFAULT,";
		} else if(in_array($key, $languageColumns)){ //if the name of the property corresponds to one column of the document_language table, we store the value in an array 
			$languageArray[$key]=protect(htmlspecialchars(trim($value)));
		}
	}
	//once the loop is over, we check if the language associated with the projet already exists or not. if not, we insert it in the database
	$SQL_language_select = "SELECT id_entry FROM document_language WHERE ";	//this is used to check if an entry already exists
	$SQL_language_insert="INSERT INTO document_language("; //this query is used to insert the new entry if there's no identical entry.
	foreach ($languageArray as $key => $value) {
		$SQL_language_select.= " $key='$value' AND";
		$SQL_language_insert.=$key.",";
	}
	$SQL_language_select=substr($SQL_language_select, 0,-3);
	if(!($idLanguage=SQLGetChamp($SQL_language_select))){ //if a similar entry does not exist, we insert it in the database.
		$SQL_language_insert=substr($SQL_language_insert, 0,-1);
		$SQL_language_insert.=") VALUES (";
		foreach ($languageArray as $key => $value) {
			$SQL_language_insert.= "'$value',";
		}
		$SQL_language_insert=substr($SQL_language_insert, 0,-1);
		$SQL_language_insert.=")";
		$idLanguage=SQLInsert($SQL_language_insert);
	}
	/*$SQL_language_select = "SELECT id_entry FROM document_language WHERE ";	
	$SQL_language_insert="INSERT INTO document_language(";
	foreach ($languageArray as $key => $value) {
		$SQL_language_select.= " $key='$value' AND";
		$SQL_language_insert.=$key.",";
	}
	$SQL_language_select=substr($SQL_language_select, 0,-3);
	if(!($idLanguage=SQLGetChamp($SQL_language_select))){
		$SQL_language_insert=substr($SQL_language_insert, 0,-1);
		$SQL_language_insert.=") VALUES (";
		foreach ($languageArray as $key => $value) {
			$SQL_language_insert.= "'$value',";

		}
		$SQL_language_insert=substr($SQL_language_insert, 0,-1);
		$SQL_language_insert.=")";
		$idLanguage=SQLInsert($SQL_language_insert);
	}*/
	$SQL=substr($SQL,0,-1);
	//finally we update the datas in the database by doing the necessary unions.
	$SQL.=",id_document_language='".$idLanguage."' WHERE document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document.id_doc='".protect($data["document.id_doc"])."'";
	return SQLUpdate($SQL);
}


/**
*	\fn function getUsersFromQuery($data)
*	\brief This function allows to fetch all users whose names begin by $data. (related to administration panel)
*	\param $data --> the string corresponding to the beginning of a user's name.
*	\return an associative array containing all the datas of the users.
*/
function getUsersFromQuery($data){
	$SQL="SELECT * FROM users WHERE last_name LIKE '$data%' OR first_name LIKE '$data%'";
	return parcoursRs(SQLSelect($SQL));
}

/**
*	\fn function editUser($id,$lastname,$firstname,$status,$language,$password="")
*	\brief This function edits the informations of a given user in the database. (related to administration panel)
*	\param $id --> the id of the user whose information will be modified \param $lastname --> the new last name of the user \param $firstname --> the new first name of the user \param $status --> the new status of the user \param $language --> the new language of the user \param $password --> empty by default, this is the new password of the user. if this parameter is empty, the password will not be updated.
*	\return 1 if the user's information have been correctly modified, else false.
*/
function editUser($id,$lastname,$firstname,$status,$language,$password=""){
	$SQL="UPDATE users SET last_name='$lastname', first_name='$firstname', status='$status', language='$language' ";
	if($password!="") $SQL.= ", password='$password' "; //if the password is empty, we ignore it
	$SQL.= " WHERE id_user='$id'";
	return SQLUpdate($SQL);
}

/**
*	\fn function deleteUser($id)
*	\brief This function deletes the user who has the same id as the one in parameters. (related to administration panel)
*	\param $id --> the id of the user who will be deleted
*	\return 1 if the user has been deleted, else false.
*/
function deleteUser($id){
	$SQL="DELETE FROM users WHERE id_user='$id'";
	return SQLDelete($SQL);
}

/**
*	\fn function deleteDoc($id)
*	\brief This function deletes a document in the association_table table.
*	\param $id --> the id of the document that will be deleted
*	\return 1 if the document has been deleted, else false.
*	\brief According to the specification, deleting a document is identical to deleting the corresponding entry in the association_table.
*/
function deleteDoc($id){ 
	$SQL="DELETE FROM association_table WHERE id_doc='$id'";
	return SQLDelete($SQL);
}

/**
*	\fn function managerConnected()
*	\brief This function checks if a manager is connected or not
*	\param None
*	\return an associative array with all the connected manager
*	\brief According to the specification, only one manager should be able to update the database at a given time. If the array is empty, that means the manager is authorized to update the database.
*/
function managerConnected(){
	$SQL="SELECT isConnected FROM users WHERE status='Manager' AND isConnected='1'";
	return parcoursRs(SQLSelect($SQL));
}

/**
*	\fn function createUser($lastName, $firstName, $password, $status, $language)
*	\brief This function creates a new user. (related to administration panel)
*	\param $lastName --> the last name of the new user \param $firstName --> the first name of the new user \param $password --> the password of the new user \param $status --> the status of the new user  \param $language --> the language of the new user
	\return the id of the new user if there was no problem, else a string.
*/
function createUser($lastName, $firstName, $password, $status, $language) {
	$SQL="SELECT id_user FROM users WHERE last_name='$lastName'"; //first, we check if one user doesn't already have the same last name (the last name is used to login)
	if(!($res=SQLGetChamp($SQL))){
		$SQL="INSERT INTO users (last_name, first_name, password, status, language, isConnected) VALUES ('$lastName', '$firstName', '$password', '$status', '$language', 0)";
		return SQLInsert($SQL);
	} else {
		return "failure";
	}
}

/**
*	\fn function deleteDatabase()
*	\brief This function deletes the database. (related to administration panel)
*	\param None.
	\return the number of rows deleted, false if there was a problem.
	\details Everything but the users in the database is reset.
*/
function deleteDatabase() {
	$SQL="SET FOREIGN_KEY_CHECKS = 0; 
	DELETE FROM document; 
	DELETE FROM document_language; 
	DELETE FROM association_table; 
	DELETE FROM document_reference; 
	DELETE FROM document_version; 
	DELETE FROM gatc_baseline;";
	//DELETE FROM users WHERE status NOT LIKE 'Administrator'; 
	$SQL.="SET FOREIGN_KEY_CHECKS = 1;";
	return SQLUpdate($SQL);
}
/**
*	\fn function exportResults($data)
*	\brief This function exports the search results.
*	\param $data --> The search results.
	\return Nothing.
	\details The file is a .csv file. At the beginning of the file, we insert an UTF-8 BOM to encode the characters.
*/
function exportResults($data){
	$file=fopen("php://output","w");
 	fputs( $file, "\xEF\xBB\xBF" ); // UTF-8 BOM 
	foreach ($data as $key => $value) {
		foreach ($data[$key] as $insideKey=> $insideValue) {
			if(substr($insideKey,0,2)=="id") //all the id are removed from the export
				unset($data[$key][$insideKey]);
		}
	}
	fputcsv($file,array_keys($data[0]),";"); //we use ; as delimiters.

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


/**
*	\fn function checkInFile($propertyName)
*	\brief This function fetches the value corresponding to the property.
*	\param $propertyName --> The property to look for.
	\return The value associated to the property.
	\details To properly get the value associated to the property, the file needs to have the following pattern : property=value. It is highly recommended not to use white spaces and tabs. Also, make sure to create a new line after each property associated to its value.
*/
function checkInFile($propertyName){

	if(!file_exists("./properties.txt")){ //In case the file does not exist, it is recreated with DEFAULT values. If it is indeed recreated, the database is locked by default.
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
					fclose($file);
					return $entry[1];
				}
			}
			fclose($file);
		}
		return NULL;
	}
}

/**
*	\fn function lockedDatabase()
*	\brief This function returns the value associated to the property "locked_database" in the properties.txt file.
*	\param None.
*	\return The value associated to the property.
*/
function lockedDatabase(){
	return checkInFile("locked_database");
}

/**
*	\fn function connectedManager()
*	\brief This function returns the value associated to the property "manager" in the properties.txt file.
*	\param None.
*	\return The value associated to the property.
*/
function connectedManager(){
	return checkInFile("manager");
}


/**
*	\fn function changeDatabaseStatus($status)
*	\brief This function changes the value of the property "locked_database" in the properties.txt file.
*	\param $status --> The status in which we want the database to be. (To lock the database, $status needs to be equal to "lock").
*	\return Nothing.
*	\details When using this function, all the users are disconnected expect the administrator.
*/	
function changeDatabaseStatus($status){
	if($status=="lock"){
		writeInFile("locked_database","1");
	} else
		writeInFile("locked_database","0");
	disconnectAll();

}

/**
*	\fn function disconnectAll()
*	\brief This function disconnects all users except the administrator.
*	\param None
*	\return The number of rows affected, else false.
*/
function disconnectAll(){
	$SQL="UPDATE users SET isConnected='0' WHERE status!='Administrator'";
	return SQLUpdate($SQL);
}


/**
*	\fn function writeInFile($propertyName,$value)
*	\brief This function writes a value associated to the given property in parameters.
*	\param $propertyName --> the property whose value needs to be updated. \param $value --> the new value associated to the given property.
*	\return Nothing if there was no problem, else returns "problem".
*	\details This function uses the following pattern : property=value
*/
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



/**
*	\fn function importSQL($filesql)
*	\brief This function imports an SQL file to the database (Related to administration panel)
*	\param $filesql --> the path of the SQL file that needs to be imported.
*	\return Nothing.
*	\details This function should only be used with backup files.
*/

function importSQL($filesql) {
	global $BDD_host;
	global $BDD_user;
	global $BDD_password;
	global $BDD_base;
	
	// Connect to MySQL server
	$connection = mysqli_connect($BDD_host, $BDD_user, $BDD_password, $BDD_base);

	
	// Drop all tables
	$connection->query('SET foreign_key_checks = 0');
	if ($result = $connection->query("SHOW TABLES"))
	{
		while($row = $result->fetch_array(MYSQLI_NUM))
		{
			$connection->query('DROP TABLE IF EXISTS '.$row[0]);
		}
	}
	$connection->query('SET foreign_key_checks = 1');
	
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file("./saves/".$filesql);

	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			mysqli_query($connection, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			// Reset temp variable to empty
			$templine = '';
		}
	}
}

/**
*	\fn function importDatas($tempname)
*	\brief This function imports datas from a CSV file.
*	\param $tempname --> A file fetched thanks to the POST method.
*	\return Nothing.
*	\details This function is difficult to explain. We strongly suggest to look at the code which has a lot of commentaries. Here is an attempt at explaining the algorithm : <br/><code>Find delimiter in the csv file<br/>Put each data of the csv file in an array<br/>Fetch all the attribute from the database<br/>Format datas from the csv file, by removing spaces at the beginning and at the end<br/>Remove utf-8 bom to avoid problems (if the utf-8 bom is not removed, the database column will not be recognized)<br/>Store indexes of essential columns (reference, version, baseline ... for instance)<br/>Build the insertion queries<br/>Check if the entry already exists or not<br>If the document does not exists<br>      It is inserted<br/></code>
*/
function importDatas($tempname){


	global $BDD_base;
	//find csv delimiter
	$delimiter=findDelimiter($tempname); //we accept all kind of csv delimiters, tabs, commas or semicolons
	$csvAsArray=array_map(function($v) use($delimiter){return str_getcsv($v, $delimiter);}, file($tempname)); //anonymous function, we need to use the delimiter previously found
	//this allows to "explode" the csv file to put each data in an array.
	//print_r($csvAsArray);

	//checking if all columns name are in the database
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language','document_reference','document_version','gatc_baseline');";
	echo "<br>";
	$columns=parcoursRs(SQLSelect($SQL));
	//print_r($columns);
	$finalColumns=array();
	foreach ($columns as $key => $value) {
		array_push($finalColumns, $value["COLUMN_NAME"]);

	}
	//print_r($finalColumns);
	//in this part, we build the different queries that will be used to insert datas
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_language');";
	$columns=parcoursRs(SQLSelect($SQL));
	//print_r($columns);
	$languageColumns=array();
	foreach ($columns as $key => $value) {
		array_push($languageColumns, $value["COLUMN_NAME"]);

	}
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_version');";
	$columns=parcoursRs(SQLSelect($SQL));
	//print_r($columns);
	$versionColumns=array();
	foreach ($columns as $key => $value) {
		array_push($versionColumns, $value["COLUMN_NAME"]);

	}
	$SQL="SELECT `COLUMN_NAME` 	
	FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='".$BDD_base."' 
	AND `TABLE_NAME` IN('document_reference');";
	$columns=parcoursRs(SQLSelect($SQL));
	//print_r($columns);
	$referenceColumns=array();
	foreach ($columns as $key => $value) {
		array_push($referenceColumns, $value["COLUMN_NAME"]);

	}
	echo "<br><br>";
	//print_r($referenceColumns);
	//print_r($languageColumns);
	//print_r($versionColumns);
	// echo "<br><br>";
	$fileColumns=$csvAsArray[0];
	foreach ($fileColumns as $key=>$value) { //avoid white spaces in column names.
		$fileColumns[$key]=trim($fileColumns[$key]);
	}
	$size=sizeof($fileColumns);
	$ignoredColumns=array();
    $fileColumns[0]=remove_utf8_bom($fileColumns[0]); //first character of the first data may contain utf_8 BOM, we have to remove it to make it work as intended.
    //echo "<br><br>";
    //print_r($fileColumns);
    for($i=0;$i<$size;$i++){ //we loop through each columns.
    	if(!in_array($fileColumns[$i],$finalColumns)){ //if one of the column name is unknown in the database, we just ignore it.
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

    //echo 'Baseline column :'.$baselineColumn.'<br>Reference column :'. $referenceColumn;
   	echo "<br> Colonnes ignorées :";
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
    		array_push($ignoredRows, $j+1);    		
    	}else{
    		if(empty($csvAsArray[$j][$languageColumn])) {
    			$csvAsArray[$j][$languageColumn]='';
    			$csvAsArray[$j][$translatorColumn]='';
    			$csvAsArray[$j][$projectColumn]='';
    		}
    		echo $idBaseline;
    		if($idRef=referenceExists($csvAsArray[$j][$referenceColumn])) //if the reference of the document already exists, it will not be inserted in the database again
    			$refQuery=false;
    		else 
    			$refQuery=$SQL_doc_ref;
    		if($idRef!=false && $idVersion=versionExists($idRef,$csvAsArray[$j][$versionColumn])) //if the ref of the doc exists, and the version of this ref already exists, it is ignored.
    			$versionQuery=false;
    		else{
    			$versionQuery=$SQL_doc_version;
    		}
    		if($idLanguage=languageExists($csvAsArray[$j][$languageColumn],$csvAsArray[$j][$projectColumn],$csvAsArray[$j][$translatorColumn])) //if the language associated to its project and translator already exists, it is ignored as well.
    			$languageQuery=false;
    		else
    			$languageQuery=$SQL_doc_language;
    		for($k=0;$k<$size;$k++){ //loop through all datas

    			if(!in_array($k, $ignoredColumns) || $k!=$baselineColumn){ //if the column is not in the ignored columns, or if it is not the baseline column
    				if($refQuery != false && in_array($fileColumns[$k],$referenceColumns)){ //if the ref query should not be ignored, we build it with the different datas.
    					if($csvAsArray[$j][$k]!='') //if the data is not empty, we insert it (after securing it)
    						$refQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    					else //else we use the default value.
    						$refQuery.="DEFAULT,";
    				} else if( $languageQuery!=false && in_array($fileColumns[$k],$languageColumns)){ //Same goes for the language query and the version query.
    					$languageQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    				} else if($versionQuery!=false && in_array($fileColumns[$k],$versionColumns)){
    					if($csvAsArray[$j][$k]!='')
    						$versionQuery.="'".protect(htmlspecialchars(trim($csvAsArray[$j][$k])))."',";
    					else 
    						$versionQuery.="DEFAULT,";
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

    		if(!($idDoc=docExists($idRef,$idVersion,$idLanguage))){ //we insert the new document in the document table.
    			$SQL="INSERT INTO document(`id_document_language`,`id_document_version`,`id_document_reference`) VALUES ('".$idLanguage."','".$idVersion."','".$idRef."');";
    			$idDoc=SQLInsert($SQL);
    			$docsInserted++;
    		}
    		echo "id_doc :".$idDoc;
    		if(!($idAssociationTable = associationTableEntry($idBaseline,$idDoc))){ //we also insert it in the association table.
    			$SQL="INSERT INTO association_table (`id_doc`,`id_baseline`) VALUES ('".$idDoc."','".$idBaseline."');";
    			$res=SQLInsert($SQL);
    			$rowsInserted++;
    		}
    		
    	}
    }
    echo "<br> Documents ignorés :";
    print_r($ignoredRows);
    echo "<br>".$rowsInserted ." enregistrements<br>";
    echo $docsInserted." documents ajoutés<br>";
}

/**
*	\fn function findDelimiter($tempname)
*	\brief This function finds the most used character in a csv file (between ;, \\t and ;).
*	\param $tempname --> A file fetched thanks to the POST method.
*	\return The delimiter.
*/
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


/**
*	\fn function remove_utf8_bom($text)
*	\brief This function removes the utf_8 BOM of a text, so that it can be properly used in an array or a string for example.
*	\param $text --> The text which needs to have its BOM removed.
*	\return The text without the utf_8 BOM.
*/
function remove_utf8_bom($text){
	$bom=pack('H*','EFBBBF');
	$text=preg_replace("/^$bom/",'', $text);
	return $text;
}

/**
*	\fn function unknownBaseline($baseline)
*	\brief This function checks if the specified baseline exists or not.
*	\param $baseline --> the baseline to look for in the database.
*	\return the id of the baseline if it exists, else false.
*/

function unknownBaseline($baseline){
	$SQL="SELECT id_baseline from gatc_baseline WHERE gatc_baseline='".protect(htmlspecialchars(trim($baseline)))."'";
	return SQLGetChamp($SQL);
}

/**
*	\fn function referenceExists($reference)
*	\brief This function checks if the specified reference exists or not.
*	\param $reference --> The reference to look for in the document_reference table.
*	\return The id of the reference if it exists, else false.
*/

function referenceExists($reference){
	$SQL="SELECT id_ref FROM document_reference WHERE reference='".protect(htmlspecialchars(trim($reference)))."'";
	return SQLGetChamp($SQL);
}


/**
*	\fn function versionExists($idRef,$version)
*	\brief This function checks if the version associated to the reference already exists or not.
*	\param $idRef --> the id of the reference \param $version --> the version to look for (search in the version column in the document_version table)
*	\return The id of the version if it already exists, else false.
*/

function versionExists($idRef,$version){
	$SQL="SELECT DISTINCT id_version FROM document_reference,document_version,document WHERE document.id_document_reference=id_ref AND document.id_document_version=id_version AND  id_ref='$idRef' AND version='".protect(htmlspecialchars(trim($version)))."'";
	return SQLGetChamp($SQL);
}

/**
*	\fn function languageExists($language, $project, $translator)
*	\brief This function checks if the language associated to its project and translator already exists in the database or not.
*	\param $language --> the language \param $project --> the project associated to the language \param $translator --> the translator associated to the language and the project
*	\return The id of the language entry if it already exists, else false.
*/

function languageExists($language,$project,$translator){
	$SQL="SELECT id_entry FROM document_language WHERE 	language='".protect(htmlspecialchars(trim($language)))."' AND project='".protect(htmlspecialchars(trim($project)))."'AND translator='".protect(htmlspecialchars(trim($translator)))."'";
	return SQLGetChamp($SQL);
}

/**
*	\fn function docExists($idRef, $idVersion, $idLanguage)
*	\brief This function checks if a document already exists or not ( document = reference + version + language)
*	\param $idRef --> the reference of the document \param $idVersion --> the version of the document \param $idLanguage --> the language/translation of the document
*	\return The id of the document if it already exists in the database, else false.
*/
function docExists($idRef,$idVersion,$idLanguage){
	$SQL="SELECT id_doc FROM document WHERE id_document_reference='$idRef' AND id_document_version='$idVersion' AND id_document_language='$idLanguage'";
	return SQLGetChamp($SQL);
}

/**
*	\fn function associationTableEntry($id_baseline, $id_doc)
*	\brief This function checks if a document and a baseline are already associated or not.
*	\param $id_baseline --> the id of the baseline \param $id_doc --> the id of the document
*	\return The id of the language entry if it already exists, else false.
*/
function associationTableEntry($id_baseline,$id_doc){
	$SQL="SELECT id FROM association_table WHERE id_doc='$id_doc' AND id_baseline='$id_baseline'";
	return SQLSelect($SQL);
}

/**
*	\fn function addBaseline($data)
*	\brief This function adds a baseline to the database.
*	\param $data --> $data contains an array where the key is the name of the column and the value associated is the value that needs to but put in the database. 
*	\return The id of the newly added baseline. (If the baseline already exists, it won't be inserted again).
*/
function addBaseline($data) {
	$SQL="SELECT id_baseline FROM gatc_baseline WHERE ";
	foreach ($data as $key => $value) {
		$SQL.= " `".protect(trim($key))."`='".protect(htmlspecialchars(trim($value)))."' AND";
	}
	$SQL=substr($SQL, 0,-3);
	$res=SQLGetChamp($SQL);
	if(!$res){
		$SQL="INSERT INTO gatc_baseline (GATC_baseline,UNISIG_baseline) VALUES ('";
		foreach($data as $value) {
			$SQL.=protect(htmlspecialchars(trim($value)))."','";
		}
		$SQL=substr($SQL,0,-2);
		$SQL.=")";
		return SQLInsert($SQL);
	}
}


//adds a document
/**
*	\fn function addDocument($data)
*	\brief This function adds a single document to the database.
*	\param $data --> $data contains all the necessary information to create a new document. Each key corresponds to one column in the database, and the value associated to the key will be inserted in the database in the corresponding column.
*	\return True if the document was added to the database, else false.
*/

function addDocument($data) {
	global $BDD_base;
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
	$fileColumns=array_keys($data);
	foreach ($fileColumns as $key=>$value) { //avoid white spaces
		$fileColumns[$key]=trim($fileColumns[$key]);
	}
	print_r($fileColumns[4]);
	$size=sizeof($fileColumns);
	$ignoredColumns=array();
	echo "<br><br>";
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
    			case 'language':
    			$languageColumn=$i;
    			break;
    			case 'version':
    			$versionColumn=$i;
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
    //$ignoredColumns contains the indexes of the columns that need to be avoided.
    echo "<br><br>";
    print_r($fileColumns);
    echo "<br><br>";
    //after all the ignored rows have been found, we build the different queries that will be used to insert datas into the database
    $atLeastOne=false;
    $SQL_doc_ref="INSERT INTO document_reference("; //doc reference
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$referenceColumns)){
    		$atLeastOne=true;
    		$SQL_doc_ref.="`".$fileColumns[$i]."`,";
    	}
    }
    if($atLeastOne){
    	$SQL_doc_ref=substr($SQL_doc_ref,0,-1);
    	$SQL_doc_ref.=") VALUES (";
    }
    else
    	$SQL_doc_ref="";
    $atLeastOne=false;
    $SQL_doc_version="INSERT INTO document_version("; //doc version
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$versionColumns)){
    		$atLeastOne=true;
    		$SQL_doc_version.="`".$fileColumns[$i]."`,";
    	}
    }
    if($atLeastOne){
    	$SQL_doc_version=substr($SQL_doc_version,0,-1);
    	$SQL_doc_version.=") VALUES (";
    } else 
    	$SQL_doc_version="";
    $atLeastOne=false;
    $SQL_doc_language="INSERT INTO document_language("; //doc language
    for($i=0;$i<$size;$i++){
    	if(in_array($fileColumns[$i],$languageColumns)){
    		$atLeastOne=true;
    		$SQL_doc_language.="`".$fileColumns[$i]."`,";
    	}
    }
    if($atLeastOne){
    	$SQL_doc_language=substr($SQL_doc_language,0,-1);
    	$SQL_doc_language.=") VALUES (";
    }
    else
    	$SQL_doc_language="";
    echo $SQL_doc_language;
    echo "<br>";
    echo $SQL_doc_version;
    echo "<br>";
    echo $SQL_doc_ref;
    echo "<br>";
    //checking data validity and insertion
    $ignored=false;
    print_r(array_values($data));
    $data=array_values($data);
    if(empty($data[$referenceColumn]) || empty($data[$baselineColumn]) || !($idBaseline=unknownBaseline($data[$baselineColumn])))
    {
    	$ignored=true;
    }
    else 
    {
    	if(!isset($languageColumn)) {
    	 	$data[$languageColumn]='';
    	 	$data[$translatorColumn]='';
    	 	$data[$projectColumn]='';
    	}
    	// echo $idBaseline;
    	if($idRef=referenceExists($data[$referenceColumn]))
    		$refQuery=false;
    	else 
    		$refQuery=$SQL_doc_ref;
    	echo $data[$versionColumn];
    	if($idRef!=false && $idVersion=versionExists($idRef,$data[$versionColumn]))
    		$versionQuery=false;
    	else{
    		$versionQuery=$SQL_doc_version;
    	}
    	if($idLanguage=languageExists($data[$languageColumn],$data[$projectColumn],$data[$translatorColumn]))
    		$languageQuery=false;
    	else
    		$languageQuery=$SQL_doc_language;
    	echo "<h1>".$refQuery."</h1>";
    	for($k=0;$k<$size;$k++){
    		if(!in_array($k, $ignoredColumns) || $k!=$baselineColumn){
    			if($refQuery != false && in_array($fileColumns[$k],$referenceColumns)){
    				$refQuery.="'".protect(htmlspecialchars(trim($data[$k])))."',";
    			} else if($languageQuery!=false && in_array($fileColumns[$k],$languageColumns)){
    				$languageQuery.="'".protect(htmlspecialchars(trim($data[$k])))."',";
    			} else if($versionQuery!=false && in_array($fileColumns[$k],$versionColumns)){
    				$versionQuery.="'".protect(htmlspecialchars(trim($data[$k])))."',";
    			}
    		}
    	}
    	echo "<h1>".$refQuery."</h1>";
    	if($refQuery){
    		$refQuery=substr($refQuery, 0,-1);
    		$refQuery.=");";
    		$idRef=SQLInsert($refQuery);
    	}
    	if($versionQuery){
    		$versionQuery=substr($versionQuery, 0,-1);
    		$versionQuery.=");";
    		$idVersion=SQLInsert($versionQuery);
    	}
    	if($languageQuery){
    		$languageQuery=substr($languageQuery, 0,-1);
    		$languageQuery.=");";
    		$idLanguage=SQLInsert($languageQuery);
    	}
    	echo"<br>Newdoc<hr>";
    	echo "<br>".$refQuery." ".$idRef;
    	echo "<br>".$versionQuery." ".$idVersion;
    	echo "<br>".$languageQuery." ".$idLanguage;
    	echo "<br><br>";

    	if(!($idDoc=docExists($idRef,$idVersion,$idLanguage))){
    		$SQL="INSERT INTO document(`id_document_language`,`id_document_version`,`id_document_reference`) VALUES ('".$idLanguage."','".$idVersion."','".$idRef."');";
    		echo "<h2>".$SQL."</h2>";
    		$idDoc=SQLInsert($SQL);
    	}
    	echo "id_doc :".$idDoc;
    	if(!($idAssociationTable = associationTableEntry($idBaseline,$idDoc))){
    		$SQL="INSERT INTO association_table (`id_doc`,`id_baseline`) VALUES ('".$idDoc."','".$idBaseline."');";
    		echo "<h2>".$SQL."</h2>";
    		$res=SQLInsert($SQL);
    	}
    }

   return $ignored;
}

/**
*	\fn function listBaselines()
*	\brief This function lists all the existing baselines.
*	\param None
*	\return An associative array with all the existing baselines.
*/function listBaselines() {
	$SQL="SELECT DISTINCT GATC_baseline FROM gatc_baseline";
	return parcoursRs(SQLSelect($SQL));
}

?>