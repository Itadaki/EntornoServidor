<?php

// Obtenemos valores del POST
/*$fecha = $_POST["fecha_nacimiento"];
$codigo = $_POST["codigo_postal"];
$telefono = $_POST["telefono"];*/

$entrada = fopen('php://input', 'r');
$datos = fgets($entrada);
$doc= new DOMDocument();
$doc->loadXML($datos);
$fecha_nodo = $doc->getElementsByTagName("fecha_nacimiento");
$fecha = $fecha_nodo->item(0)->nodeValue;  
$codigo_nodo = $doc->getElementsByTagName("codigo_postal");
$codigo = $codigo_nodo->item(0)->nodeValue;  
$telefono_nodo = $doc->getElementsByTagName("telefono");
$telefono = $telefono_nodo->item(0)->nodeValue;  
$doc->
// Realizariamos las comprobaciones necesarias....
//Devolvemos el resultado de la validación

// Imprescindible para que el navegador trate la respuesta como XML
header('Content-Type: text/xml; charset=utf-8');

// Generar contenidos XML de respuesta

echo "<respuesta>" .
 "<mensaje>Datos correctos</mensaje>".
 "<parametros>" .
 "<telefono>".$telefono."</telefono>".
 "<codigo_postal>".$codigo."</codigo_postal>".
 "<fecha_nacimiento>".$fecha."</fecha_nacimiento>".
 "</parametros>" .
 "</respuesta>";
?>