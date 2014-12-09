<?php

include("constantes.php");
$letra_fuente = "";
$letra_tamanio = "";
$color_plano = "";
$color_fondo = "";
if ($_POST) {
    setcookie("entorno[color_fondo]", $_POST["color_fondo"]);
    setcookie("entorno[color_plano]", $_POST["color_plano"]);
    setcookie("entorno[letra_fuente]", $_POST["letra_fuente"]);
    setcookie("entorno[letra_tamanio]", $_POST["letra_tamanio"]);
    $file = 'plantillas/salida.html';
    $formulario = file_get_contents($file);
} else {
    if (isset($_COOKIE["entorno"]["color_fondo"]))
        $color_fondo = $_COOKIE["entorno"]["color_fondo"];
    if (isset($_COOKIE["entorno"]["color_plano"]))
        $color_plano = $_COOKIE["entorno"]["color_plano"];
    if (isset($_COOKIE["entorno"]["letra_fuente"]))
        $letra_fuente = $_COOKIE["entorno"]["letra_fuente"];
    if (isset($_COOKIE["entorno"]["letra_tamanio"]))
        $letra_tamanio = $_COOKIE["entorno"]['letra_tamanio'] . 'px';
    $file = 'plantillas/formulario.html';
    $formulario = file_get_contents($file);
}
$datos = array(
    "letra_tamanio" => $letra_tamanio,
    "letra_fuente" => $letra_fuente,
    "color_plano" => $color_plano,
    "color_fondo" => $color_fondo,
    "formulario" => $formulario,
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
