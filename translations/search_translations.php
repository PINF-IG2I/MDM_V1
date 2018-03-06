<?php
$languages= array(
	"EN" => array(
		'search' => "Search",
		'language' => "Language"


	),
	"FR" => array(
		'search' => "Rechercher",
		'export' => "Exporter",
		'import' => "Importer",
		'administrate' => "Administration",
		"language" => "Langue",
		"help" => "Aide",
		"doc_number" => "Numéro document",
		"previous_doc" => "Ancienne référence",
		"version" => "Version",
		"pic" => "PIC",
		"baseline" => "Baseline",
		"type" => "Type",
		"product" => "Produit",
		"component" => "Composant",
		"site" => "Site",
		"subject" => "Objet",
		"result" => "Résultats",
		"titlePage" => "Recherche"
	)
);

$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];




?>