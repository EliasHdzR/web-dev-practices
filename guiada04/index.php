<?php
  $tituloPagina = "Guiada 04: Introducción a la programación del Lado del Servidor";
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $tituloPagina; ?></title>
</head>
<body>
    <h1><?=$tituloPagina?></h1>
    <p>Ejemplo de generacion de HTML dinámico usando PHP</p>
    <ul>
        <?php
            for($i = 0; $i < 10; $i++){
                echo "<li>Hola Mundo $i</li>";
            }
        ?>
    </ul>
    <p>Otra lista generada por PHP</p>
    <ul>
        <?php for($i = 0; $i < 15; $i++): ?>
             <li>Hola Mundo <?=$i?></li>
        <?php endfor ?>
    </ul>
</body>
</html>
