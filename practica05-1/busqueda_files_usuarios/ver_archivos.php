<?php
    require "../config.php";
    require_once APP_PATH . "sesion_requerida.php";
    require APP_PATH . "data_access/db.php";

    $propietarioID = filter_input(INPUT_GET, "usuario_id");

    $sqlCmd = "SELECT archivos.id, favoritos.archivo_id AS favorito, nombre_archivo, descripcion, fecha_subido, tamaño, cant_descargas, es_publico
                FROM archivos LEFT JOIN favoritos ON archivos.id = favoritos.archivo_id AND favoritos.usuario_id = ?
                WHERE fecha_borrado IS NULL
                    AND usuario_subio_id = ?
                    AND MONTH(fecha_subido) = ? 
                    AND YEAR(fecha_subido) = ?
                    AND es_publico = 1
                ORDER BY archivos.fecha_subido DESC";

    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID, $propietarioID,date("m"), date("Y")];
    $stmt->execute($sqlParams);
    $archivos = $stmt->fetchAll();

    $sqlCmd = "SELECT nombre, apellidos FROM usuarios WHERE id = ?";
    $stmt = $db->prepare($sqlCmd);
    $stmt->execute([$propietarioID]);
    $usuario = $stmt->fetch();


    require APP_PATH . "views/ver_archivos.view.php";