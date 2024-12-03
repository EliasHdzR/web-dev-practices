<?php
    $game = filter_input(INPUT_GET, "game");
    if(!$game) {
        echo "Es necesario el parámetro url [game]";
        exit;
    }

    $gameEncoded = urlencode($game);
    $urlGetScores = "http://primosoft.com.mx/games/api/getscores.php?game=$gameEncoded&orderAsc=1"; //url del endpoint al que vamos a llamar

    $ch = curl_init(); // init de la peticion HTTP
    curl_setopt_array($ch, [ // establecemos las opciones de la peticion
        CURLOPT_URL => $urlGetScores, // la url a la que vamos a llamar
        CURLOPT_RETURNTRANSFER => true, // para que nos regrese el resultado de la peticion
        CURLOPT_FOLLOWLOCATION => true, // para que siga las redirecciones
        CURLOPT_TIMEOUT => 30, // tiempo de espera en segundos
    ]);

    $resposeContent = curl_exec($ch);
    curl_close($ch);

    $scores = json_decode($resposeContent, true);

    require 'views/scores.view.php';