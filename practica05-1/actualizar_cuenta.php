<?php
    require "config.php";
    require_once APP_PATH . "session.php";

    if(!$USUARIO_AUTENTICADO){
        header("Location: login.php");
    }

    require APP_PATH . "views/actualizar_cuenta.view.php";