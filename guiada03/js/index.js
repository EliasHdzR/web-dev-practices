/**
 ******************************************
 ****** FUNCIONES DE PRIMER ORDEN *********
 ******************************************
 Permiten recibir como parámetro otras funciones, así como regresar una función
 */

const btnEjecutar = document.querySelector('#btn-ejecutar');
const sProcesoStatus = document.querySelector('#s-proceso-status');

async function btnEjecutar_click(e){
    btnEjecutar.disabled = true;
    sProcesoStatus.textContent = "En ejecución";
    const resultado = await procesoTardado(4,'ProcButton'); // el await solo se puedee usar en funciones asíncronas
    sProcesoStatus.textContent = `La ejecución regresó ${resultado}`;
    btnEjecutar.disabled = false;
}

btnEjecutar.addEventListener('click', btnEjecutar_click);

function iterador(desde, hasta, accion){
    for(let i = desde; i <= hasta; i++){
        accion(i);
    }
}

// se pueden mandar funciones como parámetros a otras funciones
/*iterador(1,10, function(i){
    console.log(`Iteracion ${i}`);
});*/

// esta arrow function es equivalente a la anterior
iterador(1,10, i => {
    console.log(`Iteracion ${i}`);
});

const fun0hasta2 = i => {  //esto equivale a function fun0hasta2(i)
    alert(`Hola #${i}`);
};

iterador(0, 2, fun0hasta2);

// en js las funciones también pueden devolver funciones como resultado
function hacerSumador(numASumar){
    let suma = 0;
    const funcionResultado = () => {
        suma += numASumar;
        console.log(`Suma a ${numASumar} esta en ${suma}`);
    }

    return funcionResultado;
}

const sumador1 = hacerSumador(1);
const sumador2 = hacerSumador(2);

sumador1();
sumador1();
sumador2();
sumador1();

setTimeout(() => {
    console.log('Timeout ejecutado');
}, 2500);

console.log('Mensaje despues de la definicion del timeout');

function procesoTardado(tiempoSegundos, nombreProceso){
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            console.log(`Proceso ${nombreProceso} terminado`);
            resolve(tiempoSegundos * 1000);
        }, tiempoSegundos * 1000);
    });
}

console.log('empieza proc01');
procesoTardado(5, 'proc01').then(resultado => {
    console.log('esto se ejecuta después de que termina el proceso1');
    console.log(`proc regresó -> ${resultado}`);
});
console.log('terminó proceso1?');
