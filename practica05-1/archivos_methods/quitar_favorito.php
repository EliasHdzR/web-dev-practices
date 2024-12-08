<?php
    require "../config.php";
    require APP_PATH . "data_access/db.php";
    require APP_PATH . "sesion_requerida.php";
    header("Content-Type: application/json");

    $id = filter_input(INPUT_POST, "id");

    $sqlCmd = "DELETE FROM favoritos WHERE usuario_id = ? AND archivo_id = ?";
    $db = getDbConnection();
    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$USUARIO_ID, $id];
    $stmt->execute($sqlParams);

    $resObj = ["titulo" => "Quitado de Favoritos", "estado" => "success", "mensaje" => "El archivo ha sido quitado de favoritos correctamente"];
    echo json_encode($resObj);