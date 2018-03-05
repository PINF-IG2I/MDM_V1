<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()
include_once "modele.php";	// Car on utilise la fonction connecterUtilisateur()

/**
 * @file login.php
 * Fichier contenant des fonctions de vérification de logins
 */

/**
 * Cette fonction vérifie si le login/passe passés en paramètre sont légaux
 * Elle stocke les informations sur la personne dans des variables de session : session_start doit avoir été appelé...
 * Infos à enregistrer : pseudo, idUser, heureConnexion, isAdmin
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * @pre login et passe ne doivent pas être vides
 * @param string $login
 * @param string $password
 * @return false ou true ; un effet de bord est la création de variables de session
 */
function checkUser($username,$password)
{
	$res = checkUserDB($username,$password);

	if ($res==array()) return false; 

	// Cas succès : on enregistre pseudo, idUser dans les variables de session 
	// il faut appeler session_start ! 
	// Le controleur le fait déjà !!
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




/**
 * Fonction à placer au début de chaque page privée
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur 
	et arrête l'interprétation si l'utilisateur n'est pas connecté
 * Elle ne fait rien si l'utilisateur est connecté, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
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
