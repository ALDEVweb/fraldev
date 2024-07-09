<?php

namespace fraldev\controleurs;

// programme de test d'un controlleur

// forcer les parametre GET, POST ou tout autre necessaire au fonctionnement d'un controlleur
$_GET = ["statut" => "génération mot de passe"]; // mettre les champs valeur désiré
$_POST = []; // mettre les champs valeur désiré
$_REQUEST = array_merge($_GET, $_POST); // si on a des test sur request on rassemble les 2 tableaux


// on inclu le controleur 
include "test_methode.php"; // pas de header car on a pas initialiser ce fichier