<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Práctica 05</h1>
        <h2>Basic Server Side Programming</h2>
        <h4>Bienvenido <?=$USUARIO_NOMBRE_COMPLETO?></h4>
        <h5>Cantidad Visitas: <?=$cantidadVisitas?></h5>
    </div>
      
    <?php require APP_PATH . "html_parts/menu.php"; ?>

    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <h3>Mis Archivos</h3>
                <a href="<?= APP_ROOT ?>subir_archivo.php">Subir Archivo</a><br><br>

                <select id="select-meses">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                <select id="select-anios">
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                </select>
                <button id="btn-filtrar">Filtrar</button>

                <table class="users-table" style="padding: 5px; margin-top: 15px;">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Fecha de Subida</th>
                        <th>Tamaño (KB)</th>
                        <th>Cant. Descargas</th>
                        <th>Visibilidad</th>
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
                                    <?= $archivo["fecha_subido"] ?>
                                </td>
                                <td>
                                    <?= $archivo["tamaño"] ?>
                                </td>
                                <td>
                                    <?= $archivo["cant_descargas"] ?>
                                </td>
                                <td>
                                    <?php if ($archivo["es_publico"] == 1) {
                                        echo "Público";
                                    } else {
                                        echo "Privado";
                                    } ?>
                                </td>
                                <td class='td-botones'>
                                    <?php
                                        if ($archivo["es_publico"] == 1) {
                                            echo "<button class='btn-privar' id=btn-privar-" . $archivo["id"] . ">Hacer Privado</button>";
                                        } else {
                                            echo "<button class='btn-publicar' id=btn-publicar-" . $archivo["id"] . ">Hacer Público</button>";
                                        }

                                        if($archivo["favorito"]){
                                            echo "<button class='btn-quitar-favorito' id=btn-quitar-favorito-" . $archivo["id"] . ">Quitar Favorito</button>";
                                        } else {
                                            echo "<button class='btn-marcar-favorito' id=btn-marcar-favorito-" . $archivo["id"] . ">Marcar Favorito</button>";
                                        }

                                        echo "<button id=btn-delete-" . $archivo["id"] . ">Eliminar Archivo</button>";
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

    <script src="<?= APP_ROOT ?>js/index_archivos.js"></script>
</body>
</html>
