<?php

namespace fraldev\modeles;

// classe permetant de gérer un champ de base de données

class _field {

    protected $name;        // nom du champ
    protected $type;        // type de champ : TXT, DATE, DATETIME, NUM, LINK
    protected $libelle;     // Libellé du champ
    protected $link;        // Objet pointé si lien

    protected $object;      // Objet dont ce champ fait partie

    protected $value;       // valeur de l'objet

    protected $target;      // Objet pointé si chargé (non maitrisé à ce stade)


    function __construct($object, $name, $type = null, $libelle  = null, $link = null) {
        // Paramètres :
        //      $object:    objet de ratachement
        //      $name;        // nom du champ
        //      $type;        // type de champ : TXT, DATE, DATETIME, NUM, LINK - par defaut : TXT
        //      $libelle;     // Libellé du champ - par défaut : nom du champ
        //      $link;        // Objet pointé si lien (facultatif) - si c'est un lien et que link n'est pas précisé,link = name

        $this->object = $object;
        $this->name = $name;
        $this->type = empty($type) ? "TXT" : $type; 
        $this->libelle = empty($libelle) ? $name : $libelle;
        if ($type == "LINK") $this->link = empty($link) ? $name : $link;
        else $this->link = $name;
    }

    function get() {
        // Role: récupérer la valeur d'un champ
        // Paramètres : aucun
        // Retour : la valeur du champ

        return $this->value;
    }

    function set($value) {
        // Role: charger la valeur du champ
        // Paramètres : $value : la valeur à charger
        // Retour : true false

        $this->value = $value;

        return true; 
    }

    function html() {
        // Role: récupérer la valeur HTML du champ
        // Paramètres : aucun
        // Retour : la valeur du champ avec la gestion des balise html

        return nl2br(htmlentities($this->get()));        
    }

    function type() {
        // Role: récupérer le type du champ
        // Paramètres : aucun
        // Retour : le code du type

        return $this->type;           
    }

    function libelle($html = true) {
        // Role: récupérer le libelle du champ
        // Paramètres : $html - true si on veut le convertir en HTML - true par défaut
        // Retour : le code du type  
        
        if($html) return nl2br(htmlentities($this->libelle));
        else return $this->libelle;
    }

    function link(){
        // Role: récupérer la valeur du lien d'un champ
        // Paramètres : aucun
        // Retour : la valeur du lien du champ

        return $this->link;
    }

}