// gestion js du halo autour de la souris

let haloSouris = document.querySelector(".halo-souris")
window.addEventListener("mousemove", (e)=> {
    haloSouris.style.left = e.clientX + "px"
    haloSouris.style.top = e.clientY + "px"
})