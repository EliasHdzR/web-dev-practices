<?php
    function encrypt_password($password){
        $tamanioBytes = 32;
        $bytesRandom = random_bytes($tamanioBytes);
        $salt = strtoupper(bin2hex($bytesRandom));

        $passwordMasSalt = $password . $salt;
        $passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

        return [$passwordEncrypted, $passwordMasSalt];
    }
