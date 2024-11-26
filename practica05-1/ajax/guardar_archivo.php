<?php

    // Para obtener el archivo con las configuraciones de la app
    require "../config.php";
    require APP_PATH . "session.php";
    require APP_PATH . "data_access/db.php";

    // La respuesta va a ser un JSON
    header("Content-Type: application/json");

    $resObj = ["error" => NULL, "mensaje" => NULL];

    // Validación de que se envió el archivo
    if (empty($_FILES) || !isset($_FILES["archivo"])) {
        $resObj["error"] = "Archivo no especificado";
        echo json_encode($resObj);
        exit();  // finalizamos la ejecución de este archivo PHP
    }

    $CONTENT_TYPES_EXT = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "png" => "image/png",
        "json" => "application/json",
        "pdf" => "application/pdf",
    ];

    $extension = filter_input(INPUT_POST, "extension");
    if(!$CONTENT_TYPES_EXT[$extension]) {
        $resObj["error"] = "El archivo no es una imagen o un PDF";
        return;
    }

    // Obtención de los datos del archivo subido
    $archivo = $_FILES["archivo"];  // Assoc array con los datos del archivo subido
    $tamanio = $archivo["size"];  // tamaño del archivo en bytes
    $nombreArchivo = $archivo["name"];  // nombre original del archivo subido
    $nombreArchivoGuardado = ((new DateTime())->format('Uv')).'_'.$nombreArchivo;
    $extension = explode("/", $archivo['type'])[1];
    $rutaTemporal = $archivo["tmp_name"];  // Obtención de la ruta temporal del archivo
    $descripcion = filter_input(INPUT_POST, "descripcion");

    // Se determina la ruta donde se guardará el archivo subido
    $rutaAGuardar = DIR_UPLOAD . $nombreArchivoGuardado;

    // Guardamos el archivo del directorio temporal a la ruta final
    $seGuardoArchivo = move_uploaded_file($rutaTemporal, $rutaAGuardar);
    if (!$seGuardoArchivo) {  // No se guardo?
        $resObj["error"] = "No se pudo guardar el archivo :(";
        echo json_encode($resObj);
        exit();
    }

    try {
        // consulta preparada
        $sqlCmd = "INSERT INTO archivos (descripcion,nombre_archivo,extension,nombre_archivo_guardado,tamaño,fecha_subido,
                usuario_subio_id,cant_descargas,es_publico,hash_sha256) VALUES (?,?,?,?,?,now(),?,0,0,0)";

        $db = getDbConnection();
        $stmt = $db->prepare($sqlCmd);
        $sqlParams = [$descripcion,$nombreArchivo,$extension,$nombreArchivoGuardado,$tamanio,$USUARIO_ID];
        $stmt->execute($sqlParams);

        $lastInsertId = $db->lastInsertId();
        $sqlCmd = "INSERT INTO archivos_log_general (archivo_id,usuario_id,fecha_hora,accion_realizada,ip_realiza_operacion) 
                    VALUES (?,?,now(),'subido','')";

        $stmt = $db->prepare($sqlCmd);
        $sqlParams = [$lastInsertId,$USUARIO_ID];
        $stmt->execute($sqlParams);
    } catch (exception $e) {
        $resObj["error"] = "No se pudo guardar el archivo :(";
        echo json_encode($resObj);
        return;
    }

    // establecemos el mensaje de respuesta
    $resObj["mensaje"] = "Archivo guardado correctamente.";

    // Regresamos el JSON de la respuesta
    echo json_encode($resObj);
