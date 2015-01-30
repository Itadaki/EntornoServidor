<?php

$entrada = fopen('php://input', 'r');
$datos = fgets($entrada);
$datos = json_decode($datos, true);
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
