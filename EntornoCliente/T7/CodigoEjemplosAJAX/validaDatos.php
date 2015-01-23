<?php

// Obtenemos valores del POST
$fecha = $_POST["fecha_nacimiento"];
$codigo = $_POST["codigo_postal"];
$telefono = $_POST["telefono"];

// Realizariamos las comprobaciones necesarias....
//Devolvemos el resultado de la validación

header('Content-Type:text/html; charset=utf-8');
echo "La fecha " . $fecha . " es correcta<br>" .
 "El código postal " . $codigo . " es correcto<br>" .
 "El teléfono " . $telefono . " es correcto<br>";
?>