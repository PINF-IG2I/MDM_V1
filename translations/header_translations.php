<?php
$languages= array(
	"EN" => array(
		"language" => "Language",
		"logout" => "Log out",
		"administration" => "Administration",
		"important" => "Important",
		"addDoc" => "Add a document",
		"addBaseline" => "Add a baseline",
		"cancel" => "Cancel",
		"add" => "Add",
		"gatc" => "GATC Baseline",
		"unisig" => "UNISIG Baseline",


	),
	"FR" => array(
		"language" => "Langue",
		"logout" => "Déconnexion",
		"administration" => "Administration",
		"important" => "Important",
		"addDoc" => "Ajouter un document",
		"addBaseline" => "Ajouter une Baseline",
		"cancel" => "Annuler",
		"add" => "Ajouter",
		"gatc" => "Baseline GATC",
		"unisig" => "Baseline UNISIG",
	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
