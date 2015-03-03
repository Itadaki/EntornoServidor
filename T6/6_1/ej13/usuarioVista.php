<?php

function validateField($campo, $camposNoRellenados, $camposerroneos) {
    if (in_array($campo, $camposNoRellenados)) {
        return ' class="error1"';
    } elseif (in_array($campo, $camposerroneos)) {
        return ' class="error2"';
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

function setSelected( $nombreCampo, $valorCampo ) {
if ( isset( $_POST[$nombreCampo] ) and $_POST[$nombreCampo] == $valorCampo ) {
return ' selected="selected"';
}
}

function displayForm($camposerroneos, $campospendientes, $duplicado) {
    $mensaje = "";
    $error = "";
    $checked = "";
    $selected = "";
    if ($campospendientes or $camposerroneos or $duplicado) {
        if ($campospendientes) {
            $error .= '<p class="error1">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Enviar para volver a enviar el formulario.</p>';
        }
        if ($camposerroneos) {
            $error .= '<p class="error2">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados en los campos.</p>';
        }
        if ($duplicado){
            $error .='<p class="error3">Hubo algunos problemas con el formulario que usted presentó.
El DNI ya existe.</p>';
        }
    } else {
        $mensaje = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar. Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $checked = 'checked';
    $selected = 'selected';
    $datos = array(
        "error" => $error,
        "mensaje" => $mensaje,
        "checked" => $checked,
        "selected" => $selected,
        "validaciondni" => ($duplicado)?'class="error3"':validateField("dni", $campospendientes, $camposerroneos),
        "validacionnombre" => validateField("nombre", $campospendientes, $camposerroneos),
        "validacionfechaalta" => validateField("fechaalta", $campospendientes, $camposerroneos),
        "validacioncuota" => validateField("cuota", $campospendientes, $camposerroneos),
        "dni" => setValue("dni"),
        "nombre" => setValue("nombre"),
        "fechaalta" => setValue("fechaalta"),
        "cuota" => setValue("cuota"),
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

function visualizarDatos($notas) {
    global $campos;
    $filas = "";
    $enlace = "<a href='index.php'>Volver al formulario de búsqueda de datos</a>";
    if ($notas) {
        $plantilla = "plantillas/fila.html";
        $mensaje = 'LISTADO DE SOCIOS';
        foreach ($notas as $datos) {
            $filas .='<tr>';
            foreach ($datos as $dato) {
                $filas .= "<td>$dato</td>";
            }
//no hace falta fabricar el array $datos puesto que $notas se compone de uno o más arrays $datos (uno por cada nota)
            $filas .='</tr>';
        }
//        $mensajeRegistros = "";
//        if (isset($_POST['numeroregistros'])) {
//            $numeroRegistros = count($notas);
//            $mensajeRegistros = "Se encontraron $numeroRegistros registro/s";
//        }
        $datos = array(
            "mensaje" => $mensaje,
            "filas" => $filas,
//            "mensajeRegistros" => $mensajeRegistros,
            "enlace" => $enlace
        );
    } else {
        $mensaje = 'NO HAY RESULTADOS';
        $datos = array(
            "mensaje" => $mensaje,
            "filas" => "",
//            "mensajeRegistros" => "",
            "enlace" => $enlace
        );
    }
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

//function obtenerNotas($valores_campos, $tabla) {
//    global $campos;
//    global $mensaje;
//    $resultado = load($valores_campos, TABLA);
////$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
//    if (!$resultado && $mensaje) {
//        visualizarError();
//    } else {
//        return $resultado;
//    }
//}

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
