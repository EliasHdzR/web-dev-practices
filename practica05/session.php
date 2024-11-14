<?php

session_start();

//Variables globlales para cargar datos
$USUARIO_AUTENTICADO = false;
$USUARIO_ID = NULL;
$USUARIO_USERNAME = NULL;
$USUARIO_NOMBRE = NULL;
$USUARIO_APELLIDOS = NULL;
$USUARIO_NOMBRE_COMPLETO = NULL;
$USUARIO_ESADMIN = NULL;

if(isset($_SESSION["Usuario_Id"])){
    $USUARIO_AUTENTICADO = true;
    $USUARIO_ID = $_SESSION["Usuario_Id"];
    $USUARIO_USERNAME = $_SESSION["Usuario_Username"];
    $USUARIO_NOMBRE = $_SESSION["Usuario_Nombre"];
    $USUARIO_APELLIDOS = $_SESSION["Usuario_Apellidos"];
    
    $USUARIO_NOMBRE_COMPLETO = $USUARIO_NOMBRE;
    if ($USUARIO_APELLIDOS) {
        $USUARIO_NOMBRE_COMPLETO =
            $USUARIO_NOMBRE_COMPLETO . " " .
            $USUARIO_APELLIDOS;
    }

    $USUARIO_ESADMIN = $_SESSION["Usuario_EsAdmin"];
    
}
