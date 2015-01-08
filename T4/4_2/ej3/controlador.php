<?php

include("constantes.php");

if (isset($_POST["enviar"])) {
    guardarInfo();
} elseif (isset($_GET["accion"]) and $_GET["accion"] == "olvidar") {
    olvidarInfo();
} elseif (isset($_COOKIE['arma'])) {
    verDatos();
} else {
    verFormulario();
}

function guardarInfo() {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $arma = $_POST['arma'];
    if (isset($_POST["especies"])) {
        foreach ($_POST["especies"] as $key => $value) {
            setcookie("especies[$key]", $value, $t_expiracion);
        }
    }
    $t_expiracion = time() + 600;

    setcookie('nombre', $nombre, $t_expiracion);
    setcookie('apellidos', $apellidos, $t_expiracion);
    setcookie('arma', $arma, $t_expiracion);
    header('Location: controlador.php');
}

function olvidarInfo() {
    setcookie('nombre', '', -1);
    setcookie('apellidos', '', -1);
    setcookie('arma', '', -1);
    if (isset($_COOKIE["especies"])) {
        foreach ($_COOKIE["especies"] as $key => $value) {
            setcookie("especies[$key]", '', -1);
        }
    }
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
    $arma = $_COOKIE['arma'];
    $nom_especies = '';
    if (isset($_COOKIE["especies"])) {
        foreach ($_COOKIE["especies"] as $key => $value) {
            $nom_especies .= "$value ";
        }
    }
    $especies = "Hola $nombre $apellidos.<br>Tomamos nota del arma $arma.<br>";
    if (isset($_COOKIE["especies"])){
        $especies .= "Y de las especies $nom_especies.<br>";
    }
    $datos = array(
        "datos" => $especies . "<a href='?accion=olvidar'>olvidar info</a>",
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
