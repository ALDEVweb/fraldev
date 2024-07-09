<?php

namespace fraldev\controleurs;

// controleur ajax : génere un mdp aléatoire
// parametre : aucun

// initialisation

include "../utils/init.php";

// traitement
$utilisateur = new \fraldev\classes\utilisateur();
$mdpGen = $utilisateur->genPwd();

echo json_encode(["mdpGen" => $mdpGen]);