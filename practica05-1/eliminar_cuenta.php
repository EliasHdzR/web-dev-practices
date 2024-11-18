<?php
    require "config.php";
    require APP_PATH . "data_access/db.php";
    header("Content-Type: application/json");

    $id = filter_input(INPUT_POST, "id");
    $sqlCmd = "DELETE FROM usuarios WHERE id = ?";

    $db = getDbConnection();  // obtenemos la conexión (PDO object)
    $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar
    $sqlParams = [$id];  // Parámetros de la consulta
    $stmt->execute($sqlParams);  // Todos los resultados del consulta

    $resObj = ["titulo" => "Usuario Eliminado", "estado" => "success", "mensaje" => "Usuario eliminado con éxito"];
    echo json_encode($resObj);