<?php
/**
* \file controleur.php
* \author TOPINF team
* \version 1.0
* \brief This file receives all the requests made by the user. 	
*/



session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php"; 
include_once "libs/modele.php"; 

	$addArgs = ""; //this variable is used to redirect the user after the action has been treated.
	$action = secure("action");
	if ($action)
	{
		ob_start ();
		//If the administrator disconnects a user, the user is redirected to the login page and logged out.
		if(isset($_SESSION) && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
			$action='Logout';
		}
		//the current status of the database is fetched from the properties.txt file.
		$lockedDatabase=lockedDatabase();
		//If the database is locked, and the user is not an administrator, he is logged out and redirected to the login page.
		if($lockedDatabase=="1" && !empty($_SESSION && secure("status","SESSION")!='Administrator')){
			updateStatus($_SESSION["id_user"],0);
			session_destroy();
			$addArgs="?view=login&msg=".urlencode("The database is locked. Please try again later.");
		} else {
			switch($action)
			{
				// Connection //////////////////////////////////////////////////
				case 'Identification' :
					if (($username = secure("username","REQUEST")) && ($password = secure("password")))
					{
						$result=checkUser($username,$password);
						if($lockedDatabase=="1" && secure("status","SESSION") != 'Administrator'){
							updateStatus($_SESSION["id_user"],0);
							session_destroy();
							$addArgs="?view=login&msg=".urlencode("The database is locked. Please try again later.");
						} else {
							if("$result"=="Forbidden"){ //if the user has the status "Forbidden", he is redirected to the login page.
								$addArgs="?view=login&msg=".urlencode("You are not allowed to log in. Please contact the administrator.");
							} elseif($result){ //if the user is allowed to log in, he is redirected to the search page.
								$addArgs="?view=search";
							}
							else $addArgs= "?view=login&msg=".urlencode("Wrong password or username.");	
						}
					} //if not all parameters are set, we redirect the user to the login page, with an error message
					else $addArgs= "?view=login&msg=".urlencode("Please fill in all fields.");
				break;

				// Logout ///////////////////////////////////////////////////////
				case 'Logout' :
					if(secure("isConnected","SESSION")){
						updateStatus($_SESSION["id_user"],0); //before destroying the user's session, the isConnected attribute in the database is set to 0.
						session_destroy();
						$addArgs="?view=login&msg=".urlencode("You have been logged out.");
					}
				break;

				// Search ///////////////////////////////////////////////////////
				case 'Search':// this part of the code should only be used with an ajax request
					if(isset($_REQUEST["data"]) && $_REQUEST["data"] !="" && secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
						$data=$_REQUEST["data"];
						$results=getResultsFromQuery($data,secure("status","SESSION"));
						echo json_encode($results);
						die(""); //no need to redirect, the code is stopped there, and the result is sent.
					}
				break;
				// Update document ///////////////////////////////////////////////
				case 'updateDoc':
					$addArgs="?view=search&fail=true";
					if (secure("status","SESSION")=="Administrator" || 	(secure("status","SESSION")=='Manager' && secure("authorized","SESSION")==1))
					{
						$data=$_REQUEST["data"];
						print_r($data);
						$result=editDocument($data);
						echo json_encode($result);
						$addArgs="?view=search";
					}
				break;	

				//Search user ////////////////////////////////////////////////////
				case 'SearchUser': //this part of code should only be used with an ajax request
				if(secure("status","SESSION")=="Administrator" && secure("isConnected","SESSION")){
					$userName=secure("userName");
					$results=getUsersFromQuery($userName);
					echo json_encode($results);
					die("");
				}
				break;

				// Update a user's language /////////////////////////////////
				case 'changeLanguage': //this part of code should only be used with an ajax request
				//This allows the user to change the language
					if(secure("isConnected","SESSION"))
					if ($language =secure("language"))
					{
						$_SESSION["language"]=$language;
						updateLanguage($language,$_SESSION["id_user"]);
					}
				break;


				// Edit user //////////////////////////////////////////////////
				case 'editUser': //related to administration panel
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
							if ($password) //if a new password is specified, it is updated as well.
								editUser($number,$lastName,$firstName,$status,$language, $password);
							else //otherwise only the other informations are updated
								editUser($number,$lastName,$firstName,$status,$language);

							$addArgs="?view=administration";
						}
					}
				break;

				// Delete a user ///////////////////////////////////////////////
				case 'deleteUser': //related to administration panel
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
				// Create a user ///////////////////////////////////////////////
				case 'createUser': //related to administration panel
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
							$res=createUser($lastName,$firstName,$password,$status,$language);
							if($res!="failure")
								$addArgs="?view=administration";
							else
								$addArgs="?view=administration&failUser=true";
						}
					}
				break;
				//Delete a document /!\ Keep in mind that only the corresponding entry in the association_table table will be deleted /!\
				case 'deleteDoc':
					$addArgs="?view=search&fail=true";
					if (secure("status","SESSION")=="Administrator" || (secure("status","SESSION")=='Manager' && secure("authorized","SESSION")==1))
					{
						if($id=secure("id_doc"))
						{
							deleteDoc($id);
							$addArgs="?view=search";
						}
					}
				break;

				//Case to disconnect a user //////////////////////////////////////
				case 'forceLogout':
					$addArgs="?view=administration&fail=true";

					if (secure("status","SESSION")=="Administrator")
					{
						if ($id=secure("id"))
							updateStatus($id,0);
						$addArgs="?view=administration";
					}
				break;

				// Export search results /////////////////////////////////////
				case 'exportResults':
					if(isset($_REQUEST["data"]) && $_REQUEST["data"] !="" && secure("status","SESSION")!="Forbidden" && secure("isConnected","SESSION")){
						$data=json_decode($_REQUEST["data"],true);
						if(!empty($data));
						exportResults($data);
						$addArgs="?view=search";
					}
				break;


				// Delete database except users //////////////////////////////
				case 'resetDB':
					$addArgs="?view=administration&fail=true";
					if (secure("status","SESSION")=="Administrator")
					{
						deleteDatabase();
						$addArgs="?view=administration";
					}
				break;

				// Import database backup ////////////////////////////////////////////
				case 'importDB':
					$addArgs="?view=administration&failDB=true";
					$fileName=secure("filename");
					if (secure("status","SESSION")=="Administrator" && $fileName)
					{
						importSQL($fileName);
						$addArgs="?view=administration&successDB=true";
					}
				break;

				//Import datas thanks to a csv file ///////////////////////////////////
				case 'import': 
					$addArgs="?view=search";
					if(secure("status","SESSION")=='Administrator' || (secure("status","SESSION")=='Manager' && secure("authorized","SESSION")==1)){
						//print_r($_POST);
						//print_r($_FILES); // TODO : check file validity
						$results=importDatas($_FILES["file"]['tmp_name']);
						$addArgs="?view=search&msg=ImportReturn&nbdoc=".$results["docInserted"]."&".http_build_query(array('ignoredRows'=>$results["ignoredRows"]));
					}
				break;

				// Lock database /////////////////////////////////////////////////////
				case 'lockDB': //related to administration panel
					$addArgs="?view=administration&failLock=true";
					if(secure("status","SESSION")=="Administrator"){
						if($lockedDatabase=="1"){
							changeDatabaseStatus("unlock");
							$addArgs="?view=administration&successUnlock=true";
						}
						else{
							changeDatabaseStatus("lock");
							$addArgs="?view=administration&successLock=true";
						}
					}
				break;

				case 'addBaseline':
					if(secure("status","SESSION")=='Administrator' || (secure("status","SESSION")=='Manager' && secure("authorized","SESSION")==1)){
						$data=$_REQUEST["data"];
						addBaseline($data);
						die("");	
					}
				break;

				case 'addDocument':
					if(secure("status","SESSION")=='Administrator' || (secure("status","SESSION")=='Manager' && secure("authorized","SESSION")==1)){
						$data=$_REQUEST["data"];
						addDocument($data);
						die("");	
					}
				break;


			}
		}

	}

$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
header("Location:" . $urlBase . $addArgs);
ob_end_flush();


?>










