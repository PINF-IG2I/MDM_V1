<?php


/**
 * @file maLibUtils.php
 * The file defines the access functions of superglobal arrays
 */

/**
 * Check the existence (isset) and the size (not empty) of a parameter in GET, POST, COOKIES, SESSION
 * Return false if the parameter is empty
 * @note the use of empty is critical : 0 is empty !!
 * @param string $nom
 * @param string $type
 * @return string|boolean
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
 * Check the existence (isset) and the size (not empty) of a parameter in GET, POST, COOKIES, SESSION
 * Take an argument defining the value returned in case of an argument absence in the considered array

 * @param string $nom
 * @param string $defaut
 * @param string $type
 * @return string
*/
function getValue($nom,$defaut=false,$type="REQUEST")
{
	if (($resultat = secure($nom,$type)) === false)
		$resultat = $defaut;

	return $resultat;
}

/**
*
* Avoids the SQL injections by protecting the quotes, replacing them by '\'
* Warning : SQL server uses double quotes instead of \'
* @param string $str
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



function tprint($tab)
{
	echo "<pre>\n";
	print_r($tab);
	echo "</pre>\n";	
}


function headTo($url,$qs="")
{
	// if ($qs != "")	 $qs = urlencode($qs);	

	if ($qs != "") $qs = "&$qs";
 
	header("Location:$url$qs"); 
	die("");

}

?>
