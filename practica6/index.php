<?php
    $urlGetGames = "http://primosoft.com.mx/games/api/getgames.php"; //url del endpoint al que vamos a llamar

    $ch = curl_init(); // init de la peticion HTTP
    curl_setopt_array($ch, [ // establecemos las opciones de la peticion
        CURLOPT_URL => $urlGetGames, // la url a la que vamos a llamar
        CURLOPT_RETURNTRANSFER => true, // para que nos regrese el resultado de la peticion
        CURLOPT_FOLLOWLOCATION => true, // para que siga las redirecciones
        CURLOPT_TIMEOUT => 30, // tiempo de espera en segundos
    ]);

    $responseContent = curl_exec($ch);
    curl_close($ch);
    $games = json_decode($responseContent, true);

    include "views/index.view.php";