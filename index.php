<?php
session_start();


/**
* \file index.php
* \brief This page is the one that determines which template is displayed thanks to the 'view' attribute
* Each form sends its data to data.php then it's redirected to the index to display the correct view
* \author
* \version
*/


include_once "libs/maLibUtils.php";
include_once "libs/maLibBootstrap.php";
include_once "libs/maLibSecurisation.php";


ob_start();

	// The potential view is collected
$view = secure("view"); 
	/* secure do the code that follows :
	if (isset($_GET["view"]) && $_GET["view"]!="")
	{
		$view = $_GET["view"]
	}*/

	// If the user is not connected, the login page is displayed
	if($_SESSION != array() && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
		session_destroy();
		header("Location:./index.php?view=login&msg=".urlencode("You have been logged out."));
		die("");
	}
	if(lockedDatabase()=="1" && secure("status","SESSION")!='Administrator'){
		if(secure("isConnected","SESSION")){
			updateStatus($_SESSION["id_user"],0);
			session_destroy();
		}
		$addArgs="?view=login&msg=".urlencode("The database is locked. Please try again later.");
	}
	if(secure("status","SESSION")=='Manager'){
		$id_manager=connectedManager();
		if($id_manager==secure("id_user","SESSION")){
			$_SESSION["authorized"]=1;
		} else if (getIsConnected($id_manager)=="0" || ($id_manager=="")) {
			writeInFile("manager",secure("id_user","SESSION"));
			$_SESSION["authorized"]=1;
		} else $_SESSION["authorized"]=0;
	} 
	if (!$view) {
		if(secure("isConnected","SESSION"))
			$view = "search";
		else
			$view="login"; 
	}	
	// The template linked to its view is displayed
	switch($view)
	{		

		default : // if the template corresponding to the view exists, it is displayed
		if (file_exists("templates/$view.php")){
			if($view!="login"){
				include_once("./translations/header_translations.php");
				include("templates/header.php");
			}
			if(file_exists("./translations/".$view."_translations.php"))
				include("./translations/".$view."_translations.php");
			include("./templates/$view.php");
			

		}

	}


	// In every case, the footer is displayed, except when it's the login page
	if($view!="login")
		include("templates/footer.php");


	ob_flush();	
	?>



	</html>






