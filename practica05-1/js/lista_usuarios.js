const inputSearch = document.querySelector("#input-search");
const btnSearch = document.querySelector("#btn-search");
btnSearch.addEventListener("click", function () {realizarBusqueda(inputSearch.value)})

const users_table = document.querySelector("#users-table");

function funcionalidadBotones(){
    const btnsVerArchivos = document.getElementsByClassName("btn-ver-archivos");
    for (let i = 0; i < btnsVerArchivos.length; i++) {
        btnsVerArchivos[i].addEventListener("click", function () {
            const usuarioId = btnsVerArchivos[i].id.split("-")[3];
            window.location.href = `${APP_ROOT}busqueda_files_usuarios/ver_archivos.php?usuario_id=${usuarioId}`;
        });
    }
}

async function realizarBusqueda(cadena) {
    if (cadena === "") {
        inputSearch.focus()
        return;
    }

    users_table.removeAttribute("hidden");
    cadena = cadena.toLowerCase();
    const datos = new FormData();
    datos.append("busqueda", cadena);

    const res = await fetch(
        `${APP_ROOT}busqueda_files_usuarios/buscar_usuarios.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    const tbody = users_table.querySelector('tbody');
    const rows = users_table.querySelectorAll("tr");

    rows.forEach((row) => {
        if (!row.querySelector("th")) {
            row.remove();
        }
    });

    resObj.usuarios.forEach((obj) => {
        const newRow = document.createElement('tr');

        const tdUsername = document.createElement('td');
        tdUsername.innerHTML = obj["username"];
        newRow.appendChild(tdUsername);

        const tdNombreCompleto = document.createElement('td');
        tdNombreCompleto.innerHTML = obj["nombre"] + " " + obj["apellidos"];
        newRow.appendChild(tdNombreCompleto);

        const tdAcciones = document.createElement('td');
        const btnVerArchivos = document.createElement('button');
        btnVerArchivos.setAttribute("class", "btn-ver-archivos");
        btnVerArchivos.setAttribute("id", `btn-ver-archivos-${obj["id"]}`);
        btnVerArchivos.innerHTML = "Ver archivos";
        tdAcciones.appendChild(btnVerArchivos);
        newRow.appendChild(tdAcciones);

        tbody.appendChild(newRow);
    });

    funcionalidadBotones();
}