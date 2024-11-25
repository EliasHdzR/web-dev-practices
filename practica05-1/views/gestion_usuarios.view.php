<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?= APP_ROOT ?>css/style.css" rel="stylesheet" type="text/css"/>
    <title>Práctica 05 </title>
    <script src="<?= APP_ROOT ?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <h3>Listado de Usuarios</h3>
            <input type="text" id="input-search" placeholder="Buscar usuario..."
                   style="width: 81.22%; margin-bottom: 5px">
            <table id="users-table" class="users-table">
                <tr>
                    <th>Rol</th>
                    <th>Username</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Genero</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
                <?php
                    foreach ($usuarios as $usuario) {
                        echo "<tr>";
                            if ($usuario["es_admin"] == 1) {
                                echo "<td>Administrador</td>";
                            } else {
                                echo "<td>Usuario</td>";
                            }
                            echo "<td>" . $usuario["username"] . "</td>";
                            echo "<td>" . $usuario["nombre"] . "</td>";
                            echo "<td>" . $usuario["apellidos"] . "</td>";
                            echo "<td>" . $usuario["genero"] . "</td>";
                            echo "<td>" . $usuario["fecha_nacimiento"] . "</td>";
                            echo "<td class='td-botones'>";
                            if ($usuario["es_admin"] == 0) {
                                echo "<button id=btn-upgrade-" . $usuario["id"] . ">Convertir a Administrador</button>";
                            }
                            echo "<button id=btn-reset-" . $usuario["id"] . ">Resetear Password</button>";
                            echo "<button id=btn-delete-" . $usuario["id"] . ">Eliminar Usuario</button>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </div>  <!-- End left column -->
    <?php require APP_PATH . "html_parts/page_right_column.php"; ?>
</div>  <!-- End row-->

<div class="footer">
    <h2>ITI - Programación Web</h2>
</div>

<script src="<?= APP_ROOT ?>js/gestion_usuarios.js"></script>
</body>
</html>

