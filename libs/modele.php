<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");
include_once("maLibUtils.php");

function listUsers()
{
	// NB : la présence du symbole '=' indique la valeur par défaut du paramètre s'il n'est pas fourni
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "select * from users ORDER BY id_user";

	return parcoursRs(SQLSelect($SQL));

}

// Collect informations from every document
function listerDocs() {
	$SQL = "SELECT document.id_doc,version,initial_language,name,subject,site,PIC,document_version.status,component_name,subsystem_name,GATC_baseline,language,project,translator,previous_doc,installation,maintenance,x_link,aec_link,ftp_link,sharepoint_vbn_link,sharepoint_blq_link,remarks,working_field_1,working_field_2,working_field_3,working_field_4 FROM document,document_version,document_language,document_reference,gatc_baseline,association_table, components, etcs_subsystem WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document_reference.product=etcs_subsystem.id AND document_reference.component=components.id  ";
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
	$SQL="SELECT * FROM etcs_subsystem";
	$res["product"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT * FROM components";
	$res["component"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT initial_language, language FROM document_reference,document_language";
	$res["language"]=parcoursRs(SQLSelect($SQL));
	return $res;
}

function getResultsFromQuery($data){
	$SQL="SELECT * FROM document,document_version,document_language,document_reference,gatc_baseline,association_table, components, etcs_subsystem WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document_reference.product=etcs_subsystem.id AND document_reference.component=components.id  ";
	foreach ($data as $key => $value) {
		if(!is_array($value)){
			protect($key);
			protect($value);
			$SQL.=" AND ".$key." LIKE '".$value."'";	
		} else {
			if($key=="type"){
				foreach ($value as $content) {
					protect($value);
					protect($content);
					$SQL.= " AND ".$content ." = '1' ";
				}
			} else {
				protect($key);
				$SQL.= " AND ".$key." IN (";
				foreach ($value as $content) {
					protect($content);
					$SQL.="'$content',";
				}
				$SQL=substr($SQL,0,-1);
				$SQL.=") ";

			}
		}
	}
	return parcoursRs(SQLSelect($SQL));

}

// Edit the informations of a specified user
function editUser($id,$lastname,$firstname,$status,$language,$password=""){
	$SQL="UPDATE users SET last_name='$lastname', first_name='$firstname', status='$status', language='$language' ";
	if($password!="") $SQL.= ", password='$password' ";
	$SQL.= " WHERE id_user='$id'";
	return SQLUpdate($SQL);
}

// Edit the informations of a specified document
function editDoc() {
	//todo
}

// Delete a specified user
function deleteUser($id){
	$SQL="DELETE FROM users WHERE id_user='$id'";
	return SQLDelete($SQL);
}

// Delete a specified document
function deleteDoc($id){ //TODO : grosse requête qui delete le doc en prenant en compte les clés étrangères
	//A refaire : supprimer un doc revient à le supprimer dans association table
	$SQL="DELETE FROM document WHERE id_doc='$id'";
	return SQLDelete($SQL);
}



function createUser($lastName, $firstName, $password, $status, $language) {
	$SQL="INSERT INTO users (last_name, first_name, password, status, language, isConnected) VALUES ('$lastName', '$firstName', '$password', '$status', '$language', 0)";
	return SQLInsert($SQL);
}


// Delete a specified document
function deleteDoc($id){ //TODO : grosse requête qui delete le doc en prenant en compte les clés étrangères
	$SQL="DELETE FROM document WHERE id_doc='$id'";
	return SQLDelete($SQL);
}


?>
