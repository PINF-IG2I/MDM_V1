<?php

include_once "config.php";

/**
 * @file maLibSQL.php
 * This file defines the request functions
 * It requires $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host in config.php, which are loaded when the library is called
 * @note To make the treatments faster, databse requests are persistant: we do not close them at every request end. 
 * For that, we use pconnect function
 */


/**
 * Execute an UPDATE request. Return the number of modifications or false if error.
 * We test with === to On testera donc avec === to distinguish false and 0 
 * @return the number of affected recordings, or false if problem.
 * @param string $sql
 * @pre The variables $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host have to exist.
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
function SQLDelete($sql) {return SQLUpdate($sql);}


/**
 * Execute an INSERT request
 * @param string $sql
 * @pre The variables $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host have to exist.
 * @return Insert id
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
* Execute a SELECT request in a SQL SERVER database, to get only a field (the request must therefore relate only to one value)
* Return false if no results, or the value of the field
* @pre The variables $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host have to exist.
* @param string $SQL
* @return false|string
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
 * Execute a SELECT request in a SQL SERVER database
 * Return false if no results, or the values otherwise
 * @pre The variables $BDD_login $BDD_login, $BDD_password $BDD_base and $BDD_host have to exist.
 * @param string $SQL
 * @return false|resource
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
*
* Browse the recordings of a mysql result and return them as an associative array
* We can then show it with the print_r function or browse it with foreach
* @param mysql result $result
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
