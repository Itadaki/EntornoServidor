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
    global $mensaje;
    global $mensajeInsertar;
    global $mensajeCerrarConexion;
    global $mensajeAbrirConexion;
    global $nombre;
    global $enlace;
    global $ref;
    $nombre = $_POST['nombre'] . ' ' . $_POST['ap1'] . ' ' . $_POST['ap2'];
    $dni = $_POST['dni'];
    $datos = array(
        "nombre" => $nombre,
        "dni" => $dni,
        "ref" => $ref,
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

function displayForm($camposErroneos, $camposPendientes) {
    $error = '';
    if ($camposPendientes and $camposErroneos) {
        $error = '<p class="error_back2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos.</p>';
    } elseif ($camposPendientes) {
        $error = '<p class="error_back">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
    } elseif ($camposErroneos) {
        $error = '<p class="error_back2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos .</p>';
    } else {
        $error .= '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar.</p>';
    }
    $datos = array(
        "error" => $error,
        "validacionNombre" => validateField("nombre", $camposPendientes, $camposErroneos),
        "validacionAp1" => validateField("ap1", $camposPendientes, $camposErroneos),
        "validacionAp2" => validateField("ap2", $camposPendientes, $camposErroneos),
        "validacionDni" => validateField("dni", $camposPendientes, $camposErroneos),
        "validacionTelefono" => validateField("telefono", $camposPendientes, $camposErroneos),
        "validacionEmail" => validateField("email", $camposPendientes, $camposErroneos),
        "validacionOrigen" => validateField("origen", $camposPendientes, $camposErroneos),
        "validacionDestino" => validateField("destino", $camposPendientes, $camposErroneos),
        "optionsOrigen" => generarOrigen(),
        "nombre" => setValue("nombre"),
        "ap1" => setValue("ap1"),
        "ap2" => setValue("ap2"),
        "dni" => setValue("dni"),
        "telefono" => setValue("telefono"),
        "email" => setValue("email")
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

function generarOrigen() {
    $query = "select id,nombre FROM billetes.ciudades";
    $resultado = select($query);
    $origenes = '<option value="">----Seleccione origen----</option>';
    while ($campos = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $datos = array(
            "id" => $campos['id'],
            "nombre" => $campos['nombre']
        );
        $plantilla = "plantillas/origen.html";
        $origenes .= respuesta($datos, $plantilla);
    }
    return $origenes;
}

function verReferencias(){
    $query = "select referencia,dni,origen,destino FROM billetes.referencias";
    $resultado = select($query);
    $tabla = '<table class="salida"><tr><th>referencia</th><th>dni</th><th>origen</th><th>destino</th></tr>';
    while ($campos = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $tabla .= "<tr><td>{$campos['referencia']}</td><td>{$campos['dni']}</td><td>{$campos['origen']}</td><td>{$campos['destino']}</td></tr>";
    }
    $tabla.='</table>';
    $tabla .= "<a href='index.php'>Volver al formulario de introducción de datos</a><br>"
                . "<a href='index.php?ver=referencias'>Ver las referencias</a><br>"
                . "<a href='index.php?ver=personas'>Ver las personas</a>";
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $tabla
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function verPersonas(){
    $query = "select dni,nombre FROM billetes.personas";
    $resultado = select($query);
    $tabla = '<table class="salida"><tr><th>dni</th><th>nombre</th></tr>';
    while ($campos = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $tabla .= "<tr><td>{$campos['dni']}</td><td>{$campos['nombre']}</td></tr>";
    }
    $tabla.='</table>';
    $tabla .= "<a href='index.php'>Volver al formulario de introducción de datos</a><br>"
                . "<a href='index.php?ver=referencias'>Ver las referencias</a><br>"
                . "<a href='index.php?ver=personas'>Ver las personas</a>";
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $tabla
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}