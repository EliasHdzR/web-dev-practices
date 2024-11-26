<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?= APP_ROOT ?>css/style.css" rel="stylesheet" type="text/css"/>
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?= APP_ROOT ?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php require APP_PATH . "html_parts/info_usuario.php" ?>

<div class="header">
    <h1>Práctica 05</h1>
    <h2>Basic Server Side Programming</h2>
    <h4>Bienvenido <?= $USUARIO_NOMBRE_COMPLETO ?></h4>
    <h5>Cantidad Visitas: <?= $cantidadVisitas ?></h5>
</div>

<?php require APP_PATH . "html_parts/menu.php"; ?>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <h3>Subir Archivos</h3>
            <table style="padding: 5px; margin: 5px">
                <tr>
                    <td>Archivo</td>
                    <td><input type="file" id="input-file"></td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td><input type="text" id="input-descripcion" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>
                        <button id="btn-subir-archivo">Subir Archivo</button>
                    </td>
                    <td><label id="label-error-archivo" style="color: darkred"></label></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
    <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

</div>  <!-- End row-->

<div class="footer">
    <h2>ITI - Programación Web</h2>
</div>
<script src="<?= APP_ROOT ?>js/subida_archivo.js"></script>
</body>
</html>
