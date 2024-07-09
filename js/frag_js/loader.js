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