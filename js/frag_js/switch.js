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