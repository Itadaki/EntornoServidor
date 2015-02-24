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
    $nombre = $_POST['nombre'];
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

function displayForm($camposErroneos, $camposPendientes, $duplicado) {
    $error = '';
    if ($camposPendientes and $camposErroneos and $duplicado) {
        $error = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos.</p>';
    } elseif ($camposPendientes) {
        $error = '<p class="error">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
    } elseif ($camposErroneos) {
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
    $conexion = conexion();
    $consulta = mysqli_stmt_init($conexion);
    mysqli_stmt_prepare($consulta, "select id,nombre FROM billetes.ciudades");
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $id, $nombre);
    $origenes = '<option value="">----Seleccione origen----</option>';
    while (mysqli_stmt_fetch($consulta)) {
        $datos = array(
            "id" => $id,
            "nombre" => $nombre
        );
        $plantilla = "plantillas/origen.html";
        $origenes .= respuesta($datos, $plantilla);
    }
    cerrarConsulta($consulta);
    return $origenes;
}
