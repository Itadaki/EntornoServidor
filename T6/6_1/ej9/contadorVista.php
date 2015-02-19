<?php

function visualizarError() {
    global $mensaje;
    global $mensajeAbrirConexion;
    global $mensajeCerrarConexion;
    $datos = array(
        "mensaje" => $mensaje,
        "mensajeAbrirConexion" => $mensajeAbrirConexion,
        "mensajeCerrarConexion" => $mensajeCerrarConexion,
    );
    $plantilla = "plantillas/error.html";
    $salida = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $salida
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}








function validateField($campo, $camposNoRellenados, $camposerroneos) {
    if (in_array($campo, $camposNoRellenados)) {
        return ' class="error"';
    } elseif (in_array($campo, $camposerroneos)) {
        return ' class="error1"';
    }
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function setChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo]) and $_POST[$nombreCampo] == $valorCampo) {
        return ' checked="checked"';
    }
}

function setSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo]) and $_POST[$nombreCampo] == $valorCampo) {
        return ' selected="selected"';
    }
}

function visualizarDatos() {
    global $mensaje;
    global $mensajeInsertar;
    global $mensajeCerrarConexion;
    global $mensajeAbrirConexion;
    global $nombre;
    global $enlace;
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $salario = $_POST['salario'];
    $telefono1 = $_POST['telefono1'];
    $telefono2 = $_POST['telefono2'];
    $datos = array(
        "nombre" => $nombre,
        "dni" => $dni,
        "salario" => $salario,
        "telefono1" => $telefono1,
        "telefono2" => $telefono2,
        "mensaje" => $mensaje,
        "mensajeInsertar" => $mensajeInsertar,
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
    if ($campospendientes and $camposerroneos and $duplicado) {
        $error = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos.</p>';
    } elseif ($campospendientes) {
        $error = '<p class="error">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
    } elseif ($camposerroneos) {
        $error = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos .</p>';
    } else {
        $error .= '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    if ($duplicado) {
        $error.='<p class="error2">DNI duplicado.</p>';
    }
    $datos = array(
        "error" => $error,
        "validacionNombre" => validateField("nombre", $campospendientes, $camposerroneos),
        "validacionDni" => validateField("dni", $campospendientes, $camposerroneos) . (($duplicado) ? 'class="error2"' : ''),
        "nombre" => setValue("nombre"),
        "dni" => setValue("dni"),
        "salario" => setValue("salario"),
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
