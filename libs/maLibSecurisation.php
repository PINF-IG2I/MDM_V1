<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()

include_once "modele.php";	// Car on utilise la fonction connecterUtilisateur()


/**
* \file maLibSecurisation.php
* \brief This library contains functions to secure the website.
* \author TOPINF team
* \version 1.0
*/

/**
 * This function checks if the user exists. If the user exists and does not have the "Forbidden" status, session datas are created. It also updates the "isConnected" attribute in the database.
 * @pre username and password must not be empty
 * @param string $username
 * @param string $password
 * @return false if the user does not exists, "Forbidden" if the user has the forbidden status, else true.
 */
function checkUser($username,$passwordToCheck)
{
	$res = checkUserDB($username,$password);
	$cryptedPassword = $res[0]["password"];
	if( ($res==array()) && (!hash_equals(crypt($password, $cryptedPassword), $cryptedPassword)) ) return false;

	// Cas succès : on enregistre pseudo, idUser dans les variables de session 
	// il faut appeler session_start ! 
	// Le controleur le fait déjà !!
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
 * This function redirects the user, depending on the fact that the user is connected or not.
 * If the user is not connected, the user is redirected to $urlBad, else it is redirected to $urlGood.
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