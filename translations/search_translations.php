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
		"choose" => "Choose",
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
		"choose" => "Choose",
		"update_document" => "Modify the document",
		"initialLanguage" => "Initial language"
		


	),
	"FR" => array(
		'search' => "Rechercher",
		'export' => "Exporter",
		'import' => "Importer",
		'administrate' => "Administration",
		"language" => "Langue",
		'key' => "Clé",
		'file' => "Fichier",
		'version' => "Version",
		"pic" => "PIC",
		"status" => "Statut",
		"help" => "Aide",
		"doc_number" => "Numéro document",
		"previous_ref" => "Ancienne référence",
		"version" => "Version",
		"pic" => "Responsable",
		"baseline" => "Baseline",
		"type" => "Type",
		"product" => "Produit",
		"component" => "Composant",
		"choose" => "Choisir",
		"site" => "Site",
		"object" => "Objet",
		"result" => "Résultats",
		"titlePage" => "Recherche",
		"installation" => "Installation",
		"maintenance" => "Maintenance",
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
		"leave" => "Quitter",
		"update_document" => "Modifier le document",
		"initialLanguage" => "Langage initial"
	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];



?>