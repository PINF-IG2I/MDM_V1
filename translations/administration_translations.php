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
		'is_connected' => 'Is Connected',
		'user' => 'User',
		'password' => 'Password',
		'edit' => 'Edit',
		'delete' => 'Delete',
		'internal' => 'Internal',
		'external' => 'External',
		'inhibited' => 'Inhibited',
		'manager' => 'Manager',
		'administrator' => 'Administrator',
		'disconnect' => 'Disconnect User'


	),
	"FR" => array(
		'user_management' => "Gestion des Utilisateurs",
		'db_management' => "Gestion de la Base de Données",
		'number' => "Numéro",
		'last_name' => "Nom",
		'first_name' => "Prénom",
		'status' => "Statut",
		'language' => "Langue",
		'importDB' => 'Importer Sauvegarde',
		'saveDB' => 'Sauvegarder',
		'resetDB' => 'Réinitialiser',
		'user_name' => 'Nom Utilisateur',
		'search' => 'Rechercher',
		'is_connected' => 'Est Connecté',
		'user' => 'Utilisateur',
		'password' => 'Mot de Passe',
		'edit' => 'Modifier',
		'delete' => 'Supprimer',
		'internal' => 'Interne',
		'external' => 'Externe',
		'inhibited' => 'Inhibé',
		'manager' => 'Gestionnaire',
		'administrator' => 'Administrateur',
		'disconnect' => 'Déconnecter l\'Utilisateur'

	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
