<?php
$languages= array(
	"EN" => array(
		'user_management' => 'User Management',
		'db_management' => 'Data Base Management',
		'number' => 'Number',
		'last_name' => 'Last Name',
		'first_name' => 'First Name',
		'status' => 'Status',
		'language' => 'Language',
		'importDB' => 'Import Backup',
		'saveDB' => 'Save Database',
		'resetDB' => 'Reset Database',
		'user_name' => 'User Name',
		'search' => 'Search',
		'is_connected' => 'Is Connected'


	),
	"FR" => array(
		'user_management' => "Gestion des Utilisateurs",
		'db_management' => "Gestion de la Base de Donn�es",
		'number' => "Num�ro",
		'last_name' => "Nom",
		'first_name' => "Pr�nom",
		'status' => "Statut",
		'language' => "Langue",
		'importDB' => 'Importer Sauvegarde',
		'saveDB' => 'Sauvegarder',
		'resetDB' => 'R�initialiser',
		'user_name' => 'Nom Utilisateur',
		'search' => 'Rechercher',
		'is_connected' => 'Est Connect�'
	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
