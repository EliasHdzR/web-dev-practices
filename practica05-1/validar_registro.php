<?php
    require "config.php";
    require APP_PATH . "registro_helper.php";

    header("Content-Type: application/json");
    $errors = [];

    $username = strtolower(trim(filter_input(INPUT_POST, 'username')));
    $name = trim(filter_input(INPUT_POST, 'name'));
    $lastname = trim(filter_input(INPUT_POST, 'lastname'));
    $gender = filter_input(INPUT_POST, 'gender');
    $birthdate = filter_input(INPUT_POST, 'birthdate');
    $password = trim(filter_input(INPUT_POST, 'password'));
    $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password'));

    /// VALIDAR QUE ESTÉN LLENOS
    if (!$username) {
        $error = ["pos" => "0", "msg" => "Debe introducir un username"];
        $errors[] = $error;
    }

    if (!$name) {
        $error = ["pos" => "1", "msg" => "Debe introducir un nombre"];
        $errors[] = $error;
    }

    if (!$gender) {
        $error = ["pos" => "2", "msg" => "Seleccione una opción válida"];
        $errors[] = $error;
    }

    if (!$password) {
        $error = ["pos" => "3", "msg" => "Debe introducir una contraseña"];
        $errors[] = $error;
    }

    if (!$confirm_password) {
        $error = ["pos" => "4", "msg" => "Debe confirmar la contraseña"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    // VALIDAR FORMATO DE USERNAME Y CONTRASEÑA
    $pattern = "/^[a-z0-9_]{5,}$/";
    if (!preg_match($pattern, $username)) {
        $error = ["pos" => "1", "msg" => "El username debe de ser de mínimo 5 caracteres y sólo incluye letras (a-z), números (0-9) o guión bajo (_)"];
        $errors[] = $error;
    }

    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if (!preg_match($pattern, $password)) {
        $error = ["pos" => "3", "msg" => "La contraseña debe de ser de mínimo 8 caracteres y debe incluir letras (a-z) y números (0-9)"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    // VALIDAR PASSWORDS
    if($confirm_password != $password){
        $error = ["pos" => "4", "msg" => "Las contraseñas no coinciden"];
        $errors[] = $error;
    }

    // VALIDAR EXISTENCIA DE USERNAME
    if (!validar($username)) {
        $error = ["pos" => "0", "msg" => "El username ingresado ya está registrado"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    $usuario = [
        "username" => $username,
        "name" => $name,
        "lastname" => $lastname,
        "gender" => $gender,
        "birthdate" => $birthdate,
        "password" => $password,
    ];

    registrar($usuario);
    $resObj = ["errors" => NULL];
    echo json_encode($resObj);