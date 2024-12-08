<?php
    require "../config.php";
    require APP_PATH . "data_access/db.php";
    require_once APP_PATH . "session.php";
    header("Content-Type: application/json");

    $busqueda = filter_input(INPUT_POST, "busqueda");
    $busqueda = '%'.strtolower($busqueda).'%';

    $sqlCmd = "SELECT id, username, nombre, apellidos FROM usuarios 
            WHERE (LOWER(CONCAT(nombre , ' ', apellidos)) LIKE ? OR LOWER(username) LIKE ?) AND id != ?";

    $db = getDbConnection();  // obtenemos la conexión (PDO object)
    $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar
    $sqlParams = [$busqueda, $busqueda, $USUARIO_ID];  // Parámetros de la consulta
    $stmt->execute($sqlParams);  // Todos los resultados del consulta

    $usuarios = $stmt->fetchAll();
    $resObj = ["usuarios" => $usuarios];
    echo json_encode($resObj);
