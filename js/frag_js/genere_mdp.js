// génération d'un mdp à la dde
// récupération du bouton et de la zone d'affichage
let generateur = document.getElementById("generateur-mdp");
let affichageMdp = document.getElementById("affichage-mdp");
// surveille le click sur le bouton de generation
generateur.addEventListener("click", (e) => {
    // lance la génération du pwd puisutilise le retour pour afficher le mdp dans la zone d'affichage
    genPwd();
})
function genPwd(){
    // fonction ajax : lance le controleur ajax de génération de mdp et l'affiche
    // parametre : aucun
    // retour : un fichier json {"mdp" => mdp}

    fetch("../controleurs/fraldev_controleurs/generer_mdp.php")
    .then(resp =>{
        return resp.json();
    })
    .then(retour => {
        afficheMdp(retour.mdpGen);
    })
}
function afficheMdp(mdp){
    // role : affiche le mot de passe dans sa zone d'affichage
    // parametre : le mot de passe a afficher
    // retour : aucun

    affichageMdp.innerText = mdp;
}