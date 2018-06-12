<?php

include_once "config.php";


/**
* \file maLibSQL.pdo.php
* \author TOPINF team
* \version 1.0 
* \brief This file defines the request functions. It requires $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host in config.php, which are loaded when the library is called.
*  <br/> To make the treatments faster, database connection is persistant : we do not close it at the end of a request. We use the pconnect function to do so. 
*/




/**
*	\fn function SQLUpdate($sql)
*	\brief Execute a SQL UPDATE request.
*	\param $sql --> the request to be executed.
*	\return The number of modifications if there was no problem, else false.
*	@pre The variables $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host have to exist.
*
*/
function SQLUpdate($sql)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;

	try {
		$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
	} catch (PDOException $e) {
		die("<font color=\"red\">SQLUpdate/Delete: Erreur de connexion : " . $e->getMessage() . "</font>");
	}

	$dbh->exec("SET CHARACTER SET utf8");
	$res = $dbh->query($sql);
	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLUpdate/Delete: Erreur de requete : " . $e[2] . "</font>");
	}

	$dbh = null;
	$nb = $res->rowCount();
	if ($nb != 0) return $nb;
	else return false;
	
}

// A DELETE is like an UPDATE
/**
*	\fn function SQLDelete($sql)
*	\brief Execute a SQL DELETE request. Same function as SQLUpdate.
*	\param $sql --> the request to be executed.
*	\return The number of modifications if there was no problem, else false.
*
*/
function SQLDelete($sql) {return SQLUpdate($sql);}


	
/**
*	\fn function SQLInsert($sql)
*	\brief Execute a SQL INSERT request.
*	\param $sql --> the request to be executed.
*	\return The last inserted ID.
*
*/
function SQLInsert($sql)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;
	
	try {
		$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
	} catch (PDOException $e) {
		die("<font color=\"red\">SQLInsert: Erreur de connexion : " . $e->getMessage() . "</font>");
	}

	$dbh->exec("SET CHARACTER SET utf8");
	$res = $dbh->query($sql);
	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLInsert: Erreur de requete : " . $e[2] . "</font>");
	}

	$lastInsertId = $dbh->lastInsertId();
	$dbh = null; 
	return $lastInsertId;
}



/**
*	\fn function SQLGetChamp($sql)
*	\brief Execute a SELECT SQL request to get only ONE field.
*	\param $sql --> the request to be executed.
*	\return The value of the field if there is a result, else false.
*
*/
function SQLGetChamp($sql)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;

	try {
		$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
	} catch (PDOException $e) {
		die("<font color=\"red\">SQLGetChamp: Erreur de connexion : " . $e->getMessage() . "</font>");
	}

	$dbh->exec("SET CHARACTER SET utf8");
	$res = $dbh->query($sql);
	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLGetChamp: Erreur de requete : " . $e[2] . "</font>");
	}

	$num = $res->rowCount();
	$dbh = null;

	if ($num==0) return false;
	
	$res->setFetchMode(PDO::FETCH_NUM);

	$ligne = $res->fetch();
	if ($ligne == false) return false;
	else return $ligne[0];

}

/**
*	\fn function SQLSelect($sql)
*	\brief Execute a SQL SELECT request.
*	\param $sql --> the request to be executed.
*	\return An array with the results, else false if there was no results.
*
*/
function SQLSelect($sql)
{	
 	global $BDD_host;
	global $BDD_base;
 	global $BDD_user;
 	global $BDD_password;

	try {
		$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
	} catch (PDOException $e) {
		die("<font color=\"red\">SQLSelect: Erreur de connexion : " . $e->getMessage() . "</font>");
	}

	$dbh->exec("SET CHARACTER SET utf8");
	$res = $dbh->query($sql);
	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLSelect: Erreur de requete : " . $e[2] . "</font>");
	}
	
	$num = $res->rowCount();
	$dbh = null;

	if ($num==0) return false;
	else return $res;
}


/**
*	\fn function parcoursRs($result)
*	\brief Loop through a SQLSelect array and return it as an associative array.
*	\param $result --> the result of a SQLSelect() call.
*	\return The associative array created.
*
*/
function parcoursRs($result)
{
	if  ($result == false) return array();

	$result->setFetchMode(PDO::FETCH_ASSOC);
	while ($ligne = $result->fetch()) 
		$tab[]= $ligne;

	return $tab;
}






?>