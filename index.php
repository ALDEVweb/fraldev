<?php

// routeur de l'application Money
// urtilisation, construire les liens de la façon suivante : index.php?controleur=nom_du_controleur.php

// récupération des superglobal pour réutilisation dans le controleur à inclure (si beosin)
$_GET = isset($_GET) ? $_GET : [];
$_POST = isset($_POST) ? $_POST : [];

// si on a le parametre controleur dans le GET, on le charge et si le fichier existe, on inclus le fichier, sinon on inclus l'accueil
if(isset($_GET["controleur"])){
    // sécurise l'entrée
    $controleur = htmlentities($_GET["controleur"]);
    if(file_exists("controleurs/$controleur.php")) include "controleurs/$controleur.php";
    else{
        // information de l'erreur
        header("HTTP/1.0 404 Not Found");
        include "controleurs/afficher_accueil.php";
    }
} else include "controleurs/afficher_accueil.php";