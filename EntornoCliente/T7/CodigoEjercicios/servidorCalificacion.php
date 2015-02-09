<?php

$entrada = fopen('php://input', 'r');
$datos = fgets($entrada);
$datos = json_decode($datos, true);
// Generar un n�mero aleatorio
srand((double)microtime()*1000000);
$numeroAleatorio = rand(0, 10);

// Simular un falso retardo por la red y el servidor (entre 0 y 3 segundos)
sleep($numeroAleatorio % 3);
switch ($datos['alumno']) {
    case 'Juan Gómez Gómez':
        switch ($datos['materia']) {
            case 'Matemáticas':
                echo '{"calificacion":7.5}';
                break;
            case 'Lenguaje':
                echo '{"calificacion":9.5}';
                break;
        }
        break;
    case 'Pepe García García':
        switch ($datos['materia']) {
            case 'Matemáticas':
                echo '{"calificacion":8.5}';
                break;
            case 'Lenguaje':
                echo '{"calificacion":7.5}';
                break;
        }
        break;
}
?>
