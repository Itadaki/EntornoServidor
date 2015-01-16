<?php

include("constantes.php");
session_start();
if (isset($_GET["accion"]) and $_GET["accion"] == "eliminar") {
    eliminarSesion();
} else if (isset($_GET["accion"]) and $_GET["accion"] == "resetear") {
    $_SESSION['contador'] = 0;
    displayForm();
} else {
    if (isset($_SESSION['contador'])) {
        $_SESSION['contador'] ++;
    } else {
        $_SESSION['contador'] = 0;
    }
    displayForm();
}

function displayForm() {
    $datos = array(
        "session_id" => session_id(),
        "contador" => $_SESSION['contador'],
        "session_name" => session_name(),
        "caducidad" => session_cache_expire() . ' minutos'
    );
    $plantilla = 'plantillas/datos_sesion.html';
    $salida = respuesta($datos, $plantilla);
    $plantilla = 'plantillas/plantilla.html';
    $datos = array(
        "titulo" => TITULO,
        "salida" => $salida
    );
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function eliminarSesion() {
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 3600, "/");
    }
    $_SESSION = array();
    session_destroy();
    $file = 'plantillas/sesion_borrada.html';
    $salida = file_get_contents($file);
    $plantilla = 'plantillas/plantilla.html';
    $datos = array(
        "titulo" => TITULO,
        "salida" => $salida
    );
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function respuesta($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}
