const btn_register = document.querySelector('#btn-register');

// INPUTS
const inputUsername = document.querySelector('#txt-username');
const inputName = document.querySelector('#txt-name');
const inputLastname = document.querySelector('#txt-lastname');
const inputGender = document.querySelector('#select-gender');
const inputBirthdate = document.querySelector("#input-birthdate");
const inputPassword = document.querySelector('#txt-password');
const inputConfirmPassword = document.querySelector('#txt-confirm-password');

// AVISOS
const warnUsername = document.querySelector("#warning-username");
const warnName = document.querySelector("#warning-name");
const warnGender = document.querySelector("#warning-gender");
const warnPassword = document.querySelector("#warning-password");
const warnConfPassword = document.querySelector("#warning-conf-password");

let username;
let name;
let lastname;
let gender;
let birthdate;
let password;
let confirmPassword;

btn_register.addEventListener("click", async e => {
    e.preventDefault();

    limpiarWarnings();
    username = inputUsername.value.trim().toLowerCase();
    name = inputName.value.trim();
    lastname = inputLastname.value.trim();
    gender = inputGender.value;
    birthdate = inputBirthdate.value;
    password = inputPassword.value.trim();
    confirmPassword = inputConfirmPassword.value.trim();

    if (!validarLlenos()) {
        return;
    }

    if (!validarFormatos()) {
        return;
    }

    if (!validarPasswords()) {
        return;
    }

    const datos = new FormData();
    datos.append('username', username);
    datos.append('name', name);
    datos.append('lastname', lastname);
    datos.append('gender', gender);
    datos.append('birthdate', birthdate);
    datos.append('password', password);
    datos.append('confirm_password', confirmPassword);

    const res = await fetch(
        `${APP_ROOT}validar_registro.php`,
        {method: "POST", body: datos}
    );

    const resObj = await res.json();
    if (resObj.errors) {
        mostrarAvisos(resObj.errors);
        return;
    }

    Swal.fire({
        title: 'Registro Exitoso',
        icon: 'success',
        confirmButtonText: 'Continuar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/practicas/practica05-1/login.php"
        }
    });
});

function validarLlenos() {
    let valid = true;

    if (!username) {
        warnUsername.innerHTML = "Introduzca un username";
        valid = false;
    }

    if (!name) {
        warnName.innerHTML = "Introduzca un nombre";
        valid = false;
    }

    if (!gender) {
        warnGender.innerHTML = "Seleccione una opción válida";
        valid = false;
    }

    if (!password) {
        warnPassword.innerHTML = "Introduzca una contraseña";
        valid = false;
    }

    if (!confirmPassword) {
        warnConfPassword.innerHTML = "Debe de confirmar la contraseña";
        valid = false;
    }

    return valid;
}

function validarFormatos() {
    let valid = true;
    let pattern = /^[a-z0-9_]{5,}$/;

    if (!pattern.test(username)) {
        warnUsername.innerHTML = "El username debe de ser de mínimo 5 caracteres y sólo incluye letras (a-z), números (0-9) o guión bajo (_)";
        valid = false;
    }

    pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!pattern.test(password)) {
        warnPassword.innerHTML = "La contraseña debe de ser de mínimo 8 caracteres y debe incluir letras (a-z) y números (0-9)";
        valid = false;
    }

    return valid;
}

function validarPasswords() {
    if (confirmPassword != password) {
        warnConfPassword.innerHTML = "Las contraseñas no coinciden";
        return false;
    }

    return true;
}

function mostrarAvisos(errors) {
    const warnings = [
        this.warnUsername = warnUsername,
        this.warnName = warnName,
        this.warnGender = warnGender,
        this.warnPassword = warnPassword,
        this.warnConfPassword = warnConfPassword
    ];

    for (const error of errors) {
        const warning = warnings[error["pos"]];
        warning.innerHTML = error["msg"];
    }
}

function limpiarWarnings() {
    warnUsername.innerHTML = "";
    warnName.innerHTML = "";
    warnGender.innerHTML = "";
    warnPassword.innerHTML = "";
    warnConfPassword.innerHTML = "";
}