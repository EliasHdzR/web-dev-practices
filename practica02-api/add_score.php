<?php
    header("Content-Type: application/json");

    $milisegundos = filter_input(INPUT_POST, "milisegundos");
    $nombre = filter_input(INPUT_POST, "nombre");
    $urlAddScore = "http://primosoft.com.mx/games/api/addscore.php";

    $post_args = [
        "game" => "TIC-TAC-TOE-ELIAS",
        "player" => $nombre,
        "score" => $milisegundos,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $urlAddScore,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($post_args),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Accept-Encoding: UTF-8",
        ),
    ]);

    $responseContent = curl_exec($ch);
    curl_close($ch);
    echo $responseContent;

