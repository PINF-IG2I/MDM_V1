<?php
$languages= array(
	"EN" => array(
		"language" => "Language",
		"logout" => "Log out",
		"administration" => "Administration",



	),
	"FR" => array(
		"language" => "Langue",
		"logout" => "Déconnexion",
		"administration" => "Administration",

	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
