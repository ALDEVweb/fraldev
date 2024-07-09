<?php

namespace fraldev\classes;

/*

classe utilisateur étendu de la classe _user

    Utilisation :

        * Parametrage : à définir 
            const LOGIN = "" - champ utilisé pour stocker l'identifiant
            const PWD = "" - champ utilisé pour stockerle mot de passe
            protected $table = "utilisateur" - table correspondante dans la bdd (à modifier si nécessaire)
            protected function define() - fonction de definition des champs de la table
            
        * Méthodes :

*/

class utilisateur extends \fraldev\modeles\_user {

    const LOGIN = "";
    const PWD = "";

    protected $table = "utilisateur";

    protected function define(){
        // création des champs de la class
        // $this->addField("nom du champ", $type = "LINK", $libelle = "Utilisateur", $link = "utilisateur");
    
    }

}