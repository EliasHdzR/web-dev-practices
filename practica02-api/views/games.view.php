<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Práctica 06: Juegos</title>
</head>
<body>
<h1>Práctica 06: Juegos</h1>
<h2>Lista de juegos</h2>
<div>
    <ul id="games-list" style="color: white">
        <?php foreach ($games as $game): ?>
            <li id="<?= $game ?>">
                <strong><?= $game ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="js/games.js"></script>
</body>
</html>
