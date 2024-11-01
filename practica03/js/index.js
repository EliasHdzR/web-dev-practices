const inputTamano = document.querySelector("#input-filas");
const inputColumnas = document.querySelector("#input-columnas");
const btnTamano = document.querySelector("#btn-tamano");

const divEleccion = document.querySelector(".eleccion-container");
const divJuego = document.querySelector(".juego-container");
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
}

function iniciarJuego(filas, columnas, minas){
    cantFilas = filas;
    cantColumnas = columnas;
    cantMinas = minas;

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
    if(primerTurno){
        primerTurno = false;
        generarMinas(idBoton);
        console.log(listaMinas);
    }
}

function generarMinas(idBoton){
    for(let i = 0; i < cantMinas; i++){
        let yaExiste = false;
        const randomFila = Math.random() * cantFilas;
        const randomColumna = Math.random() * cantColumnas;

        // no se pede generar una mina en el boton que se clickeó
        if(`btn-${randomFila}-${randomColumna}` === idBoton){
            i--;
            continue;
        }

        const boton = document.querySelector(`#btn-${randomFila}-${randomColumna}`);
        const nuevaMina = new Mina(randomFila, randomColumna, boton);

        // para checar que no se generen 2 minas en el mismo espacio
        for(let j = 0; j < listaMinas.length; j++){
            const minaExistente = listaMinas.at(j);
            if(!minaExistente) break;
            if(minaExistente.botonAsociado === nuevaMina.botonAsociado){
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
                const mina = listaMinas.at(h);
                if(mina.posFila === cuadriculaLibre.posFila && mina.posColumna === cuadriculaLibre.posColumna){
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

}

/**
 * Devuelve todos los espacios adyacentes de un cuadrado dado, el cuadrado puede ser un boton o una mina
 */
function getEspaciosLibresAdyacentes(espacio){
    const fila = espacio.posFila;
    const columna = espacio.posColumna;
    let arrayCuadriculasLibresAdyacentes = [];

    if(fila === 0 && columna === 0){
        arrayAdyacentes.push()
    }
}