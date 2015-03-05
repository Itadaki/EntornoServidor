<?php
###SUGIERE ESTA FUNCION###
function validateField($campo, $camposPendientes, $camposErroneos, $duplicado = false, $message = 'correcto') {
    if (in_array($campo, $camposPendientes)) {
        return ' class="error1"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error2"';
    } elseif ($campo == 'dni' && $duplicado) {
        return ' class="error3"';
    } elseif ($campo == 'foto' && $message != 'correcto') {
        return ' class="error4"';
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
    $datos = array();
    $plantilla = "plantillas/formularioInicio.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}//
###SUGIERE ESTA FUNCION###
function displayFormBuscar($camposErroneos=array()) {
    $mensaje = "";
    $error2 = "";
    if ($camposErroneos) {
        $error2 = '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos (sólo letras sin acentuar y números).</p>';
    } else {
        $mensaje = '<p> Introduzca los datos del coche y pulse Buscar.<br>
No escriba nada para mostrar todos los coches <br></p>';
        $datos = array(
            "error2" => $error2,
            "mensaje" => $mensaje,
            "validacionmarca" => validateField("marca", array(), $camposErroneos),
            "marca" => setValue("marca"),
            "validacionmodelo" => validateField("modelo", array(), $camposErroneos),
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
function displayFormInsertar($camposErroneos=array(), $camposPendientes=array(), $duplicado=false, $message = 'correcto') {
    $mensaje = "";
    $error1 = "";
    $error2 = "";
    $error3 = "";
    if ($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') {
        if ($camposPendientes) {
            $error1 = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Guardar
para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error2 = '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados (solo letras números y espacios en blanco) en los campos y pulse Guardar.</p>';
        }
        if ($duplicado) {
            $error3 = '<p class="error3">Hubo algunos problemas con el formulario que usted presentó.
El modelo ya existe.</p>';
        }
        if ($message != "correcto") {
            $error4 = '<p class="error4">Hubo algunos problemas la foto: <br>$message </p>';
        }
    } else {
        $mensaje = '<p>Introduzca los datos del nuevo coche (los campos marcados con * son obligatorios) y pulse <b>Guardar</b></p>';
    }
    $datos = array(
        "error1" => $error1,
        "error2" => $error2,
        "error3" => $error3,
        "mensaje" => $mensaje,
        "validacionmarca" => validateField("marca", $camposPendientes, $camposErroneos, $duplicado),
        "marca" => setValue("marca"),
        "validacionmodelo" => validateField("modelo", $camposPendientes, $camposErroneos),
        "modelo" => setValue("modelo"),
        "validacionfoto" => validateField("foto", $camposPendientes, $camposErroneos, $message)
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
function displayFormEditar($camposErroneos=array(), $camposPendientes=array(), $duplicado=false, $message='correcto') {
    $mensaje = "";
    $error1 = "";
    $error2 = "";
    $error3 = "";
    $error4 = "";
    if ($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') {
        if ($camposPendientes) {
            $error1 = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Guardar
para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error2 = '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados (solo letras números y espacios en blanco) en los campos y pulse Guardar.</p>';
        }
        if ($duplicado) {
            $error3 = '<p class="error3">Hubo algunos problemas con el formulario que usted presentó.
El modelo ya existe.</p>';
        }
        if ($message != "correcto") {
            $error4 = '<p class="error4">Hubo algunos problemas la foto: <br>$message </p>';
        }
    } else {
        $mensaje = '<p>Introduzca los datos del coche (los campos marcados con * son obligatorios) y pulse <b>Guardar</b></p>';
    }
    $datos = array(
        "error1" => $error1,
        "error2" => $error2,
        "error3" => $error3,
        "error42" => $error4,
        "mensaje" => $mensaje,
        "validacionmarca" => validateField("marca", $camposPendientes, $camposErroneos, $duplicado),
        "marca" => setValue("marca"),
        "validacionmodelo" => validateField("modelo", $camposPendientes, $camposErroneos),
        "modelo" => setValue("modelo"),
        "id" => setValue("id"),
        "validacionfoto" => validateField("nombre", $camposPendientes, $camposErroneos),
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
    $mensaje1 = "";
    $mensaje2 = "";
    $filas = "";
    $enlace = "<a href='index.php?accion=buscar'>Volver al formulario de búsqueda de coches</a> <br><br>
<a href='index.php'>Volver al menu principal</a>";
    if ($coches) {
        $plantilla = "plantillas/fila.html";
        $mensaje1 = 'LISTADO DE COCHES';
        foreach ($coches as $datos) {
//no hace falta fabricar el array $datos puesto que $notas se compone de uno o más arrays $datos (uno por cada coche)
            $filas.=respuesta($datos, $plantilla);
        }
        $numeroRegistros = count($coches);
        $mensaje2 = "Número de modelos de coches: $numeroRegistros";
        $datos = array(
            "mensaje1" => $mensaje1,
            "filas" => $filas,
            "mensaje2" => $mensaje2,
            "enlace" => $enlace
        );
    } else {
        $mensaje = 'NO HAY RESULTADOS';
        $datos = array(
            "mensaje1" => $mensaje,
            "filas" => "",
            "mensaje2" => "",
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
