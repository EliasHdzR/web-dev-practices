<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?= APP_ROOT ?>css/style.css" rel="stylesheet" type="text/css"/>
    <title>Práctica 05</title>
    <script src="<?= APP_ROOT ?>js/config.js"></script>
</head>
<body>

<?php require APP_PATH . "html_parts/info_usuario.php" ?>

<div class="header">
    <h1>Práctica 05</h1>
    <h2>File Manager</h2>
</div>

<?php require APP_PATH . "html_parts/menu.php"; ?>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <h3>Buscar Usuarios</h3>
            <input type="text" id="input-search" placeholder="Buscar usuario..."
                   style="width: 50%; margin-bottom: 5px">
            <button id="btn-search">Buscar</button>

            <table id="users-table" class="users-table" hidden>
                <tr>
                    <th>Username</th>
                    <th>Nombre Completo</th>
                    <th>Acciones</th>
                </tr>
            </table>
        </div>
    </div>  <!-- End left column -->
    <?php require APP_PATH . "html_parts/page_right_column.php"; ?>
</div>  <!-- End row-->

<div class="footer">
    <h2>ITI - Programación Web</h2>
</div>

<script src="<?= APP_ROOT ?>js/lista_usuarios.js"></script>
</body>
</html>

