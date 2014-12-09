<?php

include("constantes.php");
$color = "";
$salida ='';
$enlaces='';
$estilo='';
if (isset($_GET['color'])) {
    setcookie("color", $_GET["color"]);
    $file = 'plantillas/salida.html';
    $salida = file_get_contents($file);
} else {
    if (isset($_COOKIE["color"]))
        $estilo= "<style type=\"text/css\">body{ color: ".$_COOKIE["color"]."; }</style>\n";
    $file = 'plantillas/enlaces.html';
    $enlaces = file_get_contents($file);
}
$datos = array(
    "enlaces" => $enlaces,
    "salida" => $salida,
    "estilo"=>$estilo,
    "titulo" => TITULO
);
$plantilla = 'plantillas/plantilla.html';
$html = respuesta($datos, $plantilla);
print ($html);

function respuesta($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}
