<?php

require_once APP_PATH . "session.php";

if(!$USUARIO_AUTENTICADO){
    header("Location: " . APP_ROOT . "login.html");
    exit();
}

