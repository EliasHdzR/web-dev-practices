const btnSubirArchivo = document.querySelector('#btn-subir-archivo');
btnSubirArchivo.addEventListener('click', subirArchivo);
const inputArchivo = document.querySelector('#input-file');
const labelErrorArchivo = document.querySelector('#label-error-archivo');
const inputDescripcion = document.querySelector('#input-descripcion');

const contentTypes = ["image/jpeg", "image/gif", "image/png", "application/pdf"];

async function subirArchivo() {
    labelErrorArchivo.setAttribute('style','color: darkred;')
    labelErrorArchivo.innerHTML = "";

    let descripcion = inputDescripcion.value;
    let archivo = inputArchivo.files[0];
    if (archivo == undefined) {
        labelErrorArchivo.innerHTML = "Archivo no especificado";
        return;
    }

    if (!contentTypes.includes(archivo.type)) {
        labelErrorArchivo.innerHTML = "El archivo no es una imagen o un PDF";
        return;
    }

    const extension = archivo.type.split('/')[1];
    const datos = new FormData();
    datos.append('archivo', archivo);
    datos.append('descripcion', descripcion);
    datos.append('extension', extension);
    const res = await fetch(
        `${APP_ROOT}/ajax/guardar_archivo.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    if (resObj.error) {
        labelErrorArchivo.innerHTML = resObj.error;
        return;
    }

    Swal.fire({
        title: 'Archivo guardado correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            inputArchivo.value = '';
            inputDescripcion.value = '';
            labelErrorArchivo.innerHTML = "";
        }
    });
}
