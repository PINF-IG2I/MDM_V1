<?php
session_start();
/**
* \file controleur.php
* \brief This page treats data and calls functions from modele.php if needed
* \author
* \version
*/
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$addArgs = ""; //this variable is used to redirect the user after the action has been treated.

	if ($action = secure("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";

		if($_SESSION != array() && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
			$action='Logout';
		}	
		switch($action)
		{
			
			
			// Connection //////////////////////////////////////////////////
			case 'Identification' :
				// The username and the password are checked
				if (($username = secure("username","REQUEST")) && ($password = secure("password")))
				{
					// On verifie l'utilisateur,
					// The user is checked
					// Then session variables are created (maLibSecurisation)
					if (checkUser($username,$password)) {
						$addArgs="?view=search";
					}
					else $addArgs= "?view=login&msg=".urlencode("Wrong password or username.");	
				}
				else $addArgs= "?view=login&msg=".urlencode("Please fill in all fields.");

				// Automatical redirection to the index page
			break;

			case 'Logout' :
				// the session is destroyed and the user is logged out
				session_destroy();
				$addArgs="?view=login&msg=".urlencode("You have been logged out.");
			break;

			case 'Search':

			break;




		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $addArgs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










