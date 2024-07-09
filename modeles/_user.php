<?php

namespace fraldev\modeles;

/*

classe user étendu de la classe model

    Utilisation :

        * Parametrage : à définir dans la classe héritée
            const LOGIN = "" - champ utilisé pour stocker l'identifiant
            const PWD = "" - champ utilisé pour stockerle mot de passe
            
        * Méthodes :
            genPwd() : génère un mot de passe automatique
            setPwd($pwd) : crypte le mdp et le charge dans le champ "pwd" (nom à adapter au projet - mdp, pwd, etc..) de l'objet courant (condition : mini 8 caractere, dont 1 majuscule, 1 chiffre et 1 carctere spécial)
            sendMail($template, $param) : envoie un mail de confirmation avec le mot de passe auto $param = tableau indexé par les champs suivant : ["(detailMailTo)", "mailTo", "subject", "appli", "from", "reply"]
            loginVerify($login, $pwd) : verifie la concordance du mot de passe saisie et enregistré (nom du champ login à adapter au projet, idem pour le mdp)
            genToken() : genere un token unique en concaténant les information de l'utilisateur, avec son id et le time de la saisie, hashé, ajouter d'un chiffre aléatoire et transformé en valeur hexadecimal
            tokenVerify($token) : compare le token récupéré avec le token stocké dans la bdd, si la date de validité du token est toujours bonne et que le token correspond, alors on passe le compte au statut valide et on efface le token et sa date de validité
            
*/

class _user extends _model {

    const LOGIN = "";
    const PWD = "";

    function utilisateurExist($champ, $valeur){
        // vérifie dans la base de donnée si un utilisateur existe ou non avec le login renseigné
        // parametre : $login - l'information utilisateur utilisé pour ce connecté
        // retour : id de l'utilisateur ou 0 si pas d'utilisateur

        // construction
        $sql = "SELECT `id`, " . $this->makeFields() . " FROM `$this->table` WHERE `$champ` = :valeur";
        $param = [":valeur" => $valeur];

        // préparation/Execution
        $req = $this->runSql($sql, $param);

        // récupération
        $this->recoverReqSimple($req);

        // retour
        return $this->id();
    }

    function genPwd(){
        // role : génère un mot de passe automatique
        // parametre : aucun
        // retour : une chaine de caractere avec le mot de passe si ok ou vierge sinon
        
        // spécification des caractère, 1 majuscule, 1 chiffre, 1 caractere spé, et 5 lettre minuscule
        
        $majuscule = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $special = "@[]^_!\"#$%&\'()*+,-./:;{}<>=|~?"; 
        $minuscule = "abcdefghijklmnopqrstuvwxyz";

        // génération
        $int = random_int(0, 8);
        $maj = $majuscule[random_int(0, strlen($majuscule)-1)];
        $spe = $special[random_int(0, strlen($special)-1)];
        $min = "";
        for($i=0; $i<5; $i++){
            $min .= $minuscule[random_int(0, strlen($minuscule)-1)];
        }
        
        // mélange
        $pwd = $int . $maj . $min . $spe;
        $pwd = str_shuffle($pwd);
        // retour
        return $pwd;
    }

    function setPwd($pwd){
        // role : crypte le mdp (condition : mini 8 caractere, dont 1 majuscule ([A-Z]), 1 chiffre (/\d/) et 1 carctere spécial (/[\W_]/))
        //        puis le charge à l'emplacement du mdp (nom à adapter au projet)
        // parametre : $pwd - le mdp à crypté
        // retour : true / false

        // si le mdp ne rempli pas toute les condition, je retourne false
        if(strlen($pwd) < 8 || preg_match('/\d/', $pwd) == 0 || preg_match('/[A-Z]/', $pwd) == 0 || preg_match('/[\W_]/', $pwd) == 0) return false;

        // hash le mdp et le charge dans l'objet courant
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $this->fields[$this::PWD]->set($hash);

        // retour
        return true;
    }

    function sendMail($title, $contenu, $param){
        // role : envoie un mail
        // parametre : $title - titre du mail (utilisé dans le template mail_constructeur)
        //             $contenu - chemin d'accès au contenu du mail (utilisé dans le template mail_constructeur)
        //             $param - un tableau indexé avec les infos necessaire à l'envoi du mail ex ["nom" => valeurNom, etc...]
        // retour : send / echec

        // destinataire
        $detail = isset($param["detailMailTo"]) ? $param["detailMailTo"] : "";

        $mailTo = isset($param["mailTo"]) ? $param["mailTo"] : "";; // ceci est pour les test, en condition réel, il faudra mettre $param["mailTo"]
        $to = "'$detail' <$mailTo>";
        // sujet
        $subject = $param["subject"];
        //expediteur
            $appli = $param["appli"];
            $from = $param["from"];
            $reply = $param["reply"];
            // en tete
            $head = [];
            $head["From"] = "$appli <$from>";
            $head["reply-to"] = "$reply";
            // info pour création mail html
            $head["MIME-Version"] = "1.0";
            $head["Content-Type"] = "text/html; charset=UTF-8";
        // insertion template
        ob_start();
        include "../templates/mails/mail_constructeur.php";
        $message = ob_get_clean();
        //retour
        if(mail($to, $subject, $message, $head)) return "Send";
        else return "Echec";
    }

    // action sur la bdd
    function checkPwd($login, $pwd){
        // role : verifie la concordance du mot de passe saisie avec celui enregistré
        // parametre : $login - identifiant de l'utilisateur (nom du champ recherché à adapter au projet - nom, mail, etc..)
        //             $pwd - mdp saisi par l'utilisateur à comparer avec le champ mdp (nom à adapter au projet - mdp, pwd, etc..)
        // retour : l'id de l'utilisateur ou 0

        //construction
        $sql = "SELECT `id`, `".$this::PWD."` FROM `$this->table` WHERE `".$this::LOGIN."` = :identifiant";
        $param = [":identifiant" => $login];

        // dérouler
        $req = $this->runSql($sql, $param);

        // récupération
        $this->recoverReqSimple($req);

        if($this->is() && password_verify($pwd, $this->get($this::PWD))) return $this->id();
        else return 0;
    }

    function genToken(){
        // role : genere un token unique en concaténant les information de l'utilisateur, avec son id et le time de la saisie, hashé, ajouter d'un chiffre aléatoire et transformé en valeur hexadecimal
        // parametre : aucun
        // retour : $token, le token généré

        // concaténation de la chaine de caractere
        $chaine = $this->nom . $this->prenom . $this->mail . time();
        // hashage
        $hash = hash("SHA256", $chaine);
        // ajout d'un chiffre aléatoire
        $hash .= random_bytes(16);
        // transformation en valeur hexadecimal
        $token = bin2hex($hash);
        
        // retour
        return $token;

    }

    function tokenVerify($token){
        // role : compare le token récupéré avec le token stocké dans la bdd, si la date de validité du token est toujours bonne et que le token correspond, alors on passe le compte au statut valide et on efface le token et sa date de validité
        // parametre : $token - le token à vérifier
        // retour : 0 ou id
        
        //construction
        $sql = "SELECT `id`, `token` FROM `$this->table` WHERE " . $this->makeFilter($token);
        $param = $this->makeParam($token);

        // dérouler
        $req = $this->runSql($sql, $param);

        // récupération
        $this->recoverReqSimple($req);

        // retour
        if($this->is() && $this->token == $token) return $this->id();
        else return 0;
    }
}