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
						$addArgs="?view=login&msg=".urlencode("You are not allowed to log in. Please contact the administrator.");
					} elseif($result){
						$addArgs="?view=search";
					}
					else $addArgs= "?view=login&msg=".urlencode("Wrong password or username.");	
				}
				else $addArgs= "?view=login&msg=".urlencode("Please fill in all fields.");

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
				if(secure("isConnected","SESSION")){
					updateStatus($_SESSION["id_user"],0);
					session_destroy();
					$addArgs="?view=login&msg=".urlencode("You have been logged out.");
				}
			break;

			case 'Search':
					if(isset($_REQUEST["data"]) && $_REQUEST["data"] !="" && secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
						$data=$_REQUEST["data"];
						$results=getResultsFromQuery($data,secure("status","SESSION"));
						echo json_encode($results);
						die(""); //no need to redirect, the code is stopped there, and the result is sent.
					}
			break;

			case 'SearchUser':
				if(secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
					$userName=secure("userName");
					// print_r($userName);
					$results=getUsersFromQuery($userName);
					echo json_encode($results);
					die("");
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

			case 'editDoc':
				$addArgs="?view=search&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					// $id_doc=secure("id_doc");
					// $file=secure("File");
					// $version=secure("Version");
					// $baseline=secure("Baseline");
					// $object=secure("Object");
					// $site=secure("Site");
					// $pic=secure("PIC");
					// $status=secure("status");
					// $initialLanguage=secure("initialLanguage");
					// $installOrMaint=secure("optradio");
					// $product=secure("Product");
					// $component=secure("Component");
					// $translation=secure("Translation");
					// $project=secure("Project");
					// $translator=secure("Translator");
					// $previous_ref=secure("Previous reference");
					// $aec=secure("AEC");
					// $network=secure("Network");
					// $vbn=secure("VBN");
					// $blq=secure("BLQ");
					// $commentaries=secure("Commentaries");
					// $work1=secure("Work 1");
					// $work2=secure("Work 2");
					// $work3=secure("Work 3");
					// $work4=secure("Work 4");

					
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

			case 'createUser':
				$addArgs="?view=administration&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					$lastName=secure("last_name");
					$firstName=secure("first_name");
					$password=secure("password");
					$status=secure("status");
					$language=secure("language");
					if ($lastName && $firstName && $password && $status && $language)
					{
						createUser($lastName,$firstName,$password,$status,$language);
						$addArgs="?view=administration";
					}
				}
			break;

			case 'deleteDoc':
				$addArgs="?view=search&fail=true";
				if (secure("status","SESSION")=="Administrator")
				{
					if($id=secure("id_doc"))
					{
						deleteDoc($id);
						$addArgs="?view=search";
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

			case 'exportResults':
				if(isset($_REQUEST["data"]) && $_REQUEST["data"] !="" && secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
					$data=json_decode($_REQUEST["data"],true);
					if(!empty($data));
						exportResults($data);
					$addArgs="?view=search";
			}
			break;

			case 'resetDB':
				$addArgs="?view=administration&fail=true";

				if (secure("status","SESSION")=="Administrator")
				{
					deleteDatabase();
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










