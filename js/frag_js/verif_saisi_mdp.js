verifSaisie();
// récupération des champ de validation des conditions
let mdpTot = document.getElementById("mdpTot")
let mdpMaj = document.getElementById("mdpMaj")
let mdpNbr = document.getElementById("mdpNbr")
let mdpSpe = document.getElementById("mdpSpe")
// récupération du champ mdp n°1
let mdpOne = document.querySelector(`.input-pwd[data-pwd=1]`);
// surveillance du contenu du mdp
mdpOne.addEventListener("input", (e) => {
     verifSaisie();
})
// fonction indépendante de surveillance du nombre total de caractère, et de la présence d'un chiffre, d'une lettre maj et d'un caractère spécial
// rend l'instruction valide ou non-valide selon qu'elle soit respecté ou non
function verifTotal(){
    // Minimum de 8 caractère
    if(mdpCrea.value.length >= 8){
        mdpTot.classList.remove("non-valide");
        mdpTot.classList.add("valide");
    }else{
        mdpTot.classList.remove("valide");
        mdpTot.classList.add("non-valide");
    }
}
function verifMajuscule(){
    // mini 1 lettre MAJ
    let regMaj = /[A-Z]/;
    if(regMaj.test(mdpCrea.value)){
        mdpMaj.classList.remove("non-valide");
        mdpMaj.classList.add("valide");
    }else{
        mdpMaj.classList.remove("valide");
        mdpMaj.classList.add("non-valide");
    }
}
function verifChiffre(){
    // mini 1 chiffre
    let regNbr = /\d/;
    if(regNbr.test(mdpCrea.value)){
        mdpNbr.classList.remove("non-valide");
        mdpNbr.classList.add("valide");
    }else{
        mdpNbr.classList.remove("valide");
        mdpNbr.classList.add("non-valide");
    }
}
function verifSpecial(){
    // mini 1 caractère special
    let regSpe = /[\W_]/;
    if(regSpe.test(mdpCrea.value)){
        mdpSpe.classList.remove("non-valide");
        mdpSpe.classList.add("valide");
    }else{
        mdpSpe.classList.remove("valide");
        mdpSpe.classList.add("non-valide");
    }
}
function verifSaisie(){
    // lance toute les vérification de saisie du mdp
    verifTotal();
    verifMajuscule();
    verifChiffre();
    verifSpecial();
}