const btn_update = document.querySelector('#btn-update');
const btn_update_password = document.querySelector('#btn-upd-password');

// INPUTS
const inputName = document.querySelector('#txt-name');
const inputLastname = document.querySelector('#txt-lastname');
const inputGender = document.querySelector('#select-gender');
const inputBirthdate = document.querySelector("#input-birthdate");

const inputPassword = document.querySelector('#txt-password');
const inputConfirmPassword = document.querySelector('#txt-confirm-password');

// AVISOS
const warnName = document.querySelector("#warning-name");
const warnGender = document.querySelector("#warning-gender");

const warnPassword = document.querySelector("#warning-password");
const warnConfPassword = document.querySelector("#warning-conf-password");

let name;
let lastname;
let gender;
let birthdate;
let password;
let confirmPassword;

btn_update.addEventListener("click", async e => {
    e.preventDefault();

    limpiarWarnings();
    name = inputName.value.trim();
    lastname = inputLastname.value.trim();
    gender = inputGender.value;
    birthdate = inputBirthdate.value;

    if (!validarLlenos()) {
        return;
    }

    const datos = new FormData();
    datos.append('name', name);
    datos.append('lastname', lastname);
    datos.append('gender', gender);
    datos.append('birthdate', birthdate);

    const res = await fetch(
        `${APP_ROOT}validar_actualizacion.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    if (resObj.errors) {
        mostrarAvisos(resObj.errors);
        return;
    }

    Swal.fire({
        title: 'Actualización Exitosa',
        icon: 'success',
        text: 'Se cerrará tu sesión para actualizar tus datos',
        confirmButtonText: 'Continuar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/practicas/practica05-1/logout.php";
        }
    });
});

btn_update_password.addEventListener("click", async e => {
    e.preventDefault();
    password = inputPassword.value.trim();
    confirmPassword = inputConfirmPassword.value.trim();

    limpiarWarnings();
    if(!validarPasswords()){
        return;
    }

    const datos = new FormData();
    datos.append('password', password);
    datos.append('confirm_password', confirmPassword);

    const res = await fetch(
        `${APP_ROOT}validar_nueva_password.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    if (resObj.errors) {
        mostrarAvisos(resObj.errors);
        return;
    }

    Swal.fire({
        title: 'Actualizacion Exitosa',
        icon: 'success',
        text: 'Se cerrará tu sesión para actualizar tus datos',
        confirmButtonText: 'Continuar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/practicas/practica05-1/logout.php";
        }
    });
})

function validarLlenos() {
    let valid = true;

    if (!name) {
        warnName.innerHTML = "Introduzca un nombre";
        valid = false;
    }

    if (!gender) {
        warnGender.innerHTML = "Seleccione una opción válida";
        valid = false;
    }

    return valid;
}

function validarPasswords() {
    let valid = true;
    let pattern = /^[a-z0-9_]{5,}$/;

    if (!password) {
        warnPassword.innerHTML = "Introduzca una contraseña";
        valid = false;
    }

    if (!confirmPassword) {
        warnConfPassword.innerHTML = "Debe de confirmar la contraseña";
        valid = false;
    }

    if(!valid){
        return valid;
    }

    if (confirmPassword != password) {
        warnConfPassword.innerHTML = "Las contraseñas no coinciden";
        return false;
    }

    pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!pattern.test(password)) {
        warnPassword.innerHTML = "La contraseña debe de ser de mínimo 8 caracteres y sólo incluye letras (a-z) y números (0-9)";
        return false;
    }

    return true;
}

function mostrarAvisos(errors) {
    const warnings = [
        this.warnName = warnName,
        this.warnGender = warnGender,
        this.warnPassword = warnPassword,
        this.warnConfPassword = warnConfPassword,
    ];

    for (const error of errors) {
        const warning = warnings[error["pos"]];
        warning.innerHTML = error["msg"];
    }
}

function limpiarWarnings() {
    warnName.innerHTML = "";
    warnGender.innerHTML = "";
    warnPassword.innerHTML = "";
    warnConfPassword.innerHTML = "";
}