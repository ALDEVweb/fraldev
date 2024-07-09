<?php

namespace fraldev\modeles;

/*

Classe _model : modèle générique de gestion des objets // avec la gestion des champs par l'objet

Utilisation :

    * Méthodes protégées (à définir dans les classes héritée si nécessaire) :
        define() : protected - a implémenter dans la classe fille en utilisant addfield à l'interieur
        get_$field() : vérification directement dans get($field), si un get spé existe on lance cette méthode, sinon lance la méthode générique
        verify() : vérifie la cohérence d'un objet

    * Méthodes neutres :
        __construct($id) : chargement d'un nouvel objet via l'id en une seule fois
        is() : vérifie si l'objet est chargé ou non

    * Méthodes magiques :
        __get() : utilisé lorsque l'on fait $objet->attribut ($name sera donc à la place de "attribut")
        __set() : utilisé lorsque l'on fait $objet->attribut = valeur (attribut sera $name et valeur $value)

    * Getters :
        id() : récupère l'id de l'objet
        get($field) : récupère la valeur stocké dans le champ ciblé de l'objet
        getHTML($field) : retourne le champ formaté de façon à transformer les ballises html en texte
        getTarget($field) : récupère l'objet de la classe pointé par le champ

    * Setters :        
        set($field, $value) :  charge le champ d'un objet avec sa valeur
        loadFromTab($table) : charge un objet avec un tableau de donnée (récupéré par fetch)
    
    * Méthodes de synchronisation avec la bdd :
        advancedLoad($param) :  : charge de façon autonome l'objet courant
        load($id) : chargement de l'objet courant par l'id 
        insert() : insert un objet dans la base de donnée
        update() : met à jour un objet existant dans la base de donnée
        delete() : supprime un objet dans la base de donnée
        listAll($filtre, $tri, $limit) : récupère la liste de tout les objet de la table et si ils sont spécifié y inclus des condition de récupération et de triage

    * Méthodes permettant de gérer les champs (création d'un objet champ) :
        addfield() : permet d'ajouter un champ à l'objet courant en utilisant l'objet champs 
        getField(): récupère l'objet correspondant à un champ
        getAllFields() : récupère tout les champs d'un objet

    * Sous méthodes :
        toTab() : récupère les champs et valeurs d'un objet et les transforme en tableau
        makeSet() : construit la partie SET d'une requete insert ou update    
        makeParam() : construit les parametre nécessaire à insert et update
        makeFilter($filter) : construit la requete à mettre derriere le WHERE
        makeParamFilter($filter) : construit le tableau de parametre en fonction des filtres demandé
        makeTri($tri) : construit la requete à mettre derriere le ORDER BY
        makeFields() : consrtuit la liste des champs à mettre dans un SELECT (id + tt les champs d'une classe)
        runSql($sql, $param=NULL) : prépar et execute la requete sql
        recoverReqSimple($req) : récupère le résultat de la requete (lorsque le résultat attendu est unique)
        recoverReqMulti($req) : récupère le résultat de la requete (lorsque le résultat attendu est multiple)    

    * Utilistaires :
        // genForm($nom, $fields, $oeil="noir") : génère l'affichage d'un formulaire

*/


class _model extends fragment {


    // Attributs
        protected $table = "";  // Table :
        protected $fields = []; // liste des champs de la classe


    // stockage
        protected $id = 0;  // stockage de l'id
        protected $targets = [];    // objet chargé des liens récupéré ["champ" => objetLié, ...]

    
    // Méthodes // 

        // Méthodes protégées (utilisable dans les classes filles) :
            
            protected function define() {
                // Rôle : protected - a implémenter dans la classe fille en utilisant addfield à l'interieur pour définir les champs de la classe
                // Paramètres : aucun
                // Retour : aucun
            }

            function verify(){
                // role : vérifie la cohérence d'un objet
                // parametre : aucun
                // retour : true si cohérent sinon false

                return true;
            }
            


        // Neutres :

            function __construct($id = NULL){
                // cette fonction ce déclenche à chaque instanciation d'une classe, le parametre devra donc etre mis dans les parenthèse lors de cette instanciation
                // role : instancie un nouvel objet par l'id
                // parametre : $id - id de l'objet à instancier
                // retour: constructeur dc pas de retour
                
                $this->define();
                
                if(!is_null($id)) $this->load($id);
                
            }

            function is(){
                // role : test si un objet est chargé
                // parametre : aucun
                // retour : true / false
        
                return !empty($this->id);
            }
    

        // Méthodes magiques :

            function __get($name){
                // role : utilisé lorsque l'on fait $objet->attribut ($name sera donc à la place de "attribut")
                // parametres : $name - le champs visé
                // retour : la valeur que l'on veut récupérer

                if($name === "id") return $this->id();
                else if(isset($this->fields[$name])) return $this->get($name);

            }

            function __set($name, $value){
                // role : utilisé lorsque l'on fait $objet->attribut = valeur (attribut sera $name et valeur $value)
                // parametre : $name - champs que l'on souhaite charger
                //             $value - valeur à charger dans le champ
                // retour : aucun

                if(isset($this->fields[$name])) $this->set($name, $value);
            }


        // Getters :
        
            function id(){
                // role : retourne l'id de l'objet courant
                // paramere : aucun
                // retour : $id - id de l'objet courant

                return $this->id;
            }

            function get($field){
                // role : récupère la valeur stocké dans le champs ciblé de l'objet courant
                // parametre : $field - le champs ciblé
                // return : la valeur stocké dans le champ ciblé ou chaine vide si

                // vérife si une méthode spécifique existe et retourne son résultat le cas échéant
                if(method_exists($this, "get_$field")){
                    $method = "get_$field";
                    return $this->$method; 
                } 

                if(isset($this->fields[$field])) return $this->fields[$field]->get();
                else return "";
            }

            function getHTML($field){
                // role : retourne le champ formaté de façon à transformer les ballises html en texte
                // parametre : $field - le champ ciblé
                // retour : la valeur du champ tra nsformé

                return nl2br(htmlentities($this->get($field)));
            }

            function getTarget($field){
                // role : récupère l'objet de la classe pointé par le champ
                // parametre : $field - le champs pointant l'objet à récupérer
                // retour : si l'objet est déjà chargé, on retourne l'objet chargé 
                //          sinon, si le champ n'est pas un lien, retourne un nouvel objet de la class model
                //                 si le champ est un lien, retourne un objet de la class en question non chargé ou vierge si la cible est vide

                // si l'objet n'est pas déjà chargé
                if(!isset($this->targets[$field])){
                    // si le champ est un lien
                    if(isset($this->fields[$field])){ 
                        $class = '\\fraldev\\classes\\'; 
                        $class .= $this->fields[$field]->link();
                        $this->targets[$field] = new $class($this->get($field));
                    }else{
                        // sinon
                        $this->targets[$field] = new _model();
                    }
                }

                // retour
                return $this->targets[$field];

            }


        // Setters :

            function set($field, $value){
                // role : charge le champ d'un objet avec sa valeur
                // parametre : $field - champ à remplir
                //             $value - valeur à enregistrer dans le champ
                // retour : true / false
        
                // vérifie l'existence du champ ciblé
                if(isset($this->fields[$field])) $this->fields[$field]->set($value);
                else return false;
        
                // retour
                return true;
            }

            function loadFromTab($table){
                // Role : initialise un objet avec un tableau de donnée (récupéré par fetch)
                // paramètre : $table - le tableau de donnée récupéré
                // retour : true si ok / false sinon
                // si $table est vide je retourne false
                if(empty($table)) return false;
                
                // si j'ai un id dans le tableau, je le charge dans l'objet courant
                if(isset($table["id"])) $this->id = $table["id"];
        
                // pour chaque champ du tableau si il y a une valeur, je le charge dans le champ de l'objet courant
                foreach($this->fields as $field => $objet){
                    if(isset($table[$field])) $this->fields[$field]->set($table[$field]);
                }
        
                // retour    
                return true;
            }


        // Méthodes de synchronisation avec la bdd :   
        
            function advancedLoad($param){
                // role : charge de façon autonome l'objet courant
                // parametre : $param - si c'est un id : charge l'objet à partir de l'id
                //                    - si c'est un tableau, charge l'objet courant avec les champs=>valeur du tableau
                //                    - si c'est un objet, charge l'objet courant avec cet objet
                // retour : true / false si ça a fonctionné
                
                // on test le parametre
                if(is_numeric($param)) $this->load($param);
                else if(is_array($param)) $this->loadFromTab($param);
                else if($param instanceof _model) $this->loadFromTab($param->toTab());

                return $this->is();
            }

            function load($id){
            // role : chargement de l'objet courant par l'id
            // parametre : $id - id de l'objet à récupérer
            // retour : true si ok / false sinon
                
                // construction
                $sql = "SELECT `id`, ". $this->makeFields() . " FROM `$this->table` WHERE `id` = :id";
                $param = [":id" => $id];
                
                // préparation/execution
                $req = $this->runSql($sql, $param);
        
                // récupération / retour
                return $this->recoverReqSimple($req);
            }

            function insert(){
                // role : insert un objet dans la base de donnée
                // parametres : aucun
                // retour : true false

                // construction
                $sql = "INSERT INTO `$this->table` SET " . $this->makeSet();
                $param = $this->makeParam();

                // préparation/éxécution
                $this->runSql($sql, $param);

                // récupération de l'id
                global $bdd;
                $this->id = $bdd->lastInsertId();

                //retour
                return true;
            }

            function update(){
                // role : met à jour un objet existant dans la base de donnée
                // parametres : aucun
                // retour : true false

                // construction
                $sql = "UPDATE `$this->table` SET " . $this->makeSet() . " WHERE `id` = :id";
                $param[":id"] = $this->id();
                $param += $this->makeParam();
                // préparation/éxécution
                $this->runSql($sql, $param);

                //retour
                return true;
            }

            function delete(){
                // role : supprime un objet dans la base de donnée
                // parametres : aucun
                // retour : true false

                // construction
                $sql = "DELETE FROM `$this->table` WHERE `id` = :id";
                $param = [":id" => $this->id];

                // préparation/récupération
                $this->runSql($sql, $param);

                // retour
                return true;
            }

            function listAll($filter = [], $tri = [], $limit = NULL){
                // role : récupère la liste de tout les objet de la table et si ils sont spécifié y inclus des condition de récupération et de triage
                // parametres : $filter - tableau indexé par le champ ex ["champnom" => "valeurnom", etc..]
                //              $ tri - tableau simple avec - ou + pour asc desc et le champ qui sert de tri - ex ["-nom", etc..]
                //              $limit - nbre entier qui fixe la limite à récupérer
                // retour : un tableau d'objet indexé par l'id

                // construction
                $sql = "SELECT `id`, " . $this->makeFields() . " FROM `$this->table`";
                $param = [];
                if(!empty($filter)){
                    $sql .= " WHERE " . $this->makeFilter($filter);
                    $param = $this->makeParamFilter($filter);
                }
                if(!empty($tri)) $sql .= " ORDER BY " . $this->makeTri($tri);
                if(!is_null($limit)) $sql .= " LIMIT $limit";

                // préparation/éxecution
                $req = $this->runSql($sql, $param);

                // récupération/retour
                return $this->recoverReqMulti($req);
            }


        // Méthodes permettant de gérer les champs (création d'un objet champ) :
            
            protected function addField($name, $type = NULL, $libelle = NULL, $link = NULL){
                // permet d'ajouter un champ à l'objet courant en utilisant l'objet champs 
                // parametres : $name - Nom du champ
                //              $type - facultatif - type de champ (TXT-DATE-LINK)
                //              $libelle - facultatif - libellé du champ
                //              $link - facultatif - objet pointé par le champ

                $this->fields[$name] = new _field($this, $name, $type, $libelle, $link);
            }
            
            function getField($field){
                // role : récupère l'objet correspondant à un champ
                // parametre : $field - le champ recherché
                // retour : l'objet champ si existe sinon un objet champ vierge avec un nom _
                
                if(isset($this->fields[$field])) return $this->fields[$field];
                else return new _field($this, "_");
            }
            
            function getAllFields(){
                // role : récupère tout les champs d'un objet
                // parametres : aucun
                // retour : un tableau simple des champs de l'objet

                return $this->fields;
            }
            

        // Sous méthodes :

            function toTab(){
                // Role : récupèreles champs et valeurs d'un objet et les transforme en tableau
                // parametres : aucun
                // retour : tableau de valeur indexé par le nom du champs

                // initialisation du tableau
                $tab = [];
                // pour chaque champ 
                foreach($this->fields as $field => $objet){
                    // récupération de la valeur qu'on rajoute à l'indexe champ du tableau
                    $tab[$field] = $this->fields[$field]->get();
                }
                // retour du tableau
                return $tab;
            }

            function makeSet(){
                // role : construit la partie SET d'une requete insert ou update
                // parametre : aucun
                // retour : une chaine de caractère chargé avec la requete construite

                // construction d'un tableau construit avec le nom du champ = :nomduchamp, pour chaque champ
                $tab = [];
                foreach($this->fields as $field => $objet){
                    $tab[] = "`$field` = :$field";
                }
                // transformation du tableau en chaine caractère avec chaque element du tab séparé par ", " et retour
                return implode(", ", $tab);
            }

            function makeParam(){
                // role : construit les parametre nécessaire à insert et update
                // parametre : aucun
                // retour : un tableau indexé par le parametre - ex : [":nomchamp" => valeurchamp]

                // pour chaque champ, construction du tableau 
                $tab = [];
                foreach($this->fields as $field => $objet){
                    // si le champ à une valeur stocker, je la charge
                    if(isset($this->fields[$field])) $tab[":$field"] = $this->fields[$field]->get();
                    // sinon je charge vide
                    else $tab[":$field"] = NULL;
                }

                // retour
                return $tab;
            }
            
            function makeFilter($filters){
                // role : construit la requete à mettre derriere le WHERE
                // parametre : $filter - un tableau indexé par le champ à filtrer - ex ["nomChamp" => "valeurChamp", etc...]
                // retour : la requete sous forme de chaine de caratctere - ex "`nomchamp` = :nomchamp, etc..."

                $tab = [];
                foreach($filters as $filter => $value){
                    $tab[] = "`$filter` = :$filter";
                }

                return implode(" AND ", $tab);
            }

            function makeParamFilter($filters){
                // role : construit le tableau de parametre en fonction des filtres demandé
                // role : $filter - un tableau indexé par le champ à filtrer - ex ["nomChamp" => "valeurChamp", etc...]
                // retour : un tableau indexé par le champ - ex [":param" => "valeurParam", etc...]

                $tab = [];
                foreach($filters as $filter => $value){
                    $tab[":$filter"] = $value;
                }

                return $tab;
            }

            function makeTri($tris){
                // role : construit la requete à mettre derriere le ORDER BY
                // parametre : $tri - un tableau simple avec le champ et l'ordre - ex ["-nomChamp", etc]
                // retour : la requete sous forme de chaine de caratctere

                $tab = [];

                foreach($tris as $tri){
                    // récupère la direction +/- qui est sur le premier carac
                    $dir = substr($tri, 0, 1);
                    
                    if($dir === "-"){
                        // si dir = - on fixe tri descendant
                        $order = "DESC";
                        // récupère le champ qui sert de tri qui commence au 2e caractere
                        $field = substr($tri, 1);
                    }else if($dir === "+"){
                        // si dir = + on fixe tri ascendant
                        $order = "ASC";
                        // récupère le champ qui sert de tri qui commence au 2e caractere
                        $field = substr($tri, 1);
                    }else{
                        // si ce n'est ni + ni - c'est qu'il n'est pas spécifié, on fixe ascebndant par défaut
                        $order = "ASC";
                        // et on récupère le champ qui commence du coup au premier caractère
                        $field = $tri;
                    } 
                    $tab[] = "`$field` $order";
                }

                // retour de la requete
                return implode(", ", $tab);

            }

            function makeFields(){
                // role : construit la liste des champs à récupérer
                // parametre : aucun
                // retour : $select - une chaine de caractère avec la liste des champs
        
                // initialisation du tableau
                $array = [];
                
                // chargement du tableau avec les champs de l'objet
                foreach($this->fields as $field => $objet){
                    $array[] = "`$field`";
                } 

                    
                // retour
                return implode(", ", $array);

            }
        
            function runSql($sql, $param=[]){
            // role : construit la préparation, l'executionde la requete sql
            // parametre : $sql - la requete elle meme
            //             $param - les parametre de la requete
            // retour : retourne la requete construite ou false si echec
        
                // préparation
                global $bdd;
                $req = $bdd->prepare($sql);
                // exécution
                if(!$req->execute($param)){
                    // erreur de syntaxe : code de debug
                    echo "Echec sql : $sql";
                    print_r($param);
                    return false;
                }
                    
                // retour
                return $req;
            }
        
            function recoverReqSimple($req){
                // Role : récupère le résultat de la requete lorsqu'il est unique et le charge
                // parametre : $req - la requete en question
                // retour : true / false
                $result = $req->fetch(\PDO::FETCH_ASSOC);
                // traitement
                // si vide : retourne false
                if(empty($result)) return false;
        
                //sinon : charge l'objet avec le résultat
                $this->loadFromTab($result);
        
                // retour
                return true;
            }
        
            function recoverReqMulti($req){
                // Role : récupère le résultat de la requete lorsqu'il est multiple
                // parametre : $req - la requete en question
                // retour : tableau d'objet indexé par l'id
        
                // récupération
                $array = [];
                while($result = $req->fetch(\PDO::FETCH_ASSOC)){
                    //$class = '\\fraldev\\classes\\'; get_class retourne déjà la class avec son namespace
                    $class = \get_class($this);
                    $objet = new $class();
                    $objet->loadFromTab($result);
                    $array[$objet->id()] = $objet;
                }
        
                // retour
                return $array;
            }
            
            function genForm($nom, $fields, $oeil="noir"){
                // role : génère l'affichage d'un formulaire
                // parametre : $nom = nom du formulaire
                //              $fields les champs à mettre dans le formulaire ["", "", ...]
                //              $oeil = couleur de l'oeil (noir par défaut) blanc si besoin
                // retour : $html, le fragment html du formulaire

                // initialisation de la variable html et de la variable num (pour les champs password)
                $html = "";
                $nbrMdp = 0;
                // pour chaque champ du parametre
                foreach($fields as $field){
                    // je vérifie si il existe dans les champs de l'objet courant
                    if(!isset($this->fields[$field])){
                        $html .= "Le champ $field n'existe pas dans $this->table";
                    }else{
                    // je récupère le type du champ, son libellé, et sa valeur
                        $type = $this->fields[$field]->type();
                        $libelle = $this->fields[$field]->libelle();
                        $value = !is_null($this->fields[$field]->get()) ? $this->fields[$field]->get() : "";
                        // j'ouvre une div, je met la balise label
                        $html .= "<div>";
                        $html .= "<label for='$nom-$field'>$libelle</label>";
                        if($type == "TEXTAREA"){
                            // si type = TEXTAREA
                            $html .= "<textarea name='$libelle' id='$nom-$field'></textarea>";  
                        }else{
                            // si type = password
                            if($type == "PASSWORD"){
                                $nbrMdp++;
                                // je crée le champ pwd avec input, l'oeil et si plrs champs pwd referencement de data-pwd pour les differencier
                                $html .= "<div class='pwd-field'>";
                                $html .= "<input type='$type' name='$field' id='$nom-$field' class='input-pwd' data-pwd='$nbrMdp'>";
                                $html .= "<div class='toggle-pwd flex j-center' data-pwd='$nbrMdp' data-colorOeil='$oeil'><img src='../public/assets/fraldev/oeil_ferme_$oeil.svg' alt='un oeil'></div>";
                                $html .= "</div>";
                            }else{
                                $html .= "<input type='$type' name='$field' id='$nom-$field' value ='$value'>";
                            }
                        }

                        // je ferme la div
                        $html .= "</div>";
                    }
                }
                if($nbrMdp === 1) $html .= "<p id='mdp-oubli'>Mot de passe oublié ?</p>";
                if($nbrMdp > 1){
                    $html .= "<div id='instructionMdp'>";
                    $html .= "<p>Le mot de passe doit contenir un minimum de :</p>";
                    $html .= "<p id='mdpTot'>- 8 caractères</p>";
                    $html .= "<p id='mdpMaj'>- 1 lettre majuscule</p>";
                    $html .= "<p id='mdpNbr'>- 1 chiffre</p>";
                    $html .= "<p id='mdpSpe'>- 1 caractère spécial</p>";
                    $html .= "<p>Tu peux aussi utiliser notre générateur de mot de passe aléatoire</p>";
                    $html .= "<div id='container-generateur'>";
                    $html .= "<p id='generateur-mdp'>Générer</p>";
                    $html .= "<p id='affichage-mdp'></p>";
                    $html .= "</div>";
                    $html .= "</div>";
                }
                // je retourne l'html
                return $html;
            }

}