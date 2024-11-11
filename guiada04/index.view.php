<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $tituloPagina; ?></title>
</head>
<body>
    <h1><?= $tituloPagina ?></h1>
    <?php require 'parte_html.php'; ?>
    <p>Ejemplo de generacion de HTML dinámico usando PHP</p>
    <ul>
        <?php
            for ($i = 0; $i < 10; $i++) {
                echo "<li>Hola Mundo $i</li>";
            }
        ?>
    </ul>
    <p>Otra lista generada por PHP</p>
    <ul>
        <?php for ($i = 0; $i < 15; $i++): ?>
            <li>Hola Mundo <?= $i ?></li>
        <?php endfor ?>
    </ul>

    <h3>Lista de Personas</h3>
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Edad</th>
            <th>Deportes Practicados</th>
            <th>Ver Detalle</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($personas as $persona):?>
                <tr>
                    <td><?= $persona['nombre'] ?></td>
                    <td><?= $persona['apellidos'] ?></td>
                    <td><?= $persona['edad'] ?></td>
                    <td>
                        <ul>
                            <?php foreach ($persona['deportesPracticados'] as $deporte): ?>
                                <li><?= $deporte ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <a href="busqueda.php?q=<?= urlencode($persona['nombre'].' '.$persona['apellidos']) ?>">[VER DETALLE]</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Formularios</h3>
    <fieldset>
        <legend>Búsqueda</legend>
        <form action="https://www.google.com/search" method="GET">
            <label for="txt-q">Buscar:</label>
            <input type="text" name="q" id="txt-q" placeholder="Buscar..." required>
            <input type="submit" value="Buscar">
        </form>
    </fieldset>

    <fieldset>
        <legend>Login</legend>
        <form action="do_login.php" METHOD="POST">
            <table>
                <tr>
                    <td><label for="txt-username">Username</label></td>
                    <td><input type="text" name="username" id="txt-username" required></td>
                </tr>
                <tr>
                    <td><label for="txt-password">Password</label></td>
                    <td><input type="password" name="password" id="txt-password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="ENTER"></td>
                </tr>
            </table>
        </form>
    </fieldset>

    <fieldset>
        <legend>AJAX</legend>
        <p>Fecha hora del server: <strong id="s-fecha"></strong></p>
        <button id="btn-get-fecha-hora">Actualizar Fecha Hora</button>
    </fieldset>
    <script src="index.js"></script>
</body>
</html>