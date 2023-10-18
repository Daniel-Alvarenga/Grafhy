var btn1 = document.querySelector("#btn1");
var btn2 = document.querySelector("#btn2");
btn2.style.display = "none";

var x = 1;

btn1.addEventListener ("click", () => {
    new EA();
});

btn2.addEventListener ("click", () => {
    new EA();
});

function EA(){
    if (x == 1){
        perfil.classList.add("abrir");
        perfil.classList.remove("perfil");
        perfil.classList.remove("fechar");
        btn2.style.display = "flex";
        x = 2;
    }
    else if(x == 2){
        perfil.classList.add("fechar");
        perfil.classList.remove("abrir");
        btn2.style.display = "none";
        x = 1;
    }
}