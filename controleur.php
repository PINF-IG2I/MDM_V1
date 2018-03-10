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
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		if(isset($_SESSION) && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
			$action='Logout';
		}	
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Identification' :
				// On verifie la presence des champs login et passe
				if (($username = secure("username","REQUEST")) && ($password = secure("password")))
				{
					$result=checkUser($username,$password);
					if("$result"=="Forbidden"){
						$addArgs="?view=login&msg=".urlencode("You are not allowed to log in.");
					} elseif($result){
						$addArgs="?view=search";
					}
					else $addArgs= "?view=login&msg=".urlencode("Wrong password or username.");	
				}
				else $addArgs= "?view=login&msg=".urlencode("Please fill in all fields.");

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
				updateStatus($_SESSION["id_user"],0);
				session_destroy();
				$addArgs="?view=login&msg=".urlencode("You have been logged out.");
			break;

			case 'Search':
					if(isset($_REQUEST["data"]) && $_REQUEST["data"] !="" && secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
						$data=$_REQUEST["data"];
						$results=getResultsFromQuery($data);
						echo json_encode($results);
						die(""); //no need to redirect, the code is stopped there, and the result is sent.
					}
			break;

			case 'changeLanguage':
				if(secure("isConnected","SESSION"))
				if ($language =secure("language"))
				{
					$_SESSION["language"]=$language;
					updateLanguage($language,$_SESSION["id_user"]);
					$addArgs="?view=administration";
				}
			break;

			case 'editUser':
				$addArgs="?view=administration&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					$number=secure("number");
					$lastName=secure("last_name");
					$firstName=secure("first_name");
					$status=secure("status");
					$language=secure("language");
					$password=secure("password");
					if ($number && $lastName && $firstName && $status && $language)
					{
						if ($password)
							editUser($number,$lastName,$firstName,$status,$language, $password);
						else
							editUser($number,$lastName,$firstName,$status,$language);
						
						$addArgs="?view=administration";
					}
				}
			break;
			
			case 'deleteUser':
				$addArgs="?view=administration&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					if ($number=secure("number"))
					{
						deleteUser($number);
						$addArgs="?view=administration";
					}
				}
			break;
			
			case 'forceLogout':
				$addArgs="?view=administration&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					if ($id=secure("id"))
					updateStatus($id,0);
					$addArgs="?view=administration";
				}
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










