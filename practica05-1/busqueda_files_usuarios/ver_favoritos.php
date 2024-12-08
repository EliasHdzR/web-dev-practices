<?php
    require_once "../config.php";
    require APP_PATH . "sesion_requerida.php";
    require APP_PATH . "data_access/db.php";

    $sqlCmd = "SELECT archivos.id, favoritos.archivo_id AS favorito, nombre_archivo, descripcion, fecha_hora, tamaño,
                  propietario.id AS propietario_id,
                  propietario.username AS propietario_username, propietario.nombre AS propietario_nombre,
                  propietario.apellidos AS propietario_apellidos
               FROM favoritos
               JOIN archivos ON archivos.id = favoritos.archivo_id
               JOIN usuarios ON favoritos.usuario_id = usuarios.id
               JOIN usuarios AS propietario ON archivos.usuario_subio_id = propietario.id
               WHERE fecha_borrado IS NULL
                 AND favoritos.usuario_id = ?
                 AND (usuario_subio_id = ? OR es_publico = 1)
               ORDER BY fecha_hora DESC";

    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [ $USUARIO_ID, $USUARIO_ID];
    $stmt->execute($sqlParams);

    $archivos = $stmt->fetchAll();

    require APP_PATH . "views/ver_favoritos.view.php";