<?php

$sizeBytes = 32;
$bytesRandom = random_bytes($sizeBytes);
$salt = strtoupper(bin2hex($bytesRandom));
echo "SALT: $salt <br>";

$password = "admin";
$passwordMasSalt = $password . $salt;
$passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

echo "PASSWORD ENCRYPTED: $passwordEncrypted <br>";