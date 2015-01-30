<?php

$a[1][1] = "Valladolid";
$a[1][2] = "Burgos";
$a[1][3] = "León";
$a[1][4] = "Palencia";
$a[1][5] = "Zamora";
$a[2][1] = "Toledo";
$a[2][2] = "Albacete";
$a[3][1] = "Valencia";
$a[3][2] = "Castellón";
$a[3][3] = "Alicante";

// Obtenemos valores del POST
$response = $_POST['xml'];
$doc = new DOMDocument();
$doc->loadXML($response);
$comunidad_nodo = $doc->getElementsByTagName("comunidad");
$comunidad = $comunidad_nodo->item(0)->nodeValue;

// Realizariamos las comprobaciones necesarias....
//Devolvemos el resultado de la validación

header('Content-Type: text/xml');
$xml = "<ciudades>";

$ciudades = $a[$comunidad];
foreach ($ciudades as $j) {
    $xml = $xml . "<ciudad>" . $j . "</ciudad>";
}
$xml = $xml . "</ciudades>";
echo $xml;
?>