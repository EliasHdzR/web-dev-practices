<?php
    require "../config.php";
    require APP_PATH . "data_access/db.php";
    require APP_PATH . "sesion_requerida.php";
    header("Content-Type: application/json");

    $id = filter_input(INPUT_POST, "id");
    $sqlCmd = "UPDATE archivos SET es_publico = 1 WHERE id = ?";

    $db = getDbConnection();  // obtenemos la conexión (PDO object)
    $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar
    $sqlParams = [$id];  // Parámetros de la consulta
    $stmt->execute($sqlParams);  // Ejecutar la consulta

    $sqlCmd = "INSERT INTO archivos_log_general (archivo_id,usuario_id,fecha_hora,accion_realizada,ip_realiza_operacion) 
                    VALUES (?,?,now(),'publicado','')";

    $stmt = $db->prepare($sqlCmd);
    $sqlParams = [$id,$USUARIO_ID];
    $stmt->execute($sqlParams);

    $resObj = ["titulo" => "Archivo Publicado", "estado" => "success", "mensaje" => "El archivo ha sido publicado correctamente"];
    echo json_encode($resObj);
