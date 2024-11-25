<?php
    require APP_PATH . "data_access/db.php";
    /**
     * Valida que un username sea único
     */
    function validar($username)
    {
        $sqlCmd = "SELECT username FROM usuarios WHERE username = ?";

        $db = getDbConnection();  // obtenemos la conexión (PDO object)
        $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar
        $sqlParams = [$username];  // Parámetros de la consulta
        $stmt->execute($sqlParams);  // Ejecutamos con los parámetros
        $queryResult = $stmt->fetch();  // Todos los resultados del consulta

        // Si la consulta regresó resultados return false
        if ($queryResult) {
            return false;
        }

        return true;
    }

    function registrar($usuario){
        $encrypted_data = encrypt_password($usuario["password"]);
        $sqlParams = [$usuario["username"], $encrypted_data[0], $encrypted_data[1], $usuario["name"], $usuario["lastname"], $usuario["gender"]];

        if($usuario["birthdate"]){
            $sqlCmd = "INSERT INTO usuarios (username, password_encrypted, password_salt, nombre, apellidos, genero, fecha_nacimiento, fecha_hora_registro, es_admin,
                    activo) VALUES (?, ?, ?, ?, ?, ?, ?, now(), 0, 1)";
            $sqlParams[] = $usuario["birthdate"];
        } else {
            $sqlCmd = "INSERT INTO usuarios (username, password_encrypted, password_salt, nombre, apellidos, genero, fecha_hora_registro, es_admin,
                    activo) VALUES (?, ?, ?, ?, ?, ?, now(), 0, 1)";
        }

        $db = getDbConnection();
        $stmt = $db->prepare($sqlCmd);
        $stmt->execute($sqlParams);
    }

    function encrypt_password($password){
        $tamanioBytes = 32;
        $bytesRandom = random_bytes($tamanioBytes);
        $salt = strtoupper(bin2hex($bytesRandom));

        $passwordMasSalt = $password . $salt;
        $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

        return [$passwordEncrypted, $salt];
    }
