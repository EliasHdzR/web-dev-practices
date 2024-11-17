<?php

// Iniciar la sesión o recuperar una sesión existente
session_start();

// Aquí estarán los datos generales del usuario que obtendremos de la sesión
$USUARIO_AUTENTICADO = isset($_SESSION["Usuario_Id"]);  // autenticado si está en las variables de sesión el id del usuario
$USUARIO_ID = NULL;
$USUARIO_NOMBRE = NULL;
$USUARIO_APELLIDOS = NULL;
$USUARIO_NOMBRE_COMPLETO = NULL;
$USUARIO_FECHA_NACIMIENTO = NULL;
$USUARIO_ES_ADMIN = false;

//
if ($USUARIO_AUTENTICADO) {
    $USUARIO_ID = $_SESSION["Usuario_Id"];
    $USUARIO_NOMBRE = $_SESSION["Usuario_Nombre"];
    $USUARIO_APELLIDOS = $_SESSION["Usuario_Apellidos"];
    $USUARIO_NOMBRE_COMPLETO = $USUARIO_NOMBRE;
    if ($USUARIO_APELLIDOS) {
        $USUARIO_NOMBRE_COMPLETO = 
                $USUARIO_NOMBRE_COMPLETO . " " . 
                $USUARIO_APELLIDOS;
    }
    $USUARIO_GENERO = $_SESSION["Usuario_Genero"];
    $USUARIO_FECHA_NACIMIENTO = $_SESSION["Usuario_Fecha_Nacimiento"];
    $USUARIO_ES_ADMIN = $_SESSION["Usuario_EsAdmin"] != 0;  // para convertirlo a bool
}
