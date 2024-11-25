<?php
    require "config.php";
    require_once APP_PATH . "sesion_requerida.php";
    require APP_PATH . "data_access/db.php";

    $sqlCmd = "SELECT id, es_admin, username, nombre, apellidos, genero, fecha_nacimiento 
                FROM usuarios WHERE activo = 1 AND id != ? ORDER BY id ASC LIMIT 100";
    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID];
    $stmt->execute($sqlParams);

    $usuarios = $stmt->fetchAll();

    require APP_PATH . "views/gestion_usuarios.view.php";