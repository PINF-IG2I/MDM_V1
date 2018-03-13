<?php
$languages= array(
	"EN" => array(
		'key' => 'Key',
		'file' => 'File',
		'status' => 'Status',
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
		"product" => "Product",
		"component" => "Component",
		"translation" => "Translation",
		"project" => "Project",
		"translator" => "Translator",
		"previous_ref" => "Previous reference",
		"aec" => "AEC",
		"up_to_date_aec" => "Up to date AEC",
		"network" => "Network",
		"vbn" => "VBN",
		"blq" => "BLQ",
		"commentaries" => "Comments",
		"work1" => "Work 1",
		"work2" => "Work 2",
		"work3" => "Work 3",
		"work4" => "Work 4",
		"save" => "Save",
		"delete" => "Delete",
		"leave" => "Leave",
		"choose" => "Choose"


	),
	"FR" => array(
		'search' => "Rechercher",
		'export' => "Exporter",
		'import' => "Importer",
		'administrate' => "Administration",
		"help" => "Aide",
		'key' => "Clé",
		'file' => "Fichier",
		'version' => "Version",
		'baseline' => "Baseline",
		"object" => "Objet",
		"site" => "Site",
		"pic" => "PIC",
		"status" => "Statut",
		"choose" => "Choisir",
		"language" => "Langue",
		"installation" => "Installation",
		"maintenance" => "Maintenance",
		"product" => "Produit",
		"component" => "Composant",
		"translation" => "Traduction",
		"project" => "Projet",
		"translator" => "Traducteur",
		"previous_ref" => "Référence précédente",
		"aec" => "AEC",
		"up_to_date_aec" => "AEC à jour",
		"network" => "Réseau",
		"vbn" => "VBN",
		"blq" => "BLQ",
		"commentaries" => "Commentaires",
		"work1" => "Work 1",
		"work2" => "Work 2",
		"work3" => "Work 3",
		"work4" => "Work 4",
		"save" => "Sauvegarder",
		"delete" =>"Supprimer",
		"leave" => "Quitter"

	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
