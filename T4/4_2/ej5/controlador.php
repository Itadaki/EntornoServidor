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
    if (isset($_COOKIE['visitas'])) {
        $visitas = $_COOKIE['visitas'] + 1;
    } else {
        $visitas = 1;
    }
    setcookie('visitas', $visitas, time() + 600);

    $tiempoTranscurridoMinutos = 0;
    $tiempoTranscurridoSegundos = 0;
    if (!isset($_COOKIE["primeraVisita"])) {
        setcookie("primeraVisita", time(), time() + 60 * 60 * 24 * 365, "/", "");
    } else {
        $tiempoTranscurrido = time() - $_COOKIE["primeraVisita"];
        $tiempoTranscurridoMinutos = (int) ( $tiempoTranscurrido / 60 );
        $tiempoTranscurridoSegundos = $tiempoTranscurrido % 60;
    }
    $datos = array(
        "datos" => file_get_contents('plantillas/formulario.html') .
        "Has visitado nuestra pagina $visitas veces<br>" .
        "Visitó esta página por primera vez hace $tiempoTranscurridoMinutos minutos y $tiempoTranscurridoSegundos segundos",
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

    $arrTransporte = array(
        "Palanquin" => "Disfrute del palanquín mandarin",
        "Litera romana" => "Literas de roma y toma",
        "Bici-taxi" => "Bici-Tacsis de HUBER",
        "Limusina" => "Le limousine noir"
    );

    $salida = "Hola $nombre $apellidos!<br>" .
            "Calorias que derrochar: $calorias<br>" .
            "Transporte preferido: $transporte";

    $datos = array(
        "datos" => $salida . "<br><a href='?accion=olvidar'>olvidar info</a><br>"
        . $arrTransporte[$_COOKIE['transporte']],
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
