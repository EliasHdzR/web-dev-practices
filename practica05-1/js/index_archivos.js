const table = document.querySelector('table');
const trs = table.getElementsByClassName("tr-datos");
const tdsBotones = table.getElementsByClassName("td-botones");
const selectMeses = document.querySelector("#select-meses");
const selectAnios = document.querySelector("#select-anios");
const btnFiltrar = document.querySelector('#btn-filtrar');
btnFiltrar.addEventListener("click", filtrarArchivos);

const date = new Date();
const month = date.getMonth();
const year = date.getFullYear();

selectMeses.selectedIndex = month;
selectAnios.selectedIndex = year - year;

funcionalidadBotones();

function funcionalidadBotones(){
    for(let i = 0; i < trs.length; i++){
        const tr = trs[i];
        const link = tr.getElementsByTagName("a")[0];
        link.addEventListener("click", function(e){ verArchivo(e, link.id) });
    }

    for(let i = 0; i < tdsBotones.length; i++){
        const td = tdsBotones[i];
        const botones = td.getElementsByTagName("button");

        const btnVisibilidad = botones[0];
        if(btnVisibilidad.className === "btn-privar"){
            btnVisibilidad.addEventListener("click", function(){ privarArchivo(btnVisibilidad.id) });
        } else {
            btnVisibilidad.addEventListener("click", function(){ publicarArchivo(btnVisibilidad.id) });
        }

        const btnBorrar = botones[1];
        btnBorrar.addEventListener("click", function(){ eliminarArchivo(btnBorrar.id) });
    }
}

async function filtrarArchivos(){
    const mesElegido = selectMeses.value;
    const anioElegido = selectAnios.value;

    const datos = new FormData();
    datos.append('mes', mesElegido);
    datos.append('anio', anioElegido);
    const res = await fetch(
        `${APP_ROOT}archivos_methods/filtrar_archivos.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    const tbody = table.querySelector('tbody');
    const rows = table.querySelectorAll("tr");

    rows.forEach((row) => {
        if (!row.querySelector("th")) {
            row.remove();
        }
    });

    resObj.archivos.forEach((obj) => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('class', 'tr-datos');

        const a = document.createElement('a');
        a.setAttribute('href', '');
        a.setAttribute('id', `btn-view-${obj["id"]}`);
        a.innerHTML = obj["nombre_archivo"];

        const tdLink = document.createElement('td');
        tdLink.appendChild(a);
        newRow.appendChild(tdLink);

        for (const data in obj) {
            if (data !== "usuario_subio_id" && data !== "id" && data !== "nombre_archivo" && data !== "es_publico") {
                const td = document.createElement('td');
                td.innerHTML = obj[data];
                newRow.appendChild(td);
            }
        }

        const tdVisibilidad = document.createElement('td');
        let btnAcceso;
        newRow.appendChild(tdVisibilidad);
        if(obj["es_publico"] == 1){
            tdVisibilidad.innerHTML = "Público";
            btnAcceso = document.createElement('button');
            btnAcceso.setAttribute('id',`btn-privar-${obj["id"]}`);
            btnAcceso.innerHTML = "Hacer Privado";
            btnAcceso.setAttribute('class', 'btn-privar');
        } else {
            tdVisibilidad.innerHTML = "Privado";
            btnAcceso = document.createElement('button');
            btnAcceso.setAttribute('id',`btn-publicar-${obj["id"]}`);
            btnAcceso.innerHTML = "Hacer Público";
            btnAcceso.setAttribute('class', 'btn-publicar');
        }

        const tdButtons = document.createElement('td');
        tdButtons.setAttribute('class','td-botones');
        newRow.appendChild(tdButtons);
        tdButtons.appendChild(btnAcceso);

        const delBtn = document.createElement('button');
        delBtn.setAttribute('id',`btn-delete-${obj["id"]}`);
        delBtn.innerHTML = "Eliminar Archivo";
        tdButtons.appendChild(delBtn);

        tbody.appendChild(newRow);
    });

    funcionalidadBotones();
}

function verArchivo(e, id) {
    e.preventDefault();
    const idArchivo = id.split("-")[2];
    const button = document.getElementById(id);
    const row = button.parentNode.parentNode;
    row.children[4].innerHTML = parseInt(row.children[4].innerHTML) + 1;

    const url = `${APP_ROOT}archivos_methods/archivo.php?id=${idArchivo}`;
    window.open(url, '_blank');
}

function privarArchivo(id){
    const idArchivo = id.split("-")[2];

    Swal.fire({
        title: 'Despublicar Archivo',
        icon: 'question',
        text: '¿Deseas que el archivo sea privado?',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idArchivo);

            const res = await fetch(
                `${APP_ROOT}archivos_methods/despublicar_archivo.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();

            Swal.fire({
                title: resObj["titulo"],
                icon: resObj["estado"],
                text: resObj["mensaje"],
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if(result.isConfirmed){
                    const button = document.getElementById(id);
                    const row = button.parentNode.parentNode;
                    button.innerHTML = 'Hacer Público';
                    button.setAttribute('id', `btn-publicar-${idArchivo}`);
                    button.setAttribute('class', 'btn-publicar');
                    row.children[5].innerHTML = 'Privado';
                    funcionalidadBotones();
                }
            });
        }
    });
}

function publicarArchivo(id){
    const idArchivo = id.split("-")[2];

    Swal.fire({
        title: 'Publicar Archivo',
        icon: 'question',
        text: '¿Deseas publicar el archivo?',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idArchivo);

            const res = await fetch(
                `${APP_ROOT}archivos_methods/publicar_archivo.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();

            Swal.fire({
                title: resObj["titulo"],
                icon: resObj["estado"],
                text: resObj["mensaje"],
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if(result.isConfirmed){
                    const button = document.getElementById(id);
                    const row = button.parentNode.parentNode;
                    button.innerHTML = 'Hacer Privado';
                    button.setAttribute('id', `btn-privar-${idArchivo}`);
                    button.setAttribute('class', 'btn-privar');
                    row.children[5].innerHTML = 'Público';
                    funcionalidadBotones();
                }
            });
        }
    });
}

function eliminarArchivo(id){
    const idArchivo = id.split("-")[2];

    Swal.fire({
        title: 'Eliminar Archivo',
        icon: 'warning',
        text: 'Se eliminará el archivo seleccionado',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idArchivo);

            const res = await fetch(
                `${APP_ROOT}archivos_methods/eliminar_archivo.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();

            Swal.fire({
                title: resObj["titulo"],
                icon: resObj["estado"],
                text: resObj["mensaje"],
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if(result.isConfirmed){
                    const button = document.getElementById(id);
                    const row = button.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                }
            });
        }
    });
}