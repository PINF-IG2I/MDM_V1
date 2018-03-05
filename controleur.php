<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$addArgs = ""; //this variable is used to redirect the user after the action has been treated.

	if ($action = secure("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		if($_SESSION != array() && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
			$action='Logout';
		}	
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Identification' :
				// On verifie la presence des champs login et passe
				if (($username = secure("username","REQUEST")) && ($password = secure("password")))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (checkUser($username,$password)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						$addArgs="?view=search";
					}
					else $addArgs= "?view=login&msg=".urlencode("Wrong password or username.");	
				}
				else $addArgs= "?view=login&msg=".urlencode("Please fill in all fields.");

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
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










