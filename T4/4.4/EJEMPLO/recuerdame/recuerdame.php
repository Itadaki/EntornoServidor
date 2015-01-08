<?php

include("constantes.php");
if (isset($_POST["enviarInfo"])) {
    guardarInfo();
} elseif (isset($_GET["accion"]) and $_GET["accion"] == "olvida") {
    olvidarInfo();
} else {
    verFormulario();
}

function guardarInfo() {
    if (isset($_POST["nombre"])) {
        setcookie("nombre", $_POST["nombre"], time() + 60 * 60 * 24 * 365, "", "", false, true);
    }
    if (isset($_POST["localizacion"])) {
        setcookie("localizacion", $_POST["localizacion"], time() + 60 * 60 * 24 *
                365, "", "", false, true);
    }
    header("Location: recuerdame.php");
}

function olvidarInfo() {
    setcookie("nombre", "", time() - 3600, "", "", false, true);
    setcookie("localizacion", "", time() - 3600, "", "", false, true);
    header("Location: recuerdame.php");
}

function verFormulario() {
    $nombre = (isset($_COOKIE["nombre"])) ? $_COOKIE["nombre"] : "";
    $localizacion = (isset($_COOKIE["localizacion"])) ? $_COOKIE["localizacion"] : "";
    if ($nombre and $localizacion) {
        $plantilla = 'plantillas/salida.html';
        $datos = array(
            "nombre" => $nombre,
            "localizacion" => $localizacion,
        );
        $formulario = respuesta($datos, $plantilla);
    } else {
        $file = 'plantillas/formulario.html';
        $formulario = file_get_contents($file);
    }
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario,
    );
    $html = respuesta($datos, $plantilla);
    print($html);
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
?>