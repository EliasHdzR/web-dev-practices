<?php
    usleep(2500000);
    $now = new DateTime();
    $resObj = [
        "fechaHora" => $now->format("d/m/Y H:i:s"),
        "fecha" => $now->format("d/m/Y"),
    ];

    $resObjJson = json_encode($resObj);
    header('Content-type: application/json');
    echo $resObjJson;