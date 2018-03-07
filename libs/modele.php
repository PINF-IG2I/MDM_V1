<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");


function listerUtilisateurs($classe = "both")
{
	// NB : la présence du symbole '=' indique la valeur par défaut du paramètre s'il n'est pas fourni
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "select * from users";
	if ($classe == "bl")
		$SQL .= " where blacklist=1";
	if ($classe == "nbl")
		$SQL .= " where blacklist=0";
	
	// echo $SQL;
	return parcoursRs(SQLSelect($SQL));

}


function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai
	$SQL = "UPDATE users SET blacklist=1 WHERE id='$idUser'";
	// les apostrophes font partie de la sécurité !! 
	// Il faut utiliser addslashes lors de la récupération 
	// des données depuis les formulaires

	SQLUpdate($SQL);
}

function autoriserUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à faux 
	$SQL = "UPDATE users SET blacklist=0 WHERE id='$idUser'";
	SQLUpdate($SQL);
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


function getLanguages(){
	$SQL="SELECT DISTINCT language FROM users";
	return parcoursRs(SQLSelect($SQL));
}

function updateLanguage($language,$id){
	$SQL="UPDATE users SET language='$language' WHERE id_user=$id";

	return SQLUpdate($SQL);
}


function getSearchDatas(){
	$SQL="SELECT * FROM gatc_baseline";
	$res["baseline"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT site FROM document_version";
	$res["site"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT * FROM etcs_subsystem";
	$res["product"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT * FROM components";
	$res["component"]=parcoursRs(SQLSelect($SQL));
	$SQL="SELECT DISTINCT language FROM document_language";
	$res["language"]=parcoursRs(SQLSelect($SQL));

	return $res;
}

function getResultsFromQuery($data){
	$SQL="SELECT * FROM document,document_version,document_language,document_reference,gatc_baseline,association_table, components, etcs_subsystem WHERE document.id_document_language=document_language.id_entry AND document.id_document_version=document_version.id_version AND document.id_document_reference=document_reference.id_ref AND association_table.id_doc=document.id_doc AND association_table.id_baseline=gatc_baseline.id_baseline AND document_reference.product=etcs_subsystem.id AND document_reference.component=components.id  ";
	foreach ($data as $key => $value) {
		if(!is_array($value)){
			$SQL.=" AND ".$key." LIKE '".$value."'";	
		} else {
			if($key=="type"){
				foreach ($value as $content) {
					$SQL.= " AND ".$content ." = '1' ";
				}
			} else {
				$SQL.= " AND ".$key." IN (";
				foreach ($value as $content) {
					$SQL.="'$content',";
				}
				$SQL=substr($SQL,0,-1);
				$SQL.=") ";

			}
		}
	}


	return parcoursRs(SQLSelect($SQL));
}


?>
