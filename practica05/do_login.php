<?php

require "config.php";
require APP_PATH."data_access/db.php";
require APP_PATH."login_helper.php";

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

//Validar una primera vez que nos pasen los datos, dentro de login_helper
//  se vuelven a validar
if (!$username || !$password){
    header("Location: ". APP_ROOT . "login.html");
    exit();
}

$usuario = autentificar($username, $password);

//Da información de lo que se está asignando a la variable
//var_dump($usuario); Una forma de "hacer debug"

if (!$usuario){
    header("Location: " . APP_ROOT . "login.html");
    exit();
}

//Empieza, o reanuda, la sesión
session_start();
//Establecer datos del usuario en sesión
$_SESSION['Usuario_Id'] = $usuario['id'];
$_SESSION['Usuario_Username'] = $usuario['username'];
$_SESSION['Usuario_Nombre'] = $usuario['nombre'];
$_SESSION['Usuario_Apellidos'] = $usuario['apellidos'];
$_SESSION['Usuario_EsAdmin'] = $usuario['es_admin'];

header("Location: " . APP_ROOT);

