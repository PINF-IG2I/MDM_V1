<?php
$languages= array(
	"EN" => array(
		'search' => "Search",
		'export' => "Export",
		'import' => "Import",
		'administrate' => "Management",
		"language" => "Language",
		"help" => "Help",
		"doc_number" => "Document number",
		"previous_ref" => "Previous reference",
		"version" => "Version",
		"pic" => "Responsible",
		"baseline" => "Baseline",
		"type" => "Type",
		"product" => "Product",
		"component" => "Component",
		"site" => "Site",
		"object" => "Object",
		"result" => "Results",
		"titlePage" => "Search",
		"installation" => "Installation",
		"maintenance" => "Maintenance",
		


	),
	"FR" => array(
		'search' => "Rechercher",
		'export' => "Exporter",
		'import' => "Importer",
		'administrate' => "Administration",
		"language" => "Langue",
		"help" => "Aide",
		"doc_number" => "Numéro document",
		"previous_ref" => "Ancienne référence",
		"version" => "Version",
		"pic" => "Responsable",
		"baseline" => "Baseline",
		"type" => "Type",
		"product" => "Produit",
		"component" => "Composant",
		"site" => "Site",
		"object" => "Objet",
		"result" => "Résultats",
		"titlePage" => "Recherche",
		"installation" => "Installation",
		"maintenance" => "Maintenance"
	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];



?>