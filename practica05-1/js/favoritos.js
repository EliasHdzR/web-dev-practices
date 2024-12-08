const table = document.querySelector('table');
const trs = table.getElementsByClassName("tr-datos");
const tdsBotones = table.getElementsByClassName("td-botones");


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
        if(btnFavorito.className === "btn-quitar-favorito"){
            btnFavorito.addEventListener("click", function(){ quitarFavorito(btnFavorito.id) });
        } else {
            console.log("esto no se debería imprimir nunca")
        }
    }
}

function verArchivo(e, id) {
    e.preventDefault();
    const idArchivo = id.split("-")[2];

    const url = `${APP_ROOT}archivos_methods/archivo.php?id=${idArchivo}`;
    window.open(url, '_blank');
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
                    button.parentNode.parentNode.remove();
                }
            });
        }
    });
}