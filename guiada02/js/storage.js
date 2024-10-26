if(!window.localStorage){
    alert('Local storage no disponible en el navegador');
    location.assign('../index.html');
}

const sFechaHora = document.querySelector('#s-fecha-hora');
const txtLlave = document.querySelector('#txt-llave');
const txtValor = document.querySelector('#txt-valor');
const btnAgregar = document.querySelector('#btn-agregar');

// cada 500  milisegundos llamamos a la funcion
const idTimer = setInterval(e => {
    const d = new Date();
    sFechaHora.textContent = d.toString();
}, 500);

// cuando ya no queramos que se ejecute un intervalo
// clearInterval(idTimer);

// la llave y el valor del storage son string
function listarElementosLocalStorage(){
    console.clear();
    console.log("Elementos del localStorage:");
    for(let ix = 0; ix < localStorage.length; ix++){
        let k = localStorage.key(ix);
        let v = localStorage.getItem(k);
        console.log(`- ${k} -> ${v}`);
    }
}

btnAgregar.addEventListener('click', e => {
    if(!txtLlave.value.trim()){
        txtLlave.focus();
        return;
    }

    localStorage.setItem(txtLlave.value.trim(), txtValor.value);
    txtLlave.value = "";
    txtValor.value = "";
    txtLlave.focus();
    listarElementosLocalStorage();
});