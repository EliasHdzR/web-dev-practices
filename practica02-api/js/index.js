///////// SECCION DE FIN DE JUEGO ////////
const btnReintentar = document.querySelector('#btn-reintentar');
btnReintentar.addEventListener('click', reiniciarJuego);
const btnGuardar = document.querySelector('#btn-guardar');
btnGuardar.addEventListener('click', guardarPuntaje);

async function guardarPuntaje(){
    const inputNombre = document.querySelector('#nombre');

    if(!inputNombre.value.trim()){
        inputNombre.focus();
        return;
    }

    // se deben transformar a milisegundos el tiempo obtenido
    const milisegundos = parseInt(sMinutos.innerHTML) * 60000 + parseInt(sSegundos.innerHTML) * 1000 + parseInt(sDecimas.innerHTML) * 10;

    const datos = new FormData();
    datos.append('milisegundos', milisegundos);
    datos.append('nombre', inputNombre.value);

    const res = await fetch(
        `/practicas/practica02-api/add_score.php`,
        { method: "POST", body: datos });

    const resObj = await res.json();
    console.log(resObj);
    window.location.reload();

}

function reiniciarJuego(){
    window.location.reload();
}


///////////////////////////////////////
// variables del cronometro
let tiempoInicio;
let Interval;
let tiempoActual;
const sMinutos = document.querySelector('#minutos');
const sSegundos = document.querySelector('#segundos');
const sDecimas = document.querySelector('#decimas');
let relojIniciado = false;

const tablero = document.querySelector('#tablero');
let listaCuadrados = [];
listaCuadrados = tablero.getElementsByTagName('td');

// este lo ocupo pq al parecer si no paso por referencia el evento este no se remueve usando el removeEventListener en la linea 102
let eventosCuadrado = [];

for (let cuadrado of listaCuadrados) {
    let idTemp = cuadrado.getAttribute('id');
    eventosCuadrado[idTemp] = volverFuncional(cuadrado);
    cuadrado.addEventListener('click', eventosCuadrado[idTemp]);
    cuadrado.addEventListener('click', inicializar);
}

/**
 * Esta funcion devuelve una funcion que se encarga de que el usuario pueda elegir un cuadrado y se ponga una imagen
 * cuando ponga la imagen y realice las validaciones el cuadrado se tiene que quedar inutil
 * La funcion que devuelve esta funcion se activa varias veces por partida del gato
 * @param {*} cuadrado 
 * @returns una funcion
 */
function volverFuncional(cuadrado) {
    const cuadradoActionClick = () => {
        const img = document.createElement('img');
        img.setAttribute('src', 'images/circulo.png');
        img.setAttribute('width', '80px');

        cuadrado.setAttribute('style', 'text-align: center;');
        cuadrado.appendChild(img);
        cuadrado.removeEventListener('click', cuadradoActionClick);

        let ganador = comprobarTablero();
        if (ganador) {
            finalizarJuego(ganador);
            return;
        }

        turnoComputadora();
    }

    return cuadradoActionClick;
}

/**
 * 
 * Esta funcion solo se activa una vez por partida del gato
 */
function inicializar() {
    if (!relojIniciado) {
        tiempoInicio = Date.now();
        Interval = setInterval(iniciarReloj, 10);
        relojIniciado = true;
        
        for (let cuadrado of listaCuadrados) {
            cuadrado.removeEventListener('click', inicializar);
        }
    }
}

/**
 * Resta la hora actual menos la hora de inicio de la partida para obtener el tiempo transcurrido
 * segun los cambios va actualizando los span del index.view.php
 */
function iniciarReloj() {
    tiempoActual = Date.now();
    const tiempoTranscurrido = tiempoActual - tiempoInicio;
    
    const minutos = Math.floor(tiempoTranscurrido / 60000);
    const segundos = Math.floor((tiempoTranscurrido % 60000) / 1000);
    const decimas = Math.floor((tiempoTranscurrido % 1000) / 10);
    
    sMinutos.innerHTML = minutos < 10 ? "0" + minutos : minutos;
    sSegundos.innerHTML = segundos < 10 ? "0" + segundos : segundos;
    sDecimas.innerHTML = decimas < 10 ? "0" + decimas : decimas;
}

/**
 * Primero checa si ganó el jugador, luego la maquina y al final si empataron
 * @returns Una señal para terminar el juego
 */
function comprobarTablero() {
    const listaCuadrados = tablero.getElementsByTagName('td');

    if (esGanador('images/circulo.png', listaCuadrados)) {
        console.log('ganó jugador');
        return "jugador";
    }

    if (esGanador('images/cruz.png', listaCuadrados)) {
        console.log('ganó computadora');
        return "computadora";
    }

    let ids = [];
    for (let cuadrado of listaCuadrados) {
        img = cuadrado.getElementsByTagName('img');
        if (img.length == 0) {
            continue;
        }
        ids.push(cuadrado.getAttribute('id'));
    }

    if (ids.length == 9) {
        console.log('empate');
        return "empate";
    }

    return null;
}

/**
 * Recibe la ruta de la imagen y recupera todos los cuadros con esa ruta, después checamos si esos cuadros
 * recuperados completan una forma de ganar
 * @param {*} rutaImagen 
 * @param {*} listaCuadrados 
 * @returns true - si los cuadros completan una forma de ganar
 */
function esGanador(rutaImagen, listaCuadrados) {
    let ids = [];

    for (let cuadrado of listaCuadrados) {
        let img = cuadrado.getElementsByTagName('img');
        if (img.length == 0) {
            continue;
        }
        if (img[0].getAttribute('src') == rutaImagen) {
            ids.push(cuadrado.getAttribute('id'));
        }
    }

    // tenemos que checar manualmente cada forma de ganar
    // horizontales
    for (let i = 1; i <= 7; i += 3) {
        if (ids.includes(`cuadrado-${i}`) && ids.includes(`cuadrado-${i + 1}`) && ids.includes(`cuadrado-${i + 2}`)) {
            const cuadro1 = document.getElementById(`cuadrado-${i}`);
            cuadro1.setAttribute('style', 'background-color: white;');
            const cuadro2 = document.getElementById(`cuadrado-${i + 1}`);
            cuadro2.setAttribute('style', 'background-color: white;');
            const cuadro3 = document.getElementById(`cuadrado-${i + 2}`);
            cuadro3.setAttribute('style', 'background-color: white;');
            return true;
        }
    }

    //verticales
    for (let i = 1; i <= 3; i++) {
        if (ids.includes(`cuadrado-${i}`) && ids.includes(`cuadrado-${i + 3}`) && ids.includes(`cuadrado-${i + 6}`)) {
            const cuadro1 = document.getElementById(`cuadrado-${i}`);
            cuadro1.setAttribute('style', 'background-color: white;');
            const cuadro2 = document.getElementById(`cuadrado-${i + 3}`);
            cuadro2.setAttribute('style', 'background-color: white;');
            const cuadro3 = document.getElementById(`cuadrado-${i + 6}`);
            cuadro3.setAttribute('style', 'background-color: white;');
            return true;
        }
    }

    //diagonales
    if (ids.includes(`cuadrado-${1}`) && ids.includes(`cuadrado-${5}`) && ids.includes(`cuadrado-${9}`)) {
        const cuadro1 = document.getElementById(`cuadrado-${1}`);
        cuadro1.setAttribute('style', 'background-color: white;');
        const cuadro2 = document.getElementById(`cuadrado-${5}`);
        cuadro2.setAttribute('style', 'background-color: white;');
        const cuadro3 = document.getElementById(`cuadrado-${9}`);
        cuadro3.setAttribute('style', 'background-color: white;');
        return true;
    }

    if (ids.includes(`cuadrado-${3}`) && ids.includes(`cuadrado-${5}`) && ids.includes(`cuadrado-${7}`)) {
        const cuadro1 = document.getElementById(`cuadrado-${3}`);
        cuadro1.setAttribute('style', 'background-color: white;');
        const cuadro2 = document.getElementById(`cuadrado-${5}`);
        cuadro2.setAttribute('style', 'background-color: white;');
        const cuadro3 = document.getElementById(`cuadrado-${7}`);
        cuadro3.setAttribute('style', 'background-color: white;');
        return true;
    }
}

/**
 * Se encarga de recuperar todos los cuadrados libres y elegir uno random en el que poner la cruz
 * Una vez elegido un especio se comprueba si la computadora ganó
 */
function turnoComputadora() {
    const listaCuadrados = tablero.getElementsByTagName('td');
    let ids = [];

    for (let cuadrado of listaCuadrados) {
        let img = cuadrado.getElementsByTagName('img');
        if (img.length == 0) {
            ids.push(cuadrado.getAttribute('id'));
        }
    }

    let idRandom = Math.floor(Math.random() * ids.length);
    const cuadrado = document.getElementById(ids[idRandom]);

    const img = document.createElement('img');
    img.setAttribute('src', 'images/cruz.png');
    img.setAttribute('width', '80px');

    cuadrado.setAttribute('style', 'text-align: center;');
    cuadrado.appendChild(img);
    cuadrado.removeEventListener('click', eventosCuadrado[ids[idRandom]]);

    let ganador = comprobarTablero();
    if (ganador) {
        finalizarJuego(ganador);
    }
}

/**
 * Para el cronometro y muestra los elementos respectivos
 * @param {*} ganador 
 */
function finalizarJuego(ganador) {
    const pAviso = document.querySelector('#p-aviso');
    pAviso.setAttribute('style', 'color: white;');

    clearInterval(Interval);

    if (ganador == "jugador") {
        pAviso.textContent = 'Has Ganado';
        const formGanador = document.querySelector('#form-ganador');
        formGanador.setAttribute('style', 'margin-top: 10px; display: block;');
    }
    if (ganador == "computadora") {
        pAviso.textContent = 'Has Perdido';
        const formPerdedor = document.querySelector('#div-perdedor');
        formPerdedor.setAttribute('style', 'margin-top: 10px; display: block;');
    }
    if (ganador == "empate") {
        pAviso.textContent = 'Empate';
        const formPerdedor = document.querySelector('#div-perdedor');
        formPerdedor.setAttribute('style', 'margin-top: 10px; display: block;');
    }

    const tablero = document.querySelector('#tablero');
    let listaCuadrados = [];
    listaCuadrados = tablero.getElementsByTagName('td');

    for (let cuadrado of listaCuadrados) {
        cuadrado.removeEventListener('click', eventosCuadrado[cuadrado.getAttribute('id')]);
    }
}
