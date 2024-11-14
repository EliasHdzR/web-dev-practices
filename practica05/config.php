<?php
//Buena práctica tener configuraciones generales en un archivo config

// Root de la aplicación a partir de http://localhost/
    define("APP_ROOT", "/practicas/practica05/");

// Ruta física de la aplicación
    define("APP_PATH", "/var/www/html/practicas/practica05/");

// Directorio donde se van a subir los archivos
    define("DIR_UPLOAD", "/var/www/html/practicas/practica05/uploads/");

    define("DB_DSN", "mysql:host=127.0.0.1;port=3306;dbname=file_manager_system;charset=utf8mb4");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "root");

/**
 * ODBC es un estandar de drivers para que cualquier aplicación se pueda conectar
 *   A la base de datos, puede ser utilizado hazta para que nuestros archivos
 *   Excel se conecten a la base de datos
 * 
 * PDO es la forma universal para conectarse a nuestra base de datos en php, es lo
 * que utilizamos arriba.
 */