//ELEMENTOS HTML
const txtNombre = document.querySelector('#txt-nombre');
const btnAccion = document.querySelector('#btn-accion');
//const body = document.querySelector('#body');

const sUserAgent = document.getElementById('s-user-agent');
sUserAgent.textContent = navigator.userAgent;

const txtItem = document.querySelector('#txt-item');
const btnAgregarItem = document.querySelector('#btn-agregar-item');
const ulLista = document.querySelector('#ul-lista');

if(!localStorage.getItem('listaElementos')){
    let lista = [];
    localStorage.setItem('listaElementos', JSON.stringify(lista));
}

const lista = JSON.parse(localStorage.getItem('listaElementos'));
for(let i of lista){
    let li = document.createElement('li');
    li.textContent = i;
    li.addEventListener('click', li_click);
    ulLista.appendChild(li);
}

function btnAccionClick(e) {
    const nombre = txtNombre.value.trim();

    if (!nombre) {
        txtNombre.focus();
        return;
    }

    const mensaje = `Hola ${nombre}, bienvenido a JS`;
    alert(mensaje);

    txtNombre.value = '';
    txtNombre.focus();
}

btnAccion.addEventListener('click', btnAccionClick);

txtNombre.addEventListener('keydown', function (e) {
    console.log(e.key);
    if (e.key == 'Enter') {
        btnAccion.click();
    }
});

// Accion agregar item
btnAgregarItem.addEventListener('click', e => {
    const itemNombre = txtItem.value.trim();
    if(!itemNombre){
        txtItem.focus();
        return;
    }

    const li = document.createElement('li');
    li.textContent = itemNombre;
    li.addEventListener('click', li_click);
    ulLista.appendChild(li);
    txtItem.value = "";
    txtItem.focus();
    lista.push(itemNombre);
    localStorage.setItem('listaElementos', JSON.stringify(lista));
});

function li_click(e){
    //this apunta al li que se hizo click porque nos encontramos en el contexto de un eventListener del li presionado
    const li = this;
    console.log(li);
    console.log(e);
    alert('Elemento clickeado! =>' + li.textContent);
}

///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////

function Persona(nombre, apellidos, edad){
    this.nombre = nombre;
    this.apellidos = apellidos;
    this.edad = edad;

    this.saludar = function(){
        console.log(`Hola, soy ${this.nombre}`);
    }
}

const persona1 = new Persona('Luis','Flores',35);
persona1.saludar();


// js es un lenguaje dinamico, se pueden agregar variables de instancia como propiedades y funciones al vuelo
// la instancia persona2 NO tiene estas nuevas propiedades
persona1.otraPropiedad = 'OTRA PROPIEDAD';
console.log(persona1.otraPropiedad);

persona1.decirEdad = function(){
    console.log(`Tengo ${this.edad} años`);
}
persona1.decirEdad();

const persona2 = new Persona('Roberto','de la Fuente',36);
persona2.saludar();
console.log(persona1);

// si utilizamos prototype, ahora sí todas las instancias posteriores a su definición pueden acceder a esta nueva propiedad
Persona.prototype.imprimirNombreCompleto = function(){
    console.log(`${this.nombre} ${this.apellidos}`);
}

persona1.imprimirNombreCompleto();
persona2.imprimirNombreCompleto();

if(typeof(persona2.decirEdad) == 'function'){
    persona2.decirEdad();
} else {
    console.log('decirEdad() no implementado en persona2');
}

///////////////
const obj1 = {
    nombre: 'Juan',
    apellidos: 'Perez'
}

const arr01 = [];
arr01.push(persona1);
arr01.push(persona2);

Persona.prototype.getNombreCompleto = function(){
    return `${this.nombre} ${this.apellidos}`
}

let arrNombres = arr01.filter(persona => persona.getNombreCompleto());
console.log('nombres', arrNombres);

const arr02 = [1,2,3,4,5,6,7,8,9];
let arrT = arr02.filter(function(num, ix, arr) { return num % 2 == 0 });
console.log('pares', arrT);

// esta funcion es equivalente al filtro de la linea 117
function soloNones(arr){
    for (let i = 0; i < arr.length(); i++){
        if(arr[i] % 2 != 0) {
            arrRes.push(arr[i]);
        }
    }

    return arrRes;
}

arrT = arr02.filter((num, ix, arr) => num % 2 != 0);
console.log('nones', arrT);

// map se utiliz para realizar operaciones en un array y devolver los resultados obtenidos como un nuevo array
arrTT = arr02.map(i=> i * 2);
console.log('dobles', arrT);