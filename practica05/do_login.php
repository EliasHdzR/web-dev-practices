<?php
    require "config.php";
    require APP_PATH . "data_access/db.php";
    require APP_PATH . "login_helper.php";
    
    $username = filter_input(INPUT_POST, "username");
    $password = filter_input(INPUT_POST, "password");

    if(!$username || !$password){
        header("Location: " . APP_ROOT . "login.html");
        exit();
    }

    $usuario = autentificar($username, $password);
    var_dump($usuario);