const btnSubirArchivo = document.querySelector('#btn-subir-archivo');
btnSubirArchivo.addEventListener('click', subirArchivo);
const inputArchivo = document.querySelector('#input-file');
const labelErrorArchivo = document.querySelector('#label-error-archivo');

const contentTypes = ["image/jpeg", "image/jpeg", "image/gif", "image/png", "application/pdf"];

async function subirArchivo() {
    labelErrorArchivo.innerHTML = "";
    let archivo = inputArchivo.files[0];

    if (archivo == undefined) {
        labelErrorArchivo.innerHTML = "No se ha seleccionado ningún archivo";
        return;
    }

    if (!contentTypes.includes(archivo.type)) {
        labelErrorArchivo.innerHTML = "El archivo no es una imagen o un PDF";
        return;
    }

    const datos = new FormData();
    datos.append('archivo', archivo);
    const res = await fetch(
        `${APP_ROOT}/ajax/guardar_archivo.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    if (resObj.errors) {
        labelErrorArchivo.innerHTML = resObj.errors;
        return;
    }

    labelErrorArchivo.innerHTML = resObj.mensaje;
}
