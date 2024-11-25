<?php
    require "config.php";
    require APP_PATH . "actualizacion_helper.php";
    require_once APP_PATH . "session.php";

    header("Content-Type: application/json");
    $errors = [];

    $password = trim(filter_input(INPUT_POST, 'password'));
    $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password'));

    /// VALIDAR QUE ESTÉN LLENOS
    if (!$password) {
        $error = ["pos" => "2", "msg" => "Debe introducir una contraseña"];
        $errors[] = $error;
    }

    if (!$confirm_password) {
        $error = ["pos" => "3", "msg" => "Debe confirmar la contraseña"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    // VALIDAR FORMATO DE USERNAME Y CONTRASEÑA
    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if (!preg_match($pattern, $password)) {
        $error = ["pos" => "2", "msg" => "La contraseña debe de ser de mínimo 8 caracteres y debe incluir letras (a-z) y números (0-9)"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    // VALIDAR PASSWORDS
    if($confirm_password != $password){
        $error = ["pos" => "3", "msg" => "Las contraseñas no coinciden"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    $usuario = [
        "id" => $USUARIO_ID,
        "password" => $password,
    ];

    actualizarPassword($usuario);
    $resObj = ["errors" => NULL];
    echo json_encode($resObj);
