<?php

namespace fraldev\modeles;

// fichier de gestion de l'objet autoloader

class autoloader {

    public function __construct() {
        // rôle : enregistrement de la méthode d'autochargement d'un objet
        // paramètres : aucun
        // retour : aucun
        spl_autoload_register([$this, "autoload"]);
    }

    function autoload($class) {
        // role : fonction d'autochargement des classes
        // parametres : $class, la classe instancié
        // retour : true/false, include du fichier ciblé

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
}


