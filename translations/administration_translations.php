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
		'lockDB' => 'Lock Database',
		'unlockDB' => 'Unlock Database',
		'important' => 'Important',
		'user_name' => 'User Name',
		'search' => 'Search',
		'is_connected' => 'Is Connected',
		'user' => 'User',
		'password' => 'Password',
		'edit' => 'Edit',
		'delete' => 'Delete',
		'internal' => 'Internal',
		'external' => 'External',
		'forbidden' => 'Forbidden',
		'manager' => 'Manager',
		'administrator' => 'Administrator',
		'disconnect' => 'Disconnect User',
		'create_user' => 'Create User',
		'edit_user' => 'Edit user',
		'delete_user' => 'Delete User',
		'delete_database' => 'Delete Database',
		'sure_delete_user' => 'Are you sure you want to delete the user',
		'sure_delete_database' => 'Are you sure you want to delete the database ',
		'sure_unlock_database' => 'Are you sure you want to unlock the database ',
		'sure_lock_database' => 'Are you sure you want to lock the database ',
		'close' => 'Close',
		'success' => 'Sucess!',
		'fail' => 'Error...',
		'successDB_message' => 'The database was successfully changed!',
		'successLock_message' => 'The database was successfully locked!',
		'successUnlock_message' => 'The database was successfully unlocked!',
		'failDB_message' => 'There was an error during the file transfert, please try again...',
		'failLock_message' => 'There was an error during the locking of the database, please try again...',
		'failUnlock_message' => 'There was an error during the unlocking of the database, please try again...',
		'failCreateUser_message' => 'A user already has this last name.'


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
		'lockDB' => 'Verrouiller la base',
		'unlockDB' => 'Déverrouiller la base',
		'important' => 'Important',
		'user_name' => 'Nom Utilisateur',
		'search' => 'Rechercher',
		'is_connected' => 'Est Connecté',
		'user' => 'Utilisateur',
		'password' => 'Mot de Passe',
		'edit' => 'Modifier',
		'delete' => 'Supprimer',
		'internal' => 'Interne',
		'external' => 'Externe',
		'forbidden' => 'Inhibé',
		'manager' => 'Gestionnaire',
		'administrator' => 'Administrateur',
		'disconnect' => 'Déconnecter l\'Utilisateur',
		'create_user' => 'Créer Utilisateur',
		'edit_user' => 'Éditer l\'Utilisateur',
		'delete_user' => 'Supprimer User',
		'delete_database' => 'Supprimer les données de la base',
		'sure_delete_user' => 'Êtes-vous sûr de vraiment vouloir supprimer l\'utilisateur',
		'sure_delete_database' => 'Êtes-vous sûr de vraiment vouloir supprimer la base ',
		'sure_unlock_database' => 'Êtes-vous sûr de vraiment vouloir déverrouiller la base ',
		'sure_lock_database' => 'Êtes-vous sûr de vraiment vouloir verrouiller la base ',
		'close' => 'Fermer',
		'successDB' => 'Succès !',
		'fail' => 'Erreur...',
		'successDB_message' => 'La base de données a été changée avec succès !',
		'successLock_message' => 'La base de données a été verouillée avec succès !',
		'successUnlock_message' => 'La base de données a été déverrouillée avec succès !',
		'failDB_message' => 'Il y a eu une erreur dans le transfert de fichier, merci de réessayer...',
		'failLock_message' => 'Il y a eu une erreur dans le verrouillage de la base de données, merci de réessayer...',
		'failUnlock_message' => 'Il y a eu une erreur dans le déverrouillage de la base de données, merci de réessayer...',
		'failCreateUser_message' => 'Un utilisateur possède déjà ce nom.'



	)

);


$default="EN";
$requested=$_SESSION["language"];
$languageUsed = isset($languages[$requested]) ? $requested : $default;
$translation = $languages[$languageUsed];


?>
