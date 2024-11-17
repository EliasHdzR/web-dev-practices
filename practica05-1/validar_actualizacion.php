<?php
    require "config.php";
    require APP_PATH . "actualizacion_helper.php";
    require_once APP_PATH . "session.php";

    header("Content-Type: application/json");
    $errors = [];

    $name = trim(filter_input(INPUT_POST, 'name'));
    $lastname = trim(filter_input(INPUT_POST, 'lastname'));
    $gender = filter_input(INPUT_POST, 'gender');
    $birthdate = filter_input(INPUT_POST, 'birthdate');

    /// VALIDAR QUE ESTÉN LLENOS
    if (!$name) {
        $error = ["pos" => "1", "msg" => "Debe introducir un nombre"];
        $errors[] = $error;
    }

    if (!$gender) {
        $error = ["pos" => "2", "msg" => "Seleccione una opción válida"];
        $errors[] = $error;
    }

    if (sizeof($errors) > 0) {
        $resObj = ["errors" => $errors];
        echo json_encode($resObj);
        exit();
    }

    $usuario = [
        "id" => $USUARIO_ID,
        "name" => $name,
        "lastname" => $lastname,
        "gender" => $gender,
        "birthdate" => $birthdate,
    ];

    actualizar($usuario);
    $resObj = ["errors" => NULL];
    echo json_encode($resObj);
