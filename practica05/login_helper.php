<?php

function autentificar($username, $password) {
    if(!$username || !$password){
        return false;
    }

    $sqlCmd = "SELECT id, username, password_encrypted, password_salt, nombre, apellidos, es_admin, activo 
                FROM usuarios WHERE username = ? ORDER BY id DESC";

    $db = getDBConnection(); // obtenemos la conexion (PDO Object)
    $stmt = $db->prepare($sqlCmd); // Statement a ejecutar
    $sqlParams = [$username]; // Parámetros de la consulta (son los '?')
    $stmt->execute($sqlParams); // Ejecutamos con los parámetros
    $queryResult = $stmt->fetchAll(); // Recuperamos todos los dato de la consulta

    if(!$queryResult){
        return false;
    }

    $usuario = $queryResult[0];
    if(!$usuario["activo"]){
        return false;
    }

    // Obtenemos el password cifrado del password que obtuvimos en la funcion (está en texto plano)
    $passwordMasSalt = $password . $usuario["password_salt"];
    $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

    if($usuario["password_encrypted"] != $passwordEncrypted){
        return false;
    }

    return [
        "id" => $usuario["id"],
        "username" => $usuario["usernae"],
        "nombre" => $usuario["nombre"],
        "apellidos" => $usuario["apelldos"],
        "esAdmin" => $usuario["esAdmin"],
    ];
} 