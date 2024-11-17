<div style="text-align: right;">
    <span>Bienvenido(a) </span>
    <strong><?= $USUARIO_AUTENTICADO ? $USUARIO_NOMBRE_COMPLETO : "USUARIO" ?></strong>
    <span>|</span>
    <?php if ($USUARIO_AUTENTICADO): ?>
        <span><a href="<?=APP_ROOT?>actualizar_cuenta.php">Actualizar Información</a></span>
        <span>|</span>
        <span><a href="<?=APP_ROOT?>logout.php">Cerrar Sesion</a></span>
    <?php else: ?>
        <span>Inicie Sesión</span>
    <?php endif; ?>
</div>
