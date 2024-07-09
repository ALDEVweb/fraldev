/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../js/frag_js/genere_mdp.js":
/*!***********************************!*\
  !*** ../js/frag_js/genere_mdp.js ***!
  \***********************************/
/***/ (() => {

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

/***/ }),

/***/ "../js/frag_js/halo_souris.js":
/*!************************************!*\
  !*** ../js/frag_js/halo_souris.js ***!
  \************************************/
/***/ (() => {

// gestion js du halo autour de la souris

let haloSouris = document.querySelector(".halo-souris")
window.addEventListener("mousemove", (e)=> {
    haloSouris.style.left = e.clientX + "px"
    haloSouris.style.top = e.clientY + "px"
})

/***/ }),

/***/ "../js/frag_js/loader.js":
/*!*******************************!*\
  !*** ../js/frag_js/loader.js ***!
  \*******************************/
/***/ (() => {

// fonction loader au chargement

document.addEventListener("DOMContentLoaded", (e)=>{
    let loader = document.getElementById("loader")
    setTimeout(()=>{
        loader.classList.add("loader-hidden")
        setTimeout(()=>{
            loader.classList.add("d-none")
        }, 500)
    }, 1200)
})

/***/ }),

/***/ "../js/frag_js/menu_burger.js":
/*!************************************!*\
  !*** ../js/frag_js/menu_burger.js ***!
  \************************************/
/***/ (() => {

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

/***/ }),

/***/ "../js/frag_js/pop_mdp_oubli.js":
/*!**************************************!*\
  !*** ../js/frag_js/pop_mdp_oubli.js ***!
  \**************************************/
/***/ (() => {

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

/***/ }),

/***/ "../js/frag_js/switch.js":
/*!*******************************!*\
  !*** ../js/frag_js/switch.js ***!
  \*******************************/
/***/ (() => {

// gestion des switch

// switch access
// récupération du bouton access
let switchAccess = document.getElementById("switch-access")
// récupération de l'image à changer
let btnAccess = document.getElementById("button-access")
// on surveille le changement sur le switch
switchAccess.addEventListener("change",(e)=>{
    // on change le datastyle et l'image affiché en fonction
    if(switchAccess.checked){
        body.setAttribute("data-style","access")
    }else{
        body.setAttribute("data-style","normal")
    }
})

// Dark mode
// récupération du body
let body = document.querySelector("body")
// récupération du bouton
let colorMode = document.getElementById("switch-mode")
// surveille le changement d'état du bouton
colorMode.addEventListener("change",(e)=>{
    // on change l'attribut data-theme en light ou dark en fonction de l'état
    if(colorMode.checked) body.setAttribute("data-theme","light")
    else body.setAttribute("data-theme","dark")
})

/***/ }),

/***/ "../js/frag_js/toggle_pwd.js":
/*!***********************************!*\
  !*** ../js/frag_js/toggle_pwd.js ***!
  \***********************************/
/***/ (() => {

// gestion de l'affichage ou masquage du mdp

// récupération des chemins des images possibles
let oeilOuvertBlanc = `<img src="../assets/oeil_ouvert_blanc.svg" alt="image d'un oeil"></img>`;
let oeilFermeBlanc = `<img src="../assets/oeil_ferme_blanc.svg" alt="image d'un oeil"></img>`;
let oeilOuvertNoir = `<img src="../assets/oeil_ouvert_noir.svg" alt="image d'un oeil"></img>`;
let oeilFermeNoir = `<img src="../assets/oeil_ferme_noir.svg" alt="image d'un oeil"></img>`;  

// récupération des boutons toggle-pwd
let togglePwdButtons = document.querySelectorAll(".toggle-pwd")

// surveillance du clic sur chaque bouton trouvé
togglePwdButtons.forEach(button => {
    button.addEventListener("click", (e) => {
        // récupération du data id du bouton, du data colorOeil
        let idPwd = button.dataset.pwd;
        let colorPwd = button.dataset.colorOeil;
        // récupération de l'input associé
        let inputPwd = document.querySelector(`.input-pwd[data-pwd="${idPwd}"]`)
        // vérification du type de l'input et chgmnt d'état de l'input et changement de l'oeil noir datacolor noir ou blc
        if (inputPwd.type === "password") {
            inputPwd.type = "text";
            if(colorPwd == "noir") button.innerHTML = oeilOuvertNoir;
            else button.innerHTML = oeilOuvertBlanc;
        }else{
            inputPwd.type = "password";
            if(colorPwd == "noir") button.innerHTML = oeilFermeNoir;
            else button.innerHTML = oeilFermeBlanc;
        }

    })

})

/***/ }),

/***/ "../js/frag_js/verif_saisi_mdp.js":
/*!****************************************!*\
  !*** ../js/frag_js/verif_saisi_mdp.js ***!
  \****************************************/
/***/ (() => {

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

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!************************!*\
  !*** ../js/fraldev.js ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_frag_js_toggle_pwd_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../js/frag_js/toggle_pwd.js */ "../js/frag_js/toggle_pwd.js");
/* harmony import */ var _js_frag_js_toggle_pwd_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_toggle_pwd_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_frag_js_pop_mdp_oubli_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../js/frag_js/pop_mdp_oubli.js */ "../js/frag_js/pop_mdp_oubli.js");
/* harmony import */ var _js_frag_js_pop_mdp_oubli_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_pop_mdp_oubli_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _js_frag_js_genere_mdp_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../js/frag_js/genere_mdp.js */ "../js/frag_js/genere_mdp.js");
/* harmony import */ var _js_frag_js_genere_mdp_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_genere_mdp_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _js_frag_js_verif_saisi_mdp_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../js/frag_js/verif_saisi_mdp.js */ "../js/frag_js/verif_saisi_mdp.js");
/* harmony import */ var _js_frag_js_verif_saisi_mdp_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_verif_saisi_mdp_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _js_frag_js_loader_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../js/frag_js/loader.js */ "../js/frag_js/loader.js");
/* harmony import */ var _js_frag_js_loader_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_loader_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _js_frag_js_switch_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../js/frag_js/switch.js */ "../js/frag_js/switch.js");
/* harmony import */ var _js_frag_js_switch_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_switch_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _js_frag_js_halo_souris_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../js/frag_js/halo_souris.js */ "../js/frag_js/halo_souris.js");
/* harmony import */ var _js_frag_js_halo_souris_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_halo_souris_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _js_frag_js_menu_burger_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../js/frag_js/menu_burger.js */ "../js/frag_js/menu_burger.js");
/* harmony import */ var _js_frag_js_menu_burger_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_js_frag_js_menu_burger_js__WEBPACK_IMPORTED_MODULE_7__);
// fichier source d'import des fichiers js

// npm run build:dev pour la version standard
// npm run build:prod pour la version minimal










})();

/******/ })()
;
//# sourceMappingURL=fraldev-bundle.js.map