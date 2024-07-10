<?php 

namespace fraldev\utils;

use fraldev\modeles\autoloader;

/* code d'initialisation à insérer en début de chaque contrôleur */

// gestion et affichage des erreurs
ini_set("display_errors", 1);       // Aficher les erreurs
error_reporting(E_ALL);             // Toutes les erreurs

// ouverture de la base de donnée
include "ouvertureBDD.php";

// propriété de debug
$bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

// Autochargement des classes et modeles
include "modeles/autoloader.php";
$autoloader = new autoloader();

// activation du mécanisme de session
include "session.php";
session_activation();
