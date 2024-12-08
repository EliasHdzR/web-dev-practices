<?php
    require "../config.php";
    require APP_PATH . "data_access/db.php";
    require APP_PATH . "sesion_requerida.php";
    header("Content-Type: application/json");

    $id = filter_input(INPUT_POST, "id");

    $sqlCmd = "INSERT INTO favoritos (usuario_id, archivo_id, fecha_hora) VALUES (?,?, now())";
    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID, $id];
    $stmt->execute($sqlParams);

    $resObj = ["titulo" => "Marcado como Favorito", "estado" => "success", "mensaje" => "El archivo ha sido marcado como favorito correctamente"];
    echo json_encode($resObj);
