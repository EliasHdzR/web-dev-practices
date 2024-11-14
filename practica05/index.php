<?php

// Para importar otro archivo de código PHP
    require_once "config.php";
    require APP_PATH . "sesion_requerida.php";

// Diferentes tipos de variables
    $tituloPagina = "Práctica 05 - Server Side Programming";  // variable string
    $hoy = new DateTime("now");  // variable DateTime (object)
    $numeroEnter = 100;  // variable int
    $numeroDecimal = 3.14159;  // variable float
    $valorBooleano = true;  // variable boolean

// Array de elementos string
    $array01 = ["Valor 1", "Valor 2", "Valor 3"];  // con valores iniciales
    $array01[] = "Valor 4";  // agregar al array un elemento al final
    $array01[] = "Valor 5";  // se agrega al array otro elemento al final

// Array de arrays asociativos
    $articulos = [
        ["titulo" => "Artículo 001", "id" => 1],  // array assoc
        ["titulo" => "Artículo 002", "id" => 2],  // array assoc
        ["titulo" => "Artículo 003", "id" => 3]   // array assoc
    ];

    $cantidadVisitas = 1;
    $expira = time() + (86400 * 30);
    if(isset($_COOKIE["cantidadVisitas"])) {
        $cantidadVisitas = (int)$_COOKIE["cantidadVisitas"];
        $cantidadVisitas++;
    }

    setcookie("cantidadVisitas", (string)$cantidadVisitas, $expira);


    require APP_PATH . "views/index.view.php";