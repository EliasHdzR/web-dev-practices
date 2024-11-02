const inputFilas = document.querySelector("#input-filas");
const inputColumnas = document.querySelector("#input-columnas");
const inputMinas = document.querySelector("#input-minas");
const btnTamano = document.querySelector("#btn-tamano");
btnTamano.addEventListener("click", modoPersonalizado);

inputFilas.value = "";
inputColumnas.value = "";
inputMinas.value = "";

function modoPersonalizado() {
    let filasPers = parseInt(inputFilas.value.trim(), 10);
    const columnasPers = parseInt(inputColumnas.value.trim(), 10);
    const minasPers = parseInt(inputMinas.value.trim(), 10);

    if (isNaN(filasPers) || filasPers < 5) {
        inputFilas.value = "";
        inputFilas.focus();
        return;
    }

    if (isNaN(columnasPers) || columnasPers < 5) {
        inputColumnas.value = "";
        inputColumnas.focus();
        return;
    }

    if (isNaN(minasPers) || minasPers < 5 || minasPers > filasPers * columnasPers - 1) {
        inputMinas.value = "";
        inputMinas.focus();
        return;
    }

    iniciarJuego(filasPers, columnasPers, minasPers);
}

const divEleccion = document.querySelector(".eleccion-container");
const divAviso = document.querySelector(".aviso");
const aviso = document.querySelector("#h-aviso");
const divJuego = document.querySelector(".juego-container");
const btnReiniciar = document.querySelector("#btn-reiniciar")
btnReiniciar.addEventListener("click", function (){window.location.reload();})
const infoH = document.querySelector("#h-info");
const tablero = document.querySelector("#tablero");

// dificultades predeterminadas
const btnFacil = document.querySelector("#btn-facil");
btnFacil.addEventListener('click',function() {iniciarJuego(8,8,10)});
const btnMedio = document.querySelector("#btn-medio");
btnMedio.addEventListener('click',function() {iniciarJuego(8,16,28)});
const btnDificil = document.querySelector("#btn-dificil");
btnDificil.addEventListener('click',function() {iniciarJuego(16,16, 99)});
const btnMDificil = document.querySelector("#btn-m-dificil");
btnMDificil.addEventListener('click',function() {iniciarJuego(16,30, 150)});
const btnHardcore = document.querySelector("#btn-hardcore");
btnHardcore.addEventListener('click',function() {iniciarJuego(30,30,350)});
const btnLeyenda = document.querySelector("#btn-leyenda");
btnLeyenda.addEventListener('click',function() {iniciarJuego(30,45, 500)});

let cantFilas;
let cantColumnas;
let cantMinas;
let primerTurno = true;
let listaMinas = [];
let listaBotones = [];
let listaCuadriculasLibres = [];
let cuadriculasreveladas = 0;

// todos los tipos son como hijos de mi clase main Espacio
function Espacio(posFila, posColumna){
    this.posFila = posFila;
    this.posColumna = posColumna;
}

function Boton(posFila, posColumna, idBoton){
    this.posFila = posFila;
    this.posColumna = posColumna;
    this.idBoton = idBoton;
}

function Mina(posFila, posColumna, botonAsociado){
    this.posFila = posFila;
    this.posColumna = posColumna;
    this.botonAsociado = botonAsociado;
}

function CuadriculaLibre(posFila, posColumna, numero){
    this.posFila = posFila;
    this.posColumna = posColumna;
    this.numero = numero;
    this.revelada = false;
}

function iniciarJuego(filas, columnas, minas){
    cantFilas = filas;
    cantColumnas = columnas;
    cantMinas = minas;

    infoH.innerHTML = `Cantidad de Minas: ${cantMinas}`;
    infoH.setAttribute("style","display:block;")
    divEleccion.setAttribute('style','display:none');
    divJuego.setAttribute('style','display:block');
    crearTablero();
}

function crearTablero(){
    let cuadrado;
    let fila;
    let boton;

    for(let i = 0; i < cantFilas; i++){
        fila = document.createElement('tr')
        for(let j = 0; j < cantColumnas; j++){
            boton = document.createElement('button');
            boton.setAttribute('id',`btn-${i}-${j}`);
            boton.addEventListener('click', function(){accionBotonesTablero(`btn-${i}-${j}`)});

            cuadrado = document.createElement('td');
            cuadrado.appendChild(boton);
            fila.appendChild(cuadrado);

            listaBotones.push(new Boton(i, j, `btn-${i}-${j}`));
        }
        tablero.appendChild(fila);
    }
}

function accionBotonesTablero(idBoton){
    let boton;
    for(let i = 0; i < listaBotones.length; i++){
        const botonTemp = listaBotones[i];
        if(botonTemp.idBoton == idBoton){
            boton = botonTemp;
        }
    }

    if(primerTurno){
        primerTurno = false;
        generarMinas(boton);
        calcularNumeros();
    }

    const espacio = new Espacio(boton.posFila, boton.posColumna);
    develarContenidoCuadricula(espacio);
}

function generarMinas(boton){
    const idBoton = boton.idBoton;
    for(let i = 0; i < cantMinas; i++){
        let yaExiste = false;
        const randomFila = Math.floor(Math.random() * cantFilas);
        const randomColumna = Math.floor(Math.random() * cantColumnas);

        // no se pede generar una mina en el boton que se clickeó
        if(`btn-${randomFila}-${randomColumna}` == idBoton){
            i--;
            continue;
        }

        const boton = document.querySelector(`#btn-${randomFila}-${randomColumna}`);
        const nuevaMina = new Mina(randomFila, randomColumna, boton);

        // para checar que no se generen 2 minas en el mismo espacio
        for(let j = 0; j < listaMinas.length; j++){
            const minaExistente = listaMinas[j];
            if(!minaExistente) break;
            if(minaExistente.botonAsociado == nuevaMina.botonAsociado){
                yaExiste = true;
            }
        }

        if(yaExiste){
            i--;
            continue;
        }

        listaMinas[i] = nuevaMina;
    }

    //ocupo tambien conocer TODOS los cuadrados libres
    for(let i = 0; i < cantFilas; i++){
        for(let j = 0; j < cantColumnas; j++){
            const cuadriculaLibre = new CuadriculaLibre(i,j,0);
            let esLibre = true;

            for(let h = 0; h < listaMinas.length; h++){
                const mina = listaMinas[h];
                if(mina.posFila == cuadriculaLibre.posFila && mina.posColumna == cuadriculaLibre.posColumna){
                    esLibre = false;
                    break;
                }
            }

            if(esLibre){
                listaCuadriculasLibres.push(cuadriculaLibre);
            }
        }
    }
}

function calcularNumeros(){
    for(let i = 0; i < listaMinas.length; i++){
        const mina = listaMinas[i];
        const espaciosAdyacentes = getEspaciosAdyacentes(mina);
        for(let j = 0; j < espaciosAdyacentes.length; j++){
            const espacioAdyacente = espaciosAdyacentes[j];
            for(let k = 0; k < listaCuadriculasLibres.length; k++){
                const cuadriculaLibre = listaCuadriculasLibres[k];
                if(espacioAdyacente.posFila == cuadriculaLibre.posFila && espacioAdyacente.posColumna == cuadriculaLibre.posColumna){
                    cuadriculaLibre.numero++;
                }
            }
        }
    }
}

function develarContenidoCuadricula(espacio){
    const fila = espacio.posFila;
    const columna = espacio.posColumna;

    const tipoCuadricula = checarTipo(fila, columna);

    if(tipoCuadricula instanceof CuadriculaLibre) {
        const cuadriculaLibre = tipoCuadricula;
        const btnElegido = document.querySelector(`#btn-${fila}-${columna}`);
        tipoCuadricula.revelada = true;
        cuadriculasreveladas++;

        const tdContenedor = btnElegido.parentNode;

        if(cuadriculaLibre.numero != 0){
            tdContenedor.innerHTML = cuadriculaLibre.numero;
        } else {
            tdContenedor.innerHTML = "";
        }

        if(cuadriculasreveladas == listaCuadriculasLibres.length){
            ganarJuego();
            return;
        }

        if(cuadriculaLibre.numero == 0){
            const espaciosAdyacentes = getEspaciosAdyacentes(espacio);
            for(let i = 0; i < espaciosAdyacentes.length; i++){
                const espacioAdyacente = espaciosAdyacentes[i];
                const tipoCuadriculaAdy = checarTipo(espacioAdyacente.posFila, espacioAdyacente.posColumna);

                if (tipoCuadriculaAdy instanceof CuadriculaLibre && !tipoCuadriculaAdy.revelada) {
                    develarContenidoCuadricula(tipoCuadriculaAdy);
                }
            }
        }

    }

    if(tipoCuadricula instanceof Mina){
        for(let i = 0; i < listaMinas.length; i++) {
            const mina = listaMinas[i];
            const btnElegido = document.querySelector(`#btn-${mina.posFila}-${mina.posColumna}`);
            const tdContenedor = btnElegido.parentNode;
            tdContenedor.innerHTML = "*";
        }
        terminarJuego();
    }
}

function terminarJuego(){
    divAviso.setAttribute("style", "display: block;")
    aviso.innerHTML = "PARTIDA TERMINADA";
    for(let i = 0; i < listaBotones.length; i++){
        const boton = document.querySelector(`#${listaBotones[i].idBoton}`);
        if(boton){
            boton.setAttribute("disabled","true");
        }
    }
}

function ganarJuego(){
    divAviso.setAttribute("style", "display: block;")
    aviso.innerHTML = "¡GANASTE!";

    for(let i = 0; i < listaBotones.length; i++){
        const boton = document.querySelector(`#${listaBotones[i].idBoton}`);
        if(boton){
            boton.setAttribute("disabled","true");
        }
    }
}

/**
 * Devuelve todos los espacios adyacentes de un cuadrado dado, el cuadrado puede ser un boton o una mina
 */
function getEspaciosAdyacentes(espacio){
    const fila = espacio.posFila;
    const columna = espacio.posColumna;
    let arrayEspaciosAdyacentes = [];
    let yaUbicado = false
    //para no andar haciéndolo manualmente
    let coordenadas;

    // checamos si es una de las 4 esquinas del tablero
    if(!yaUbicado && fila == 0 && columna == 0){
        yaUbicado = true;
        coordenadas = [
            [0,1],
            [1,0],
            [1,1]
        ];
    }

    if(!yaUbicado && fila == 0 && columna == cantColumnas - 1){
        yaUbicado = true;
        coordenadas = [
            [0, columna - 1],
            [1, columna - 1],
            [1, columna]
        ]
    }

    if(!yaUbicado && fila == cantFilas - 1 && columna == 0){
        yaUbicado = true
        coordenadas = [
            [fila - 1, 0],
            [fila - 1, 1],
            [fila, 1]
        ];
    }

    if(!yaUbicado && fila == cantFilas - 1 && columna == cantColumnas - 1){
        yaUbicado = true;
        coordenadas = [
            [fila - 1, columna],
            [fila - 1, columna - 1],
            [fila, columna - 1]
        ]
    }

    // checamos si una de sus coordenadas está pegada a un borde
    if(!yaUbicado && columna > 0 && columna < cantColumnas - 1 && fila == 0){
        yaUbicado = true;
        coordenadas = [
            [fila, columna - 1],
            [fila + 1, columna - 1],
            [fila + 1, columna],
            [fila + 1, columna + 1],
            [fila, columna + 1]
        ]
    }

    if(!yaUbicado && columna > 0 && columna < cantColumnas - 1 && fila == cantFilas - 1){
        yaUbicado = true;
        coordenadas = [
            [fila - 1, columna - 1],
            [fila - 1, columna],
            [fila - 1, columna + 1],
            [fila, columna - 1],
            [fila, columna + 1]
        ];
    }

    if(!yaUbicado && fila > 0 && fila < cantFilas - 1 && columna == 0){
        yaUbicado = true;
        coordenadas = [
            [fila - 1, columna],
            [fila - 1, columna + 1],
            [fila, columna + 1],
            [fila + 1, columna + 1],
            [fila + 1, columna]
        ];
    }

    if(!yaUbicado && fila > 0 && fila < cantFilas - 1 && columna == cantColumnas - 1){
        yaUbicado = true;
        coordenadas = [
            [fila - 1, columna],
            [fila - 1, columna - 1],
            [fila, columna - 1],
            [fila + 1, columna - 1],
            [fila + 1, columna]
        ];
    }

    // cuando está separado de las orillas
    if(!yaUbicado){
        coordenadas = [
            [fila - 1, columna - 1],
            [fila - 1, columna],
            [fila - 1, columna + 1],
            [fila, columna - 1],
            [fila, columna + 1],
            [fila + 1, columna - 1],
            [fila + 1, columna],
            [fila + 1, columna + 1]
        ];
    }

    coordenadas.forEach(([filaAr, columnaAr]) => {
        arrayEspaciosAdyacentes.push(new Espacio(filaAr, columnaAr));
    });

    return arrayEspaciosAdyacentes;
}

/**
 * Recibe unas coordenadas como parametro y devuelve su tipo (mina o cuadriculalibre)
 * @returns {*}
 * @param filaEspacio
 * @param columnaEspacio
 */
function checarTipo(filaEspacio, columnaEspacio){
    for(let i = 0; i < listaMinas.length; i++){
        let mina = listaMinas[i];
        if(mina.posFila == filaEspacio && mina.posColumna == columnaEspacio){
            return mina;
        }
    }

    for(let i = 0; i < listaCuadriculasLibres.length; i++){
        let cuadriculaLibre = listaCuadriculasLibres[i];
        if(cuadriculaLibre.posFila == filaEspacio && cuadriculaLibre.posColumna == columnaEspacio){
            return cuadriculaLibre;
        }
    }
}