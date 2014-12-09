<?php

include("constantes.php");
$mensaje = "";
if (isset($_POST['crear'])) {
    $expira = time() + ($_POST["segundos"]);
    setcookie("cookie", $expira, $expira);
    $mensaje = "Se ha creado la cookie. Se destruirá en " . $_POST["segundos"] . " segundos";
} else if (isset($_COOKIE['cookie'])) {
    if (isset($_POST['comprobar'])) {
        $mensaje = "La cookie se destruira en " . ($_COOKIE['cookie'] - time());
    } else if (isset($_POST['destruir'])) {
        setcookie("cookie", '', -1);
        $mensaje = "La cookie se ha eliminado";
    }
}
$datos = array(
    "mensaje" => $mensaje,
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
