<?php
//obtener cierta cantidad de bytes random
$tamanioBytes = 32;
//Se generan bytes random
$bytesRandom = random_bytes($tamanioBytes);
//Sacar el hexadecimal para obtener el salt
$salt = strtoupper(bin2hex($bytesRandom));

echo "SALT: $salt <br>";

$password = "admin";
/**
 * Concatenar password y salt, el salt puede ir al inicio o al final
 *    sin embargo, no puede ser variado, cada password deberá segir
 *    esa estructura
 */
$passwordMasSalt = $password . $salt;
$passwordEncrypted = strtoupper(hash("sha512", $passwordMasSalt));

/**
 * Algoritmos hash o check-sum(? trabajan a nivel de bytes, regresan un binario,
 *    en este caso hexadecimal, dicho resultado siempre será del mismo tamaño
 *    para validar la integridad de un archivo a dicho archivo se verifica el
 *    sha1, sha256. Es decir el resumen del archivo
 * 
 * Los algoritmos hash son de una sola via, equivalente a algoritmos de una sola vía
 *    se pueden cifrar, pero no es posible hacer la operación inversa. A nosotros
 *    no nos interesa el password en texto plano de los usuarios, por seguridad.
 */

echo "Password Encrypted: $passwordEncrypted";