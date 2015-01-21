<?php

function login() {
    $usuarios = array(
    "diego"=>"123",
    "luis"=>"321",
    "pepe"=>"213"
);
    if (isset($_POST["username"]) and isset($_POST["password"])) {
        if(isset($usuarios[$_POST['username']])){
            if ($usuarios[$_POST['username']] == $_POST['password']){
                $_SESSION["username"] = $_POST['username'];
                session_write_close();
                header("Location: login.php");
            } else {
                displayForm("Perdón, usuario/password no existe. Por favor inténtelo de nuevo.");
            }
        } else {
            displayForm("Perdón, usuario/password no existe. Por favor inténtelo de nuevo.");
        }
    }
}

function logout() {
    unset($_SESSION["username"]);
    session_write_close();
    header("Location: login.php");
}

function displayPagina() {
    $username = $_SESSION["username"];
    $datos = array(
        "username" => $username
    );
    $plantilla = 'plantillas/salida.html';
    $salida = respuesta($datos, $plantilla);
    $plantilla = 'plantillas/plantilla.html';
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $salida
    );
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayForm($message = "") {
    $mensaje = "";
    if ($message)
        $mensaje = '<p class="error">' . $message . '</p>';
    $scriptURL = "login.php";
    $datos = array(
        "scriptUrl" => $scriptURL,
        "mensaje" => $mensaje
    );
    $plantilla = 'plantillas/formulario.html';
    $formulario = respuesta($datos, $plantilla);
    $plantilla = 'plantillas/plantilla.html';
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
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
