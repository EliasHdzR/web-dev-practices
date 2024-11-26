<?php
    require "../config.php";
    require APP_PATH . "data_access/db.php";
    require APP_PATH . "sesion_requerida.php";
    header("Content-Type: application/json");

    $mes = filter_input(INPUT_POST, "mes");
    $anio = filter_input(INPUT_POST, "anio");
    $sqlCmd = "SELECT id, nombre_archivo, descripcion, fecha_subido, tamaño, cant_descargas, es_publico, usuario_subio_id FROM archivos 
                WHERE  fecha_borrado IS NULL AND (usuario_subio_id = ? OR es_publico = 1) AND MONTH(fecha_subido) = ? AND YEAR(fecha_subido) = ?
                ORDER BY fecha_subido DESC";
    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID, $mes, $anio];
    $stmt->execute($sqlParams);

    $archivos = $stmt->fetchAll();
    $resObj = ["archivos" => $archivos];
    echo json_encode($resObj);
