<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?= APP_ROOT ?>css/style.css" rel="stylesheet" type="text/css"/>
    <title>Práctica 05 - Registro </title>
    <script src="<?= APP_ROOT ?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php require APP_PATH . "html_parts/info_usuario.php" ?>

<div class="header">
    <h2>Registro</h2>
    <h5>Registro para el File Manager</h5>
    <p>Debe crear una cuenta para poder ingresar a la aplicación</p>
</div>

<?php require APP_PATH . "html_parts/menu.php"; ?>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <form method="POST">
                <table>
                    <tr>
                        <td><label for="txt-username">Username:</label></td>
                        <td><input type="text" name="username" id="txt-username"/></td>
                        <td><label id="warning-username" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="txt-name">Nombre:</label></td>
                        <td><input type="text" name="name" id="txt-name"/></td>
                        <td><label id="warning-name" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="txt-lastname">Apellidos:</label></td>
                        <td><input type="text" name="lastname" id="txt-lastname"/></td>
                        <td><label id="warning-lastname" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="select-gender">Genero:</label></td>
                        <td><select name="select-gender" id="select-gender" style="width: 100%">
                                <option value=""></option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                <option value="X">Prefiero no especificar</option>
                            </select>
                        </td>
                        <td><label id="warning-gender" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="input-birthdate">Fecha de Nacimiento:</label></td>
                        <td><input type="date" name="input-birthdate" id="input-birthdate" style="width: 100%"></td>
                        <td><label id="warning-birthdate" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="txt-password">Password:</label></td>
                        <td><input type="password" name="password" id="txt-password"/></td>
                        <td><label id="warning-password" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td><label for="txt-confirm-password">Confirmar Password:</label></td>
                        <td><input type="password" name="confirm-password" id="txt-confirm-password"/></td>
                        <td><label id="warning-conf-password" style="color: darkred"></label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" id="btn-register" value="REGISTRARSE"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php require APP_PATH . "html_parts/page_right_column.php"; ?>
</div>
<div class="footer">
    <h2>ITI - Programación Web</h2>
</div>

<script src="<?= APP_ROOT ?>js/validar_registro.js"></script>
</body>
</html>