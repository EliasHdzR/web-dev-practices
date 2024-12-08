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

    $sqlCmd = "SELECT archivos.id, favoritos.archivo_id AS favorito, nombre_archivo, descripcion, fecha_subido, tamaño, cant_descargas, es_publico
                FROM archivos LEFT JOIN favoritos ON archivos.id = favoritos.archivo_id AND favoritos.usuario_id = ?
                WHERE fecha_borrado IS NULL
                    AND usuario_subio_id = ?
                    AND MONTH(fecha_subido) = ? 
                    AND YEAR(fecha_subido) = ?
                ORDER BY archivos.fecha_subido DESC";

    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [ $USUARIO_ID, $USUARIO_ID, date("m"), date("Y")];
    $stmt->execute($sqlParams);

    $archivos = $stmt->fetchAll();

// Se regresa el view  del index  :)
    require APP_PATH . "views/index.view.php";
