<?php

###SUGIERE ESTA FUNCION###

function validateField($campo, $camposPendientes, $camposErroneos, $duplicado = false, $message = 'correcto') {
    if (in_array($campo, $camposPendientes)) {
        return ' class="error_pendiente"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error_erroneo"';
    } elseif ($campo == 'foto' && $message != 'correcto') {
        return ' class="error_foto"';
    } elseif ($duplicado) {
        return ' class="error_duplicado"';
    }
}

###SUGIERE ESTA FUNCION###

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

###SUGIERE ESTA FUNCION###

function displayFormInicio() {
    $plantilla = "plantillas/formularioInicio.html";
    $formulario = respuesta(array(), $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

//
###SUGIERE ESTA FUNCION###

function displayFormBuscar($camposErroneos = array()) {
    $mensaje = "";
    $error = "";
    if ($camposErroneos) {
        $error.= '<p class="error_erroneo">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados en los campos (sólo letras sin acentuar y números).</p>';
    } else {
        $mensaje = '<p>Introduzca los datos del coche y pulse Buscar.<br>No escriba nada para mostrar todos los coches.</p>';
        $datos = array(
            "error" => $error,
            "mensaje" => $mensaje,
            "validacionMarca" => validateField("marca", array(), $camposErroneos),
            "marca" => setValue("marca"),
            "validacionModelo" => validateField("modelo", array(), $camposErroneos),
            "modelo" => setValue("modelo")
        );
        $plantilla = "plantillas/formularioBuscar.html";
        $formulario = respuesta($datos, $plantilla);
        $datos = array(
            "titulo" => TITULO,
            "formulario" => $formulario
        );
        $plantilla = "plantillas/plantilla.html";
        $html = respuesta($datos, $plantilla);
        print ($html);
    }
}

###SUGIERE ESTA FUNCION###

function displayFormInsertar($camposErroneos = array(), $camposPendientes = array(), $duplicado = false, $message = 'correcto') {
    $mensaje = "";
    $error= "";
    if ($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') {
        if ($camposPendientes) {
            $error.= '<p class="error_pendiente">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Guardar para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error.= '<p class="error_erroneo">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados (solo letras números y espacios en blanco) en los campos y pulse Guardar.</p>';
        }
        if ($duplicado) {
            $error.= '<p class="error_duplicado">Hubo algunos problemas con el formulario que usted presentó. El modelo ya existe.</p>';
        }
        if ($message != "correcto") {
            $error.= "<p class='error_foto'>Hubo algunos problemas la foto: $message</p>";
        }
    } else {
        $mensaje = '<p>Introduzca los datos del nuevo coche (los campos marcados con * son obligatorios) y pulse <b>Guardar</b></p>';
    }
    $datos = array(
        "error" => $error,
        "mensaje" => $mensaje,
        "validacionMarca" => validateField("marca", $camposPendientes, $camposErroneos, $duplicado),
        "marca" => setValue("marca"),
        "validacionModelo" => validateField("modelo", $camposPendientes, $camposErroneos, $duplicado),
        "modelo" => setValue("modelo"),
        "validacionFoto" => validateField("foto", $camposPendientes, $camposErroneos, $duplicado, $message)
    );
    $plantilla = "plantillas/formularioInsertar.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

###SUGIERE ESTA FUNCION###

function displayFormEditar($camposErroneos = array(), $camposPendientes = array(), $duplicado = false, $message = 'correcto') {
    $mensaje = "";
    $error = "";
    if ($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') {
        if ($camposPendientes) {
            $error.= '<p class="error_pendiente">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Guardar para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error.= '<p class="error_erroneo">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados (solo letras números y espacios en blanco) en los campos y pulse Guardar.</p>';
        }
        if ($duplicado) {
            $error.= '<p class="error_duplicado">Hubo algunos problemas con el formulario que usted presentó. El modelo ya existe.</p>';
        }
        if ($message != "correcto") {
            $error.= "<p class='error_foto'>Hubo algunos problemas la foto: $message</p>";
        }
    } else {
        $mensaje = '<p>Introduzca los datos del coche (los campos marcados con * son obligatorios) y pulse <b>Guardar</b></p>';
    }
    $datos = array(
        "error" => $error,
        "mensaje" => $mensaje,
        "validacionMarca" => validateField("marca", $camposPendientes, $camposErroneos, $duplicado),
        "marca" => setValue("marca"),
        "validacionModelo" => validateField("modelo", $camposPendientes, $camposErroneos),
        "modelo" => setValue("modelo"),
        "id" => setValue("id"),
        "validacionFoto" => validateField("nombre", $camposPendientes, $camposErroneos),
        "foto" => setValue("foto")
    );
    $plantilla = "plantillas/formularioModificar.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

###SUGIERE ESTA FUNCION###

function visualizarDatos($coches) {
    $mensaje = "";
    $filas = "";
    $enlace = "<a href='index.php?accion=buscar'>Volver al formulario de búsqueda de coches</a><br><br><a href='index.php'>Volver al menu principal</a>";
    if ($coches) {
        $plantilla = "plantillas/fila.html";
        $mensaje.= '<h3>LISTADO DE COCHES</h3>';
        foreach ($coches as $datos) {
            $filas.=respuesta($datos, $plantilla);
        }
        $mensaje.= "Resultados: ".count($coches)." coincidencias";
    } else {
        $mensaje.= 'NO HAY RESULTADOS';
    }
    $datos = array(
        "mensaje" => $mensaje,
        "filas" => $filas,
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

###SUGIERE ESTA FUNCION###

function visualizarResultado() {
    global $mensaje;
    global $enlace;
    $plantilla = "plantillas/resultado.html";
    $datos = array(
        "mensaje" => $mensaje,
        "enlace" => $enlace);
    $salida = respuesta($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $salida
    );
    $html = respuesta($datos, $plantilla);
    print ($html);
}

###SUGIERE ESTA FUNCION###

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

###SUGIERE ESTA FUNCION###

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
