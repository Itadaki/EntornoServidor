<?php

include("funciones.php");
include("constantes.php");
if (isset($_POST["alPaso2"])) {
    veriForm();
} else if (isset($_POST["alPaso1"])) {
    displayPaso1(array(), array(), '');
} else if (isset($_POST["alFinal"])) {
    procesForm();
} else {
    displayPaso1(array(), array(), '');
}

function veriForm() {

    $errorFoto = '';
    $camposObligatorios = array("nombre", "edad", "email");
    $camposPendientes = array();
    $camposMal = array();
    $errorFoto .= comprobarFoto('foto1');
    $errorFoto .= comprobarFoto('foto2');
    foreach ($camposObligatorios as $campoObligatorio) {
        //Evalua ($edad) como false si $edad='0' -> Entonces sale como no rellenado
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"])) {
        if (!preg_match('/^[A-Za-z][A-Za-z ]+$/', $_POST["nombre"])) {
            if (!in_array("nombre", $camposPendientes)) {
                $camposMal[] = 'nombre';
            }
        }
    }

    if (isset($_POST["edad"])) {
        if (!filter_var($_POST["edad"], FILTER_VALIDATE_INT) || $_POST["edad"] > 99 || $_POST["edad"] < 0) {
            if (!in_array("edad", $camposPendientes)) {
                $camposMal[] = 'edad';
            }
        }
    }
    if (isset($_POST["email"])) {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            if (!in_array("email", $camposPendientes)) {
                $camposMal[] = 'email';
            }
        }
    }
    if ($camposPendientes || $camposMal || $errorFoto) {
        displayPaso1($camposPendientes, $camposMal, $errorFoto);
    } else {
        displayPaso2();
    }
}

function displayPaso1($campospendientes, $camposMal, $errorFoto) {
    $error = '';
    if ($campospendientes) {
        $error = '<p class="error_vacio">Por favor, complete los campos remarcados de abajo.</p>';
    } else {
        $error = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    if ($camposMal) {
        $error .= '<p class="error_formato">Rellene correctamente los campos remarcados</p>';
    }
    if ($errorFoto != '') {
        $error .= '<p class="error_foto">' . $errorFoto . '</p>';
    }

    $datos = array(
        "error" => $error,
        "scriptUrl" => "controlador.php",
        "validacionNombre" => validateField("nombre", $campospendientes, $camposMal),
        "valorNombre" => setValue("nombre"),
        "validacionEdad" => validateField("edad", $campospendientes, $camposMal),
        "valorEdad" => setValue("edad"),
        "validacionEmail" => validateField("email", $campospendientes, $camposMal),
        "valorEmail" => setValue("email"),
        "valorGenero" => isset($_POST['genero']) ? $_POST['genero'] : ''
    );
    $plantilla = "plantillas/formulario_1.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    $html = str_replace('{datos}', '', $html);
    print ($html);
}

function displayPaso2() {
    $foto1 = $_FILES["foto1"]["name"];
    $foto2 = $_FILES["foto2"]["name"];
    $datos = array(
        "scriptUrl" => "controlador.php",
        "valorNombre" => setValue("nombre"),
        "valorEdad" => setValue("edad"),
        "valorEmail" => setValue("email"),
        "valorFoto1" => $foto1,
        "valorFoto2" => $foto2,
        "genero" => array(
            "western" => setSelected("genero", "western"),
            "comedia" => setSelected("genero", "comedia"),
            "drama" => setSelected("genero", "drama")
        )
    );
    $plantilla = "plantillas/formulario_2.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    $html = str_replace('{datos}', '', $html);
    print ($html);
}

function procesForm() {
    $generos = array(
        "western" => "El caballo<br>Clit Eastwood<br>El feo",
        "comedia" => "Comedias varias<br>El comediante<br>Paramount",
        "drama" => "Los puentes de madison<br>El pianista<br>Heartshooter"
    );
    $nombreLargo = setValue('nombre');
    $nombre = explode(" ", $nombreLargo);
    $datos = array(
        "nombre" => $nombre[0],
        "foto1" => setValue("foto1"),
        "foto2" => setValue("foto2"),
        "generos" => $generos[$_POST["genero"]],
        "genero" => setValue('genero')
    );
    $plantilla = "plantillas/salida.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}
