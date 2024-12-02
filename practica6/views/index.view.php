<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Práctica 06: APIs</title>
</head>
<body>
    <h1>Práctica 06: APIs</h1>
    <h2>Lista de juegos</h2>
    <ul>
        <?php foreach ($games as $game): ?>
            <li>
                <strong><?= $game ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>

<script src="../js/index.js"></script>
</body>
</html>
