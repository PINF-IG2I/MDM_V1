<?php

include_once "maLibUtils.php";

include_once "modele.php";
/**
 * @file login.php
 * File containing login verification functions
 */

/**
 * This function check if the login/password are legal
 * It stocks session variables
 * stocked info : last_name, first_name, status, language, password, id_user, isConnected
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * @pre login and password must not be empty
 * @param string $login
 * @param string $password
 * @return false or true ;
 */
function checkUser($username,$password)
{
	$res = checkUserDB($username,$password);

	if ($res==array()) return false; 

	// success : we stock the session variables
	if($res[0]["status"]=="Forbidden") return "Forbidden";
	else{
		$_SESSION["last_name"] = $res[0]["last_name"];	
		$_SESSION["first_name"] = $res[0]["first_name"];
		$_SESSION["status"] = $res[0]["status"];
		$_SESSION["language"] = $res[0]["language"];
		$_SESSION["password"] = $res[0]["password"];
		$_SESSION["id_user"] = $res[0]["id_user"];
		$_SESSION["isConnected"] = true;
		updateStatus($res[0]["id_user"],1);
		return true;
	}
}




/**
 * Function to place at every begining of a private page
 * It redirects to the page $urldBad with an error message
 * It dosn't do anything if the user is connected, and if $urlGood is false
 * Else it redirects to $urlGood
 */
	function redirect($urlBad,$urlGood=false)
	{
		if (!secure("isConnected","SESSION")) {
			headTo($urlBad);
		}
		else {
			if ($urlGood)
				headTo($urlGood);
		}
	}

	?>