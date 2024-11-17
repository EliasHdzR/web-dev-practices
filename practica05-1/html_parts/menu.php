<?php require_once APP_PATH . "session.php"; ?>

<div class="topnav">
    <?php if ($USUARIO_AUTENTICADO): ?>
        <a href="<?=APP_ROOT?>">Home</a>
        <a href="<?=APP_ROOT?>enviar_datos_con_form.php">Enviar Datos<br />con form</a>
        <a href="<?=APP_ROOT?>enviar_datos_con_ajax.php">Enviar Datos<br /> con AJAX</a>
        <a href="#" style="float:right">Link</a>
    <?php else: ?>
        <a href="<?=$APP_ROOT . "login.php"?>">Login</a>
        <a href="<?=$APP_ROOT . "registro.php"?>">Registro</a>
    <?php endif; ?>

</div>
