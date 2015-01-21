<?php

function bienvenida() {
    $datos = array(
        "salida" => file_get_contents("plantillas/bienvenida.html"),
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function registrar($mensaje = '') {
    if ($mensaje) {
        $mensaje = '<p class="error">' . $mensaje . '</p>';
    }
    $datos = array(
        "mensaje" => $mensaje,
    );
    $salida = respuesta($datos, "plantillas/registrar.html");
    $datos = array(
        "salida" => $salida,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function guardarDatos() {
    $mensaje = 'Error';
    if (isset($_POST['nombre']) && isset($_POST['password']) && !empty($_POST['nombre']) && !empty($_POST['password'])) {
        $id = fopen('./users', 'a');
        fwrite($id, $_POST['nombre'] . ':' . $_POST['password'] . PHP_EOL);
        $mensaje = 'Registrado!';
    }
    registrar($mensaje);
}

function login($mensaje = '') {
    if ($mensaje) {
        $mensaje = '<p class="error">' . $mensaje . '</p>';
    }
    $datos = array(
        "mensaje" => $mensaje,
    );
    $salida = respuesta($datos, "plantillas/login.html");
    $datos = array(
        "salida" => $salida,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function comprobarUsuario($user, $pass) {
    $grant = false;
    $id = fopen('./users', 'r');
    while ($linea = fgets($id)) {
        if ($linea == $user . ':' . $pass . PHP_EOL) {
            $grant = true;
            break;
        }
    }
    if ($grant) {
        mostrarAgenda();
    } else {
        login('error');
    }
}

function mostrarAgenda($mensaje = '') {
    if ($mensaje) {
        $mensaje = '<p class="error">' . $mensaje . '</p>';
    }
    $datos = array(
        "mensaje" => $mensaje,
    );
    $salida = respuesta($datos, "plantillas/agenda.html");
    $datos = array(
        "salida" => $salida,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
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
