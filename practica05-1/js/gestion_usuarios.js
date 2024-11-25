const inputSearch = document.querySelector("#input-search");
inputSearch.addEventListener("input", function () {realizarBusqueda(inputSearch.value)})

const users_table = document.querySelector("#users-table");
const tds = users_table.getElementsByClassName("td-botones");

funcionalidadBotones();

function funcionalidadBotones(){
    for(let i = 0; i < tds.length; i++){
        const td = tds[i];
        const buttons = td.getElementsByTagName("button");

        if(buttons.length == 2){
            const btnReset = buttons[0];
            btnReset.addEventListener("click", function() {resetearPassword(btnReset.id)});
            const btnDelete = buttons[1];
            btnDelete.addEventListener("click", function() {eliminarCuenta(btnDelete.id)});
        }

        if(buttons.length == 3){
            const btnUpgrade = buttons[0];
            btnUpgrade.addEventListener("click", function (){upgradearCuenta(btnUpgrade.id)});
            const btnReset = buttons[1];
            btnReset.addEventListener("click", function() {resetearPassword(btnReset.id)});
            const btnDelete = buttons[2];
            btnDelete.addEventListener("click", function() {eliminarCuenta(btnDelete.id)});
        }
    }
}

function upgradearCuenta(id){
    const idUsuario = id.split("-")[2];

    Swal.fire({
        title: 'Upgradear Cuenta',
        icon: 'question',
        text: 'Este usuario se convertirá en administrador',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idUsuario);

            const res = await fetch(
                `${APP_ROOT}upgradear_cuenta.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();
            console.log(resObj);
            Swal.fire({
                title: resObj["titulo"],
                icon: resObj["estado"],
                text: resObj["mensaje"],
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if(result.isConfirmed){
                    const button = document.getElementById(id);
                    const row = button.parentNode.parentNode;
                    button.parentNode.removeChild(button);
                    row.firstChild.innerHTML = "Administrador";
                }
            });
        }
    });
}

function resetearPassword(id){
    const idUsuario = id.split("-")[2];

    Swal.fire({
        title: 'Resetear Password',
        icon: 'question',
        text: 'Se reseteará la contraseña de este usuario',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idUsuario);

            const res = await fetch(
                `${APP_ROOT}resetear_password.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();
            Swal.fire({
                title: resObj["titulo"],
                icon: resObj["estado"],
                text: resObj["mensaje"],
                confirmButtonText: 'Aceptar',
            });
        }
    });
}

function eliminarCuenta(id){
    const idUsuario = id.split("-")[2];

    Swal.fire({
        title: 'Eliminar',
        icon: 'warning',
        text: 'Se eliminará la cuenta de este usuario',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const datos = new FormData();
            datos.append('id', idUsuario);

            const res = await fetch(
                `${APP_ROOT}eliminar_cuenta.php`,
                {method: "POST", body: datos}
            );

            const resObj = await res.json();
            console.log(resObj);
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

async function realizarBusqueda(cadena) {
    cadena = cadena.toLowerCase();
    const datos = new FormData();
    datos.append("busqueda", cadena);

    const res = await fetch(
        `${APP_ROOT}buscar_usuarios.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    console.log(resObj);
    const tbody = users_table.querySelector('tbody');
    const rows = users_table.querySelectorAll("tr");

    rows.forEach((row) => {
        if (!row.querySelector("th")) {
            row.remove();
        }
    });

    resObj.usuarios.forEach((obj) => {
        const newRow = document.createElement('tr');
        const tdRol = document.createElement('td');
        newRow.appendChild(tdRol);

        for (const data in obj) {
            if (data !== "es_admin" && data !== "id") {
                const td = document.createElement('td');
                td.innerHTML = obj[data];
                newRow.appendChild(td);
            }
        }

        const tdButtons = document.createElement('td');
        tdButtons.setAttribute('class','td-botones');
        newRow.appendChild(tdButtons);

        if(obj["es_admin"] == 1){
            tdRol.innerHTML = "Administrador";
        } else {
            tdRol.innerHTML = "Usuario";
            const doAdminBtn = document.createElement('button');
            doAdminBtn.setAttribute('id',`btn-upgrade-${obj["id"]}`);
            doAdminBtn.innerHTML = "Convertir a Administrador";
            tdButtons.appendChild(doAdminBtn);
        }

        const resetPsBtn = document.createElement('button');
        resetPsBtn.setAttribute('id',`btn-reset-${obj["id"]}`)
        resetPsBtn.innerHTML = "Resetear Password";
        tdButtons.appendChild(resetPsBtn);

        const delUserBtn = document.createElement('button');
        delUserBtn.setAttribute('id',`btn-delete-${obj["id"]}`);
        delUserBtn.innerHTML = "Eliminar Usuario";
        tdButtons.appendChild(delUserBtn);

        tbody.appendChild(newRow);
    });

    funcionalidadBotones();
}