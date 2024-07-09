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