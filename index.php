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

	// The potential view is collected
	$view = secure("view"); 
	/* secure do the code that follows :
	if (isset($_GET["view"]) && $_GET["view"]!="")
	{
		$view = $_GET["view"]
	}*/

	// If the user is not connected, the login page is displayed
	if($_SESSION==array())
		$view="login";
	if (!$view) $view = "search"; 

	if($_SESSION != array() && getIsConnected($_SESSION["id_user"]) != $_SESSION["isConnected"]){
		session_destroy();
		header("Location:index.php?view=login&msg=".urlencode("You have been logged out."));
		die("");
	}	

	// The template linked to its view is displayed
	switch($view)
	{		

		case "login" : 
		include("templates/login.php");
		break;

		case "search":
		include("templates/search.php");
		break;


		default : // if the template corresponding to the view exists, it's displayed
		if (file_exists("templates/$view.php"))
			include("templates/$view.php");

	}


	// In every case, the footer is displayed, except when it's the login page
	if($view!="login")
		include("templates/footer.php");


	
	?>








