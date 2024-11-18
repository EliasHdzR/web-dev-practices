<?php
    require "config.php";
    require APP_PATH . "data_access/db.php";
    header("Content-Type: application/json");

    $id = filter_input(INPUT_POST, "id");

    $sqlCmd = "UPDATE usuarios SET password_encrypted = ?, password_salt = ? WHERE id = ?";

    $db = getDbConnection();  // obtenemos la conexión (PDO object)
    $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar

    $defaultPassword = encrypt_password("password");
    $sqlParams = [$defaultPassword[0], $defaultPassword[1], $id];  // Parámetros de la consulta
    $stmt->execute($sqlParams);  // Todos los resultados del consulta

    $resObj = ["titulo" => "Password Reestablecido", "estado" => "success", "mensaje" => "Nuevo password: 'password'"];
    echo json_encode($resObj);

    function encrypt_password($password){
        $tamanioBytes = 32;
        $bytesRandom = random_bytes($tamanioBytes);
        $salt = strtoupper(bin2hex($bytesRandom));

        $passwordMasSalt = $password . $salt;
        $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

        return [$passwordEncrypted, $salt];
    }