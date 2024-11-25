<?php

// Para importar otro archivo de código PHP
require_once "config.php";
require APP_PATH . "sesion_requerida.php";
require APP_PATH . "data_access/db.php";

// Diferentes tipos de variables
$tituloPagina = "Práctica 05 - Server Side Programming";  // variable string

// Cookies para obtener la cantidad de visitas a la págnia.
$cantidadVisitas = 1;
$segundosEnUnDia = 86400;
$expira = time() + ($segundosEnUnDia * 30);  // tiempo en que expira, 30 día a partir de hoy
if (isset($_COOKIE["cantidadVisitas"])) {  // ya existe la cookie?
    $cantidadVisitas = (int)$_COOKIE["cantidadVisitas"];  // se obtiene el valor (que es un string)
    $cantidadVisitas++; 
}

// Para establecer la cookie (esta irá en el response)
setcookie(
    "cantidadVisitas",  // nombre de la cookie
    (string)$cantidadVisitas,  // valor de la cookie
    $expira   // cuándo exipira (fecha UNIX)
);

/*$sqlCmd = "SELECT id, es_admin, username, nombre, apellidos, genero, fecha_nacimiento 
                FROM archivos WHERE activo = 1 AND id != ? ORDER BY id ASC LIMIT 100";
    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID];
    $stmt->execute($sqlParams);

    $usuarios = $stmt->fetchAll();*/

// Se regresa el view  del index  :)
require APP_PATH . "views/index.view.php";
