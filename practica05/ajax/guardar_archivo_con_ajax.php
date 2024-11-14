<?php

// Para obtener el archivo con las configuraciones de la app
require "config.php";

header("Content-Type: application/json");
$resObj = ["error" => NULL, "mensaje" => NULL];

// Validación de que se envió el archivo
//Mismo nombre que el que se encuentra en el name de su casilla correspondiente en el forms
if (empty($_FILES) || !isset($_FILES["archivo"])) {
    // Si no se envió el archivo, redirect al App Root (Home)
    $resObj["error"] = "Archivo no especificado";
    echo json_encode($resObj);
    exit();  // finalizamos la ejecución de este archivo PHP
}

// Obtención de los datos del archivo subido
$archivo = $_FILES["archivo"];  // Assoc array con los datos del archivo subido
$tamaño = $archivo["size"];  // tamaño del archivo en bytes
$nombreArchivo = $archivo["name"];  // nombre original del archivo subido
$rutaTemporal = $archivo["tmp_name"];  // Obtención de la ruta temporal del archivo

// Se determina la ruta donde se guardará el archivo subido
$rutaAGuardar = DIR_UPLOAD . $nombreArchivo;

// Guardamos el archivo del directorio temporal a la ruta final
$seGuardoArchivo = move_uploaded_file($rutaTemporal, $rutaAGuardar); 
if (!$seGuardoArchivo) {  // No se guardo?
    $resObj["error"] = "No se pudo guardar el archivo :(";
    echo json_encode($resObj);
    exit();
}

// Además de archivos, podermos recibir más datos
$otroDato = filter_input(INPUT_POST, "otroDato");

$resObj["mensaje"] = "Archivo guardado correctamente";
echo json_encode($resObj);
