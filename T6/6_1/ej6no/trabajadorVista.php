<?php

function validateField($campo, $camposNoRellenados, $camposerroneos, $duplicado = '') {
    if (in_array($campo, $camposNoRellenados)) {
        return ' class="error1"';
    } elseif (in_array($campo, $camposerroneos)) {
        return ' class="error2"';
    } elseif ($campo == 'dni' and $duplicado)
        return ' class="error3"';
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function visualizarDatos() {
    global $mensaje;
    global $mensajeCerrarConexion;
    global $mensajeAbrirConexion;
    global $enlace;
    $datos = array(
        "mensaje" => $mensaje,
        "mensajeAbrirConexion" => $mensajeAbrirConexion,
        "mensajeCerrarConexion" => $mensajeCerrarConexion,
        "enlace" => $enlace
    );
    $plantilla = "plantillas/salida.html";
    $salida = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $salida
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayForm($camposerroneos, $campospendientes, $duplicado) {
    $error1 = "";
        $error2 = "";
        $error3 = "";
        $mensaje = "";
    if ($campospendientes or $camposerroneos or $duplicado) {
        if ($campospendientes) {
            $error1 = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
        }
        if ($camposerroneos) {
            $error2 = '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos.</p>';
        }
        if ($duplicado) {
            $error3 = '<p class="error3">Hubo algunos problemas con el formulario que usted presentó.
El DNI ya existe.</p>';
        }
    } else {
        $mensaje = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $datos = array(
        "error1" => $error1,
        "error2" => $error2,
        "error3" => $error3,
        "mensaje" => $mensaje,
        "validacionNombre" => validateField("nombre", $campospendientes, $camposerroneos),
        "nombre" => setValue("nombre"),
        "validacionDni" => validateField("dni", $campospendientes, $camposerroneos, $duplicado),
        "dni" => setValue("dni"),
        "salario" => setvalue("salario"),
        "telefono1" => setValue("telefono1"),
        "telefono2" => setValue("telefono2")
    );
    $plantilla = "plantillas/formulario.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1)
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = '{' . $key1 . '}';
            $html = str_replace($cadena, $valor1, $html);
        }
    return $html;
}
