// gestion mdp oublié

// récupé bouton mdp-oubli
let btnMdpOubli = document.getElementById("mdp-oubli");
// récupération de la div à afficher
let popOubli = document.getElementById("pop-oubli");
// surveillance du bouton d'ouverture
btnMdpOubli.addEventListener("click", (e) => {
    // au clic, j'enleve d-none de la pop
    popOubli.classList.remove("d-none");
})