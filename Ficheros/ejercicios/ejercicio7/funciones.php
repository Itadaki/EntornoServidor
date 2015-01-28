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
        mostrarAgenda($user);
    } else {
        login('Usuario o contraseña no existen');
    }
}

function mostrarAgenda($usuario, $mensaje = '') {
    if ($mensaje) {
        $mensaje = '<p class="error">' . $mensaje . '</p>';
    }
    $filasCitas = '';
    $agenda = fopen('./agenda', 'r');
    while ($linea = fgets($agenda)) {
        $patron = "/^$usuario;[\w\W]*$/";
        if (preg_match($patron, $linea)) {
            $citas = explode(';', $linea)[1];
            $arr = explode(':', $citas);
            $datos = array(
                "nombre" => $arr[0],
                "fecha" => $arr[1]
            );
            $filasCitas .= respuesta($datos, "plantillas/tarea.html");
        }
    }
    $datos = array("citas" => $filasCitas);
    $salida = respuesta($datos, "plantillas/agenda.html");
    $datos = array(
        "salida" => $salida,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function verAñadirCita($camposPendientes = '', $mensaje = '') {
    if ($camposPendientes) {
        $mensaje = '<p class="error">Es necesario una descripcion</p>';
    }
    $datos = array(
        "mensaje" => $mensaje
    );
    $salida = respuesta($datos, "plantillas/add_tarea.html");
    $datos = array(
        "salida" => $salida,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function añadirTarea($usuario) {
    if (!empty($_POST['descripcion'])) {
        $agenda = fopen('./agenda', 'a+');
        fwrite($agenda, $usuario . ';' . $_POST["descripcion"] . ':' . $_POST['fecha'] . PHP_EOL);
        mostrarAgenda('diego', 'Tarea añadida');
    } else {
        verAñadirCita('', $mensaje = 'DESCRIPCION VACIA');
    }
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

