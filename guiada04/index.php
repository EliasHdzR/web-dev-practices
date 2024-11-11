<?php
    $tituloPagina = "Guiada 04: Introducción a la programación del Lado del Servidor";

    $persona1 = [
        'nombre' => 'Persona 1',
        'apellidos' => 'Apellido 1',
        'edad' => 32,
        'deportesPracticados' => [
            'futbol','tenis','basquet'
        ]
    ];

    $persona2 = array(
        'nombre' => 'Persona 2',
        'apellidos' => 'Apellido 2',
        'edad' => 30,
        'deportesPracticados' => [
            'futbol americano','baseball','basquet'
        ]
    );

    $personas = [$persona1, $persona2];

    $deportesPersona1 = $persona1['deportesPracticados'];

    $persona3 = array(
        'nombre' => 'Persona 3',
        'apellidos' => 'Apellido 3',
        'edad' => 36,
        'deportesPracticados' => [
            'futbol americano'
        ]
    );

    $personas[] = $persona3;

    require 'index.view.php';

