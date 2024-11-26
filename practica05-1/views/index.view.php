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
                <h3>Listado de Archivos</h3>
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
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
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
                        foreach ($archivos as $archivo) {
                            echo "<tr class='tr-datos'>";
                            echo "<td><a href='' id=btn-view-" . $archivo["id"] . ">" . $archivo["nombre_archivo"] . "</a></td>";
                            echo "<td>" . $archivo["descripcion"] . "</td>";
                            echo "<td>" . $archivo["fecha_subido"] . "</td>";
                            echo "<td>" . $archivo["tamaño"] . "</td>";
                            echo "<td>" . $archivo["cant_descargas"] . "</td>";

                            echo "<td>";
                            if ($archivo["es_publico"] == 1) {
                                echo "Público";
                            } else {
                                echo "Privado";
                            }

                            echo "</td>";
                            echo "<td class='td-botones'>";
                            if($archivo["usuario_subio_id"] === $USUARIO_ID){
                                if ($archivo["es_publico"] == 1) {
                                    echo "<button class='btn-privar' id=btn-privar-" . $archivo["id"] . ">Hacer Privado</button>";
                                } else {
                                    echo "<button class='btn-publicar' id=btn-publicar-" . $archivo["id"] . ">Hacer Público</button>";
                                }

                                echo "<button id=btn-delete-" . $archivo["id"] . ">Eliminar Archivo</button>";
                            }
                            echo "</td></tr>";
                        }
                    ?>
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
