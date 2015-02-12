<?php

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
    global $mensajeInsertar;
    global $mensajeCerrarConexion;
    global $mensajeAbrirConexion;
    global $nombre;
    global $enlace;
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    if ($_POST["edad"] != '')
        $edad = "Tienes " . $_POST['edad'] . " años<BR>\n";
    else
        $edad = "No deseas que sepamos tu edad" . "<br>\n";
    $sistema = $_POST['sistema'] . "<BR>\n";
    if (isset($_POST['futbol'])) { // Solo se envía si se marcó el checkbox...
        $futbol = "Te gusta el futbol <BR>\n";
    } else {
        $futbol = "NO te gusta el futbol <BR>\n";
    }
    if ($_POST['aficiones'] != "") {
        $aficiones = "Tus aficiones son: <BR>\n" . nl2br($_POST['aficiones']) . "<br>\n";
// nl2br(cadena): convierte los "\n" en "<br>" dentro de la cadena.
    } else {
        $aficiones = "NO tienes aficiones <BR>\n";
    }
    $sistema = $_POST['sistema'];
    $datos = array(
        "nombre" => $nombre,
        "sexo" => $sexo,
        "edad" => $edad,
        "futbol" => $futbol,
        "aficiones" => $aficiones,
        "mensajeInsertar" => $mensajeInsertar,
        "mensajeCerrarConexion" => $mensajeCerrarConexion,
        "enlace" => $enlace,
        "sistema" => $sistema
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

function displayForm($camposerroneos, $campospendientes) {
    if ($campospendientes and $camposerroneos) {
        $error = '<p class="error">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>
<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos.</p>';
    } elseif ($campospendientes) {
        $error = '<p class="error">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
    } elseif ($camposerroneos) {
        $error = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos .</p>';
    } else {
        $error = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $datos = array(
        "error" => $error,
        "validacionNombre" => validateField("nombre", $campospendientes, $camposerroneos),
        "nombre" => setValue("nombre"),
        "edad" => setValue("edad"),
        "sistema" => array(
            "Linux" => setSelected("sistema", "Linux"),
            "Unix" => setSelected("sistema", "Unix"),
            "Windows" => setSelected("sistema", "Windows"),
            "Macintosh" => setSelected("sistema", "Macintosh")
        ),
        "sexo" => array(
            "hombre" => setChecked("sexo", "hombre"),
            "mujer" => setChecked("sexo", "mujer")
        ),
        "futbol" => setChecked("futbol", "ON"),
        "aficiones" => setValue("aficiones")
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
