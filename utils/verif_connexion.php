<?php

namespace fraldev\utils;

/*

Code à inclure dans les controleurs qui ont besoin de la connexion

*/


// Si on n'est pas connexté : rediriger / afficher le formulaire de connexion
if ( ! session_isconnected()) {
    include "templates/pages/connexion.php";
    exit;
}