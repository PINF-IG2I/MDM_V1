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
		"x_link" => "X Link",
		"ftp_link" => "FTP Link",
		"vbn" => "VBN",
		"blq" => "BLQ",
		"availability_aec" => "AEC available",
		"availability_x" => "X available",
		"availability_ftp" => "FTP available",
		"availability_sharepoint_vbn" => "Sharepoint VBN available",
		"availability_sharepoint_blq" => "Sharepoint BLQ available",
		"commentaries" => "Comments",
		"work1" => "Work 1",
		"work2" => "Work 2",
		"work3" => "Work 3",
		"work4" => "Work 4",
		"save" => "Save",
		"delete" => "Delete",
		"leave" => "Leave",
		"close" => "Close",
		"choose" => "Choose",
		"update_document" => "Modify the document",
		"details_document" => "Document details",
		"initialLanguage" => "Initial language",
		'sure_delete_doc' => 'Are you sure you want to delete the document',
		'public' => "Public",
		'internal' => "Internal",
		'draft' => "Draft",
		'future' => "Future",
		'obsolete' => "Obsolete",
		"export" => "Export the results of the search",
		"manager_connected" => "A manager is connected, datas may change.",
		"manager_in_charge" => "You are allowed to update datas.",
		"manager_not_in_charge" => "Another manager already has the possibility to update datas.",
		"no result" => "No results found.",
		"sure_edit_doc" => "Are you sure you want to edit the document ?",
		"edit" => "Edit",
		"import" => "Import",
		"reference" => "Reference",
		"reference_or_title" => "Reference or document title"

		


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
		"close" => "Fermer",
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
		"x_link" => "Lien X",
		"ftp_link" => "Lien FTP",
		"availability_aec" => "AEC disponible",
		"availability_x" => "X disponible",
		"availability_ftp" => "FTP disponible",
		"availability_sharepoint_vbn" => "Sharepoint VBN disponible",
		"availability_sharepoint_blq" => "Sharepoint BLQ disponible",
		"commentaries" => "Commentaires",
		"work1" => "Work 1",
		"work2" => "Work 2",
		"work3" => "Work 3",
		"work4" => "Work 4",
		"save" => "Sauvegarder",
		"delete" =>"Supprimer",
		"leave" => "Quitter",
		"update_document" => "Modifier le document",
		"details_document" => "Détails du document",
		"initialLanguage" => "Langage initial",
		'sure_delete_doc' => 'Êtes-vous sur de vouloir supprimer le document',
		'public' => "Public",
		'internal' => "Interne",
		'draft' => "Draft",
		'future' => "Futur",
		'obsolete' => "Obsolète",
		'export' => "Exporter les résultats de la recherche",
		"manager_connected" => "Un gestionnaire est connecté, les données sont susceptibles de changer.",
		"manager_in_charge" => "Vous êtes autorisés à modifier des données de la base.",
		"manager_not_in_charge" => "Un autre manager a déjà la possibilité de modifier les données de la base.",
		"no_result" => "Aucun résultat.",
		"sure_edit_doc" => "Êtes-vous sur de vouloir éditer le document ?",
		"edit" => "Éditer",
		"import" => "Importer",
		"reference" => "Référence",
		"reference_or_title" => "Référence ou titre du document"
	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];



?>