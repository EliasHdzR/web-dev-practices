<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Práctica 06: Juegos</title>
</head>
<body>
<h1><?= $game ?></h1>
<h2>Lista de Puntajes</h2>
<table class="tabla-puntuaciones">
    <tr>
        <th>Posición</th>
        <th>Jugador</th>
        <th>Puntuación</th>
        <th>Fecha</th>
    </tr>
    <?php
        $posicion = 1;
        foreach ($scores as $score):?>
    <tr>
        <td><?= $posicion++ ?></td>
        <td><?= $score["player"] ?></td>
        <td><?= $score["score"] ?></td>
        <td><?= $score["date"] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
