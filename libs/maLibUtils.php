<?php


/**
*	\file maLibUtils.php
*	\author TOPINF team
*	\version 1.0
*	\brief This library defines some utilities functions to protect user input.
*/


/**
*	\fn function secure($nom,$type="REQUEST")
*	\brief This function fetches a value from the $_REQUEST array, or the $_SESSION array, and so forth.
*	\param $nom -> the name of the property to fetch \param $type --> the type of the data to fetch
*	\return The data if it exists, else false.
*
*/
function secure($nom,$type="REQUEST")
{	
	switch($type)
	{
		case 'REQUEST': 
		if(isset($_REQUEST[$nom]) && !($_REQUEST[$nom] == "")) 	
			return protect($_REQUEST[$nom]); 	
		break;
		case 'GET': 	
		if(isset($_GET[$nom]) && !($_GET[$nom] == "")) 			
			return protect($_GET[$nom]); 
		break;
		case 'POST': 	
		if(isset($_POST[$nom]) && !($_POST[$nom] == "")) 	
			return protect($_POST[$nom]); 		
		break;
		case 'COOKIE': 	
		if(isset($_COOKIE[$nom]) && !($_COOKIE[$nom] == "")) 	
			return protect($_COOKIE[$nom]);	
		break;
		case 'SESSION': 
		if(isset($_SESSION[$nom]) && !($_SESSION[$nom] == "")) 	
			return $_SESSION[$nom]; 		
		break;
		case 'SERVER': 
		if(isset($_SERVER[$nom]) && !($_SERVER[$nom] == "")) 	
			return $_SERVER[$nom]; 		
		break;
	}
	return false; // if problem
}



/**
*	\fn function protect($str)
*	\brief This function adds slashes before reserved characters. Characters escaped are : 00 = \0 (NUL), 0A = \\n, 0D = \\r, 1A = ctl-Z, 22 = ", 27 = ', 5C = \\.
*	\param $str --> string to add slashes to.
*	\return the string with '\' prepended to reserved characters.
*
*/
function protect($str)
{
	if (is_array($str))
	{
		$nextTab = array();
		foreach($str as $cle => $val)
		{
			$nextTab[$cle] = mb_ereg_replace('[\x00\x0A\x0D\x1A\x22\x27\x5C]', '\\\0', $val);
			$nextTab[$cle] = mb_ereg_replace('[\x60]', '``', $val);
				
		}
		return $nextTab;
	}
	else
		$str= mb_ereg_replace('[\x00\x0A\x0D\x1A\x22\x27\x5C]', '\\\0', $str);	
		return mb_ereg_replace('[\x60]', '``', $str); 
	//return str_replace("'","''",$str); 	//useful for Crosoft db
}


/**
*	\fn function tprint($tab)
*	\brief This function formats an array. This function is mostly used for debugging purposes.
*	\param $tab --> the tab that will be displayed
*	\return None.
*
*/
function tprint($tab)
{
	echo "<pre>\n";
	print_r($tab);
	echo "</pre>\n";	
}


/**
* Currently not used.
*
*/
function headTo($url,$qs="")
{
	// if ($qs != "")	 $qs = urlencode($qs);	

	if ($qs != "") $qs = "&$qs";
 
	header("Location:$url$qs"); 
	die("");

}

?>