<?php
    $urlGetScores = "http://primosoft.com.mx/games/api/getscores.php?game=TIC-TAC-TOE-ELIAS&orderAsc=1";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $urlGetScores,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    $responseContent = curl_exec($ch);
    curl_close($ch);
    $scores = json_decode($responseContent, true);

    include "views/index.view.php";