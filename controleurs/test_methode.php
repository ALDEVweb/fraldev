<?php

namespace fraldev\controleurs;

// contrôlleur de test d'une méthode simple

include "../utils/init.php";
echo "1";
$utilisateur = new \fraldev\classes\utilisateur();
echo "2";
$mdp = $utilisateur->genPwd();
echo "3";
echo "$mdp";