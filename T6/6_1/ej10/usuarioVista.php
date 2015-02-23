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

function displayForm($camposerroneos, $campospendientes) {
    $mensaje = "";
    $error = "";
    if ($campospendientes or $camposerroneos) {
        if ($campospendientes) {
            $error .= '<p class="error1">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Enviar para volver a enviar el formulario.</p>';
        }
        if ($camposerroneos) {
            $error .= '<p class="error2">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados en los campos.</p>';
        }
    } else {
        $mensaje = '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar. Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $datos = array(
        "error" => $error,
        "mensaje" => $mensaje,
        "validacionNombre" => validateField("nombre", $campospendientes, $camposerroneos),
        "nombre" => setValue("nombre")
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

function visualizarDatos($producto) {
    $enlace = "<a href='index.php'>Volver al formulario de búsqueda de datos</a>";
    if ($producto) {
        $mensaje = 'PRODUCTO ENCONTRADO';
        $codigo = $producto['codigo'];
        $precio = $producto['precio'];
        $nombre = $producto['nombre'];
        $datos = array(
            "codigo" => $codigo,
            "precio" => $precio,
            "nombre" => $nombre
        );
        $plantilla = "plantillas/fila.html";
        $fila = respuesta($datos, $plantilla);
        $datos = array(
            "mensaje" => $mensaje,
            "fila" => $fila,
            "enlace" => $enlace
        );
    } else {
        $mensaje = 'PRODUCTO NO ENCONTRADO';
        $datos = array(
            "mensaje" => $mensaje,
            "fila" => '',
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

function obtenerProducto($valores_campos, $tabla) {
    global $mensaje;
    $resultado = load($valores_campos, TABLA);
    if (!$resultado && $mensaje) {
        visualizarError();
    } else {
        return $resultado;
    }
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
