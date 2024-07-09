// gestion js du menu burger

// récupération de l'input du burger par son selecteur css
let burgerButton = document.querySelector(".burger-button")
// surveillance du click sur le burger et lance la fonction affiche menu
burgerButton.addEventListener("click", (e) => {
	afficheMenu()
})

// récupération du menu par son selecteur css
let burgerMenu = document.querySelector(".burger-menu")
let burgerLiens = document.querySelectorAll(".burger-lien")
burgerLiens.forEach(burgerLien=>{
    burgerLien.addEventListener("click",(e)=>{
        afficheMenu()
    })
})

function afficheMenu(){
// role : affiche le menu et modifie le logo burger
// parametre : rien
// retour : rien
	// enleve ou ajoute la class menu-ouvert
	burgerMenu.classList.toggle("burger-menu-ouvert ")
	// récupération du hero, main et footer
	let burgerBlurs = document.querySelectorAll(".burger-blur")
	// enleve ou ajoute la class blur2
	burgerBlurs.forEach(burgerBlur=>{
		burgerBlur.classList.toggle("blur-menu-ouvert")
	})
	// recupération des 3 trait du burger
	let burgerTop = document.querySelector("burger-top")
	let burgerMiddle = document.querySelector("burger-middle")
	let burgerBottom = document.querySelector("burger-bottom")
	// incline les trait haut et bas avec les class associé et fais s'échapper le trait du milieu
	burgerTop.classList.toggle("burger-top-check")
	burgerMiddle.classList.toggle("burger-middle-check")
	burgerBottom.classList.toggle("burger-bottom-check")
}