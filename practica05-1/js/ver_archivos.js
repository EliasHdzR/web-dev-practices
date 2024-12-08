const table = document.querySelector('table');
const trs = table.getElementsByClassName("tr-datos");
const tdsBotones = table.getElementsByClassName("td-botones");
const selectMeses = document.querySelector("#select-meses");
const selectAnios = document.querySelector("#select-anios");
const propietarioID = document.querySelector("#propietario-id");
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

        const btnFavorito = botones[0];
        if(btnFavorito.className === "btn-marcar-favorito"){
            btnFavorito.addEventListener("click", function(){ marcarFavorito(btnFavorito.id) });
        } else {
            btnFavorito.addEventListener("click", function(){ quitarFavorito(btnFavorito.id) });
        }
    }
}

async function filtrarArchivos(){
    const mesElegido = selectMeses.value;
    const anioElegido = selectAnios.value;
    const propietario = propietarioID.value;

    const datos = new FormData();
    datos.append('mes', mesElegido);
    datos.append('anio', anioElegido);
    datos.append('propietario', propietario);
    const res = await fetch(
        `${APP_ROOT}busqueda_files_usuarios/filtrar_archivos.php`,
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
            if (data !== "id" && data !== "nombre_archivo" && data !== "favorito") {
                const td = document.createElement('td');
                td.innerHTML = obj[data];
                newRow.appendChild(td);
            }
        }

        let btnFavorito;
        if(obj["favorito"]){
            btnFavorito = document.createElement('button');
            btnFavorito.setAttribute('id',`btn-quitar-favorito-${obj["id"]}`);
            btnFavorito.innerHTML = "Quitar Favorito";
            btnFavorito.setAttribute('class', 'btn-quitar-favorito');
        } else {
            btnFavorito = document.createElement('button');
            btnFavorito.setAttribute('id',`btn-marcar-favorito-${obj["id"]}`);
            btnFavorito.innerHTML = "Marcar Favorito";
            btnFavorito.setAttribute('class', 'btn-marcar-favorito');
        }

        const tdButtons = document.createElement('td');
        tdButtons.setAttribute('class','td-botones');
        newRow.appendChild(tdButtons);
        tdButtons.appendChild(btnFavorito);

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

function marcarFavorito(id){
    const idArchivo = id.split("-")[3];

    Swal.fire({
        title: 'Marcar como Favorito',
        icon: 'question',
        text: '¿Deseas marcar el archivo como favorito?',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idArchivo);

            const res = await fetch(
                `${APP_ROOT}archivos_methods/marcar_favorito.php`,
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
                    button.innerHTML = 'Quitar Favorito';
                    button.setAttribute('id', `btn-quitar-favorito-${idArchivo}`);
                    button.setAttribute('class', 'btn-quitar-favorito');
                    funcionalidadBotones();
                }
            });
        }
    });
}

function quitarFavorito(id){
    const idArchivo = id.split("-")[3];

    Swal.fire({
        title: 'Quitar Favorito',
        icon: 'question',
        text: '¿Deseas quitar el archivo de favoritos?',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idArchivo);

            const res = await fetch(
                `${APP_ROOT}archivos_methods/quitar_favorito.php`,
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
                    button.innerHTML = 'Agregar Favorito';
                    button.setAttribute('id', `btn-marcar-favorito-${idArchivo}`);
                    button.setAttribute('class', 'btn-marcar-favorito');
                    funcionalidadBotones();
                }
            });
        }
    });
}