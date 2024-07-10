<?php

// ouverture de la bdd


namespace fraldev\utils;



// création de la variable global
global $bdd;

// création de la chaine de connexion et récupération des exceptions
try {
    $bdd = new \PDO("mysql:host=localhost;dbname=;charset=UTF8", "", "");
} catch (\Throwable $exception) {
    // Dés qu'en exception est déclenchée, on sort du bloc derrière tru et on exécute ce bloc
    echo "Une erreur a été rencontrée lors de la connexion à la base de donnée";
    print_r($exception);
}
