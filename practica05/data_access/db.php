<?php
/* PDO Objeto conexión, viene por default en todas las instancias de php
En programación se llama Factory function, un objeto que después se usará,
   Lo creamos y usamos después. */

/* La creación de la conexión se centraliza aquí, por lo que no tendremos que 
estar constantemente llamando con todo el código
 */
function getDbConnection() {
    $options = [
        //Preferencias preparadas, cierta forma de hacer instrucciones
        PDO::ATTR_EMULATE_PREPARES => false,
        //Si hay un error se detendrá la ejecución
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //Por default las consultas regresarán un array de arrays asociativos
        // referentes a las consultas que hacemos
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD,$options);
}