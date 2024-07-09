<?php

namespace fraldev\modeles;

// classe de gestion des générateur de fragment

// genList($liste) : génère une liste à partir d'une liste d'objet


class fragment {

    static function genListe($liste, $link = "", $nomParam ="", $valeurParam = ""){
        // role : génère l'affichage html d'une liste (potentiellement clicable)
        // parametre : $liste liste d'objet indexé par l'id
        //             $link (facultatif) lien visé au clic
        //             $nomParam (facultatif) nom du parametre de la requete
        //             $valeurParam (facultatif) nom du champ dont on doit récupérer la valeur
        // retour : $html, le fragment html de la liste

        $html = "";
        // pour chaque objet de la liste
        foreach($liste as $objet){
            // j'ouvre une balise li
            $html .= "<li class='flex j-between'>";
            // si un lien est fourni, je l'ajoute
            if($link !== ""){
                $val = $objet->$valeurParam;
                $html .= "<a href='$link?$nomParam=$val' class='btn'>";
            }
            // on récupère tout les champs de l'objet
            $fields = $objet->getAllFields();
            // pour chaque champ de l'objet,
            foreach($fields as $field){
                // si il est chargé, j'affiche sa valeur dans une div
                if(!is_null($field->get())){ 
                    $value = nl2br(htmlentities($field->get()));
                    $html .= "<div>$value</div>";
                }
            }
            // si un lien est fourni, je ferme le lien
            if($link !== "") $html .= "</a>";
            // je ferme la balise li
            $html .= "</li>";            
        }

        // je retourne le fragment
        return $html;

    }

}