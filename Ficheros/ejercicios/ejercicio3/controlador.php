<?php

include("funciones.php");
include("constantes.php");
if (isset($_POST["enviar"])) {
    veriForm();
} else if (isset($_POST['ver'])) {
    verDatos();
} else {
    displayForm();
}

function veriForm() {
    $camposObligatorios = array("nombre", "edad", "apellidos");
    $camposPendientes = array();
    $camposMal = array();
    if (isset($_POST["nombre"])) {
        if (empty($_POST["nombre"])) {
            $camposPendientes[] = 'nombre';
        } else if (!preg_match('/^[A-Za-z][A-Za-z ]+$/', $_POST["nombre"])) {
            $camposMal[] = 'nombre';
        }
    }

    if (isset($_POST["apellidos"])) {
        if (empty($_POST["apellidos"])) {
            $camposPendientes[] = 'apellidos';
        } else if (!preg_match('/^[A-Za-z][A-Za-z ]+$/', $_POST["apellidos"])) {
            $camposMal[] = 'apellidos';
        }
    }

    if (isset($_POST["edad"])) {
        if (empty($_POST["edad"])) {
            $camposPendientes[] = 'edad';
        } else if (!filter_var($_POST["edad"], FILTER_VALIDATE_INT) || $_POST["edad"] > 99 || $_POST["edad"] < 0) {
            $camposMal[] = 'edad';
        }
    }

    if ($camposPendientes || $camposMal) {
        displayForm($camposPendientes, $camposMal);
    } else {
        guardarDatos();
    }
}

function displayForm($camposPendientes = array(), $camposMal = array()) {
    $error = '';
    if ($camposPendientes) {
        $error .= '<p class="error">Por favor, complete los campos remarcados de abajo.</p>';
    } else {
        $error = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    if ($camposMal) {
        $error .= '<p class="error_formato">Rellene correctamente los campos remarcados</p>';
    }

    $datos = array(
        "error" => $error,
        "validacionNombre" => validateField("nombre", $camposPendientes, $camposMal),
        "valorNombre" => setValue("nombre"),
        "validacionApellidos" => validateField("apellidos", $camposPendientes, $camposMal),
        "valorApellidos" => setValue("apellidos"),
        "validacionEdad" => validateField("edad", $camposPendientes, $camposMal),
        "valorEdad" => setValue("edad")
    );
    $plantilla = "plantillas/formulario.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario,
        "lista" => ''
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function guardarDatos() {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];

    $datos_existentes = fopen("datos.txt", "a");
    fwrite($datos_existentes, ("$nombre:$apellidos:$edad" . PHP_EOL));
    fclose($datos_existentes);
    verDatos();
}

function verDatos() {
    $datos_lista = '';
    $datos_existentes = fopen("datos.txt", "a+");
    while ($linea = fgets($datos_existentes)) {
        $arr = explode(":", $linea);
        $datos_lista .= '<ul>';
        foreach ($arr as $value) {
            $datos_lista .= "<li>$value</li>";
        }
        $datos_lista .= '</ul>';
    }
    $lista = array("datos" => $datos_lista . "<a href=''>Volver</a>");

    $datos = array(
        "titulo" => TITULO,
        "formulario" => '',
        "lista" => respuesta($lista, "plantillas/datos.html")
    );

    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}
