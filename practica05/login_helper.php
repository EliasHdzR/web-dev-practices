<?php

function autentificar($username, $password){
    //Si no envian username o password retorna falso
    if (!$username || !$password) {
        return false;
    }

    /**
     * Sentencia SQL, donde username se enviará como parámetro
     * Usamos el signo de interrogación (?) como placeholder
     *     para indicar que ahí irá un parámetro
     * 
     * No se pone directamente la variable $username por seguridad
     *     es una abertura para inyectar código sql, lo que vulnera
     *     la seguridad.
     */
    $sqlCmd =
        "SELECT id, username, password_encrypted, password_salt," .
        "   nombre, apellidos, es_admin, activo" .
        "   FROM usuarios WHERE username = ? ORDER BY id DESC";

    //Obtenemos la conexión (PDO Object)
    $db = getDbConnection();
    //Crear un statement a ejecutar dentro de la base de datos
    $stmt = $db->prepare($sqlCmd);
    //Parámetros a utilizar en la consulta, se sustituyen según el orden puesto
    $sqlParams = [$username];
    //Ejecurar con los parámetros específicos
    $stmt->execute($sqlParams);

    //Obtener el resultado de la consulta (Array de arrays asociativos de la consulta)
    $queryResult = $stmt->fetchAll();

    //Si la consulta no retorna resultados retorna falso //Usuario no autenticado
    if (!$queryResult) {
        return false;
    }

    $usuario = $queryResult[0]; //Obtener el primer registro

    if (!$usuario["activo"]) { //Caso de que no exista el usuario
        return false;
    }

    /**
     * Obtener password cifrado del password que se pasó en la consulta
     *    de la función ( pasado en texto plano)  
     * Para más seguridad es posible añadir varias iteraciones de sha512
     *    es decir, cifrarlo varias veces, aunque es un proceso tardado,
     *    en cuestión de milisegundos, por ejemplo si se tuvieran 1000
     *    iteraciones, suponiendo que por cada una tarda 1 milisegundo;
     *    el computador estaría ocupado por 1 segundo haciendo esta
     *    actividad.
    */
    $passwordMasSalt = $password . $usuario["password_salt"];
    $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

    //En caso de que las contraseñas no coincidan
    if($usuario["password_encrypted"] != $passwordEncrypted){
        return false;
    }

    //Pasó todas las validaciones, se identificó correctamente
    //Retorna array asociativo con los datos del usuario
    return[
        "id" => $usuario["id"],
        "username" => $usuario["username"],
        "nombre" => $usuario["nombre"],
        "apellidos" => $usuario["apellidos"],
        "es_admin" => $usuario["es_admin"]
    ];
}