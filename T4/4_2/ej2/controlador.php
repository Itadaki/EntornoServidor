<?php

include("constantes.php");

if (isset($_POST["enviar"])) {
    guardarInfo();
} elseif (isset($_GET["accion"]) and $_GET["accion"] == "olvidar") {
    olvidarInfo();
} elseif (isset($_COOKIE['nombre'])) {
    verDatos();
} else {
    verFormulario();
}

function guardarInfo() {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $calorias = $_POST['calorias'];
    $transporte = $_POST['transporte'];
    $t_expiracion = time() + 600;

    setcookie('nombre', $nombre, $t_expiracion);
    setcookie('apellidos', $apellidos, $t_expiracion);
    setcookie('calorias', $calorias, $t_expiracion);
    setcookie('transporte', $transporte, $t_expiracion);
    header('Location: controlador.php');
}

function olvidarInfo() {
    setcookie('nombre', '', -1);
    setcookie('apellidos', '', -1);
    setcookie('calorias', '', -1);
    setcookie('transporte', '', -1);
    header('Location: controlador.php');
}

function verFormulario() {
    $datos = array(
        "datos" => file_get_contents('plantillas/formulario.html'),
        "titulo" => TITULO
    );
    $plantilla = 'plantillas/plantilla.html';
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function verDatos() {
    $nombre = $_COOKIE['nombre'];
    $apellidos = $_COOKIE['apellidos'];
    $calorias = $_COOKIE['calorias'];
    $transporte = $_COOKIE['transporte'];
    
    $salida = "Hola $nombre $apellidos!<br>".
            "Calorias que derrochar: $calorias<br>".
            "Transporte preferido: $transporte";
    
    $datos = array(
        "datos" => $salida . "<br><a href='?accion=olvidar'>olvidar info</a>",
        "titulo" => TITULO
    );
    $plantilla = 'plantillas/plantilla.html';
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
