<?php

// Para importar otro archivo de código PHP
require_once "config.php";

// Diferentes tipos de variables
$tituloPagina = "Práctica 04 - Server Side Programming";  // variable string
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
</head>
<body>

    <div class="header">
        <h1>Práctica 04</h1>
        <h2>Basic Server Side Programming</h2>
    </div>
    
    <?php  require APP_PATH . "html_parts/menu.php"; ?>
      
    <div class="row">

        <div class="leftcolumn">

            <div class="card">
                <h2>Creación Dinámica de HTML con PHP</h2>
                <h5>Ciclos para recorrer arrays, <?php echo $hoy->format("d/m/Y"); ?></h5>
                <p>Ciclo FOR para recorrer un array e ir imprimiendo el resultado.</p>
                <ul>
                    <?php for ($i = 0; $i < count($array01); $i++) { ?> 
                        <li><?=$array01[$i]?></li>
                    <?php } ?>
                </ul>
                 <p>Ciclo FOREACH para recorrer todos los elementos de un array</p>
                <ul>
                <?php foreach ($array01 as $a) { ?>
                    <li><?=$a?></li>
                <?php } ?>
                </ul>
                <p>Listado desde otro archivo. Podermos mandar llamar otro archivo PHP y lo que nos de de resultado imprimirlo aquí.</p>
                <?php include APP_PATH . "html_parts/listado.php"; ?>
                <p>
                    Listado de artículos. Aquí creamos links dimámicos según el array de arrays 
                    asociativos. También aquí se envían datos mediante parámetros URL a la
                    página (ruta) articulo.php
                </p>
                <ul>
                    <?php foreach ($articulos as $a) { ?>
                        <li><a href="<?=APP_ROOT?>articulo.php?id=<?=$a["id"]?>&titulo=<?=urlencode($a["titulo"])?>"><?=$a["titulo"]?></a></li>
                    <?php } ?>
                </ul>
            </div>

        </div>  <!-- End left column -->

        <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
        <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

    </div>  <!-- End row-->

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>

</body>
</html>
