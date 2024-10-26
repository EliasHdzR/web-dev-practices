const tablero = document.querySelector('#tablero');
let listaCuadrados = [];
listaCuadrados = tablero.getElementsByTagName('td');

// este lo ocupo pq al parecer si no paso por referencia el evento este no se remueve usando el removeEventListener en la linea 102
let eventosCuadrado = [];

for(let cuadrado of listaCuadrados){
    let idTemp = cuadrado.getAttribute('id');
    eventosCuadrado[idTemp] = volverFuncional(cuadrado);
    cuadrado.addEventListener('click', eventosCuadrado[idTemp]);
}

/**
 * Esta funcion devuelve una funcion que se encarga de que el usuario pueda elegir un cuadrado y se ponga una imagen
 * cuando ponga la imagen y realice las validaciones el cuadrado se tiene que quedar inutil
 * La funcion que devuelve esta funcion se activa varias veces por partida del gato
 * @param {*} cuadrado 
 * @returns una funcion
 */
function volverFuncional(cuadrado){
    const cuadradoActionClick = () => {
        const img = document.createElement('img');
        img.setAttribute('src','images/circulo.png');
        img.setAttribute('width','80px');
        cuadrado.setAttribute('style','text-align: center;');
        cuadrado.appendChild(img);

        cuadrado.removeEventListener('click',cuadradoActionClick);
        cuadrado.removeEventListener('click',comprobarTablero);
        cuadrado.removeEventListener('click',turnoComputadora);

        let ganador = comprobarTablero();
        switch(ganador){
            case "jugador":
                return;
            case "computadora":
                return;
            case "empate":
                retu
        }

        turnoComputadora();

    }
    
    return cuadradoActionClick;
}