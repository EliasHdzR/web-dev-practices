<?php
    require APP_PATH . "data_access/db.php";

    function actualizar($usuario){
        $sqlParams = [$usuario["name"], $usuario["lastname"], $usuario["gender"]];

        if($usuario["birthdate"]){
            $sqlCmd = "UPDATE usuarios SET nombre = ?, apellidos = ?, genero = ?, fecha_nacimiento = ? WHERE id = ?";
            $sqlParams[] = $usuario["birthdate"];
        } else {
            $sqlCmd = "UPDATE usuarios SET nombre = ?, apellidos = ?, genero = ? WHERE id = ?";
        }

        $sqlParams[] = $usuario["id"];

        $db = getDbConnection();
        $stmt = $db->prepare($sqlCmd);
        $stmt->execute($sqlParams);
    }

    function actualizarPassword($usuario){
        $encrypted_data = encrypt_password($usuario["password"]);
        $sqlCmd = "UPDATE usuarios SET password_encrypted = ?, password_salt = ? WHERE id = ?";
        $sqlParams = [$encrypted_data[0], $encrypted_data[1], $usuario["id"]];
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

