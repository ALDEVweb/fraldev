<?php

namespace fraldev\utils;

// gestion de l'autoload standard

function autoloadClasses($class) {

    // Remplacement des backslashes par des slashes et ajout de l'extension PHP
    $classPath = str_replace('\\', '/', $class) . '.php';
    // remplacement du namespace fraldev par .. pour remonter d'un dossier
    $classPath = str_replace('fraldev', '..', $classPath);

    // Chemin du fichier de classe dans le dossier modeles
    if (file_exists($classPath)) {
        include $classPath;
    }

    // Vérification si la classe existe
    if (class_exists($class)) {
        // $class existe
        return true;
    }else {
        // $class n'existe pas
        return false;
    }
}

// Enregistrement de la fonction de chargement de classe
spl_autoload_register("fraldev\utils\autoloadClasses");