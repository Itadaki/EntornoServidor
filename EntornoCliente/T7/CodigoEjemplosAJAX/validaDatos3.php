<?php

// Obtenemos valores del POST
/* $fecha = $_POST["fecha_nacimiento"];
  $codigo = $_POST["codigo_postal"];
  $telefono = $_POST["telefono"]; */

$response = $_POST['json'];
$doc = json_decode($response,true);
$fecha = $doc['fecha_nacimiento'];
$codigo = $doc['codigo_postal'];
$telefono = $doc['telefono'];


// Realizariamos las comprobaciones necesarias....
//Devolvemos el resultado de la validación
// Generar contenidos JSON de respuesta


//json_encode nos codifica adecuadamente el tipo de datos a pasar, por que si son string hay que entrecomillar
//y si no lo hacemos a mano o utilizamos json_encode no dará el error: ReferenceError: ... is not defined
echo "{ \"mensaje\": \"Todo es correcto\"" .
 ",\"parametros\": {\"telefono\":" . json_encode($telefono) .
 ",\"codigo_postal\":" . json_encode($codigo).
 ",\"fecha_nacimiento\":" . json_encode($fecha) . "}}"
;
?>