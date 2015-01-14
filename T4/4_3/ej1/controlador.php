<?php

include("constantes.php");
session_start();

if(isset($_GET['paso2'])){
    displayPaso2();
} else if(isset($_GET['paso3'])){
    displayPaso3();
} else {
    displayPaso1();
}


function displayPaso1() {
    $variable = 'Maria';
    $_SESSION[$variable] = $variable;
    $datos = array(
        "titulo" => TITULO,
        "subtitulo" =>"Paso 1: se crea la variable de sesion y se almacena",
        "mensaje"=>"Valor de la variable de sesion: $variable",
        "enlace"=> "<a href='?paso2'>Al paso 2</a>"
    );
    $plantilla = 'plantillas/plantilla.html';
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayPaso2() {
    $variable = $_SESSION['Maria'];
    $datos = array(
        "titulo" => TITULO,
        "subtitulo" =>"Paso 2: acceder a la variable de sesion y se destruye",
        "mensaje"=>"Valor de la variable de sesion: $variable",
        "enlace"=> "<a href='?paso3'>Al paso 3</a>"
    );
    unset($_SESSION['Maria']);
    $plantilla = 'plantillas/plantilla.html';
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayPaso3() {
    $variable='';
    if(isset($_SESSION['Maria'])){
        $variable = $_SESSION['Maria'];
    }
    $datos = array(
        "titulo" => TITULO,
        "subtitulo" =>"Paso 3: la variable ya ha sido destruida y su valor se ha perdido",
        "mensaje"=>"Valor de la variable de sesion: $variable",
        "enlace"=> "<a href='?paso1'>Al paso 1</a>"
    );
    $plantilla = 'plantillas/plantilla.html';
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
