<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" />
    <title>Práctica 5</title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php require APP_PATH . "html_parts/info_usuario.php" ?>

<div class="header">
    <h1>Práctica 05</h1>
    <h2>Basic Server Side Programming</h2>
    <h4>Bienvenido <?=$USUARIO_NOMBRE_COMPLETO?></h4>
</div>

<?php require APP_PATH . "html_parts/menu.php"; ?>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <h3>Mis Favoritos</h3>

            <table class="users-table" style="padding: 5px; margin-top: 15px;">
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Username Propietario</th>
                    <th>Nombre Propietario</th>
                    <th>Fecha Agregado</th>
                    <th>Tamaño (KB)</th>
                    <th>Acciones</th>
                </tr>
                <?php
                    foreach ($archivos as $archivo) { ?>
                        <tr class='tr-datos'>
                            <td>
                                <a href='' id=btn-view-<?= $archivo["id"] ?>>
                                    <?= $archivo["nombre_archivo"] ?>
                                </a>
                            </td>
                            <td>
                                <?= $archivo["descripcion"] ?>
                            </td>
                            <td>
                                <?= $archivo["propietario_username"] ?>
                            </td>
                            <td>
                                <?php if($archivo["propietario_id"] == $USUARIO_ID) { ?>
                                    <a href="<?= APP_ROOT ?>">
                                        <?= $archivo["propietario_nombre"] . " " . $archivo["propietario_apellidos"] ?>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= APP_ROOT ?>busqueda_files_usuarios/ver_archivos.php?usuario_id=<?=$archivo["propietario_id"]?>">
                                        <?= $archivo["propietario_nombre"] . " " . $archivo["propietario_apellidos"] ?>
                                    </a>
                                <?php } ?>
                            <td>
                                <?= $archivo["fecha_hora"] ?>
                            </td>
                            <td>
                                <?= $archivo["tamaño"] ?>
                            </td>
                            <td class='td-botones'>
                                <?php
                                    if($archivo["favorito"]){
                                        echo "<button class='btn-quitar-favorito' id=btn-quitar-favorito-" . $archivo["id"] . ">Quitar Favorito</button>";
                                    } else {
                                        echo "<button class='btn-marcar-favorito' id=btn-marcar-favorito-" . $archivo["id"] . ">Marcar Favorito</button>";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
            </table>

        </div>
    </div>

    <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
    <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

</div>  <!-- End row-->

<div class="footer">
    <h2>ITI - Programación Web</h2>
</div>
<script src="<?=APP_ROOT?>js/favoritos.js"></script>
</body>
</html>
