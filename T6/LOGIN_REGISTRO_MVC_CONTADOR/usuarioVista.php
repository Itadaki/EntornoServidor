<?php

function validateField($campo, $camposPendientes, $camposErroneos, $duplicado = false) {
    if (in_array($campo, $camposPendientes)) {
        return ' class="error_vacio"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error"';
    } elseif ($campo == 'usuario' && $duplicado)
        return ' class="error_duplicado"';
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function displayFormLogin($camposErroneos = array(), $camposPendientes = array()) {
//    $enlace = "<a href='index.php?accion=registro'>Registrarse</a>";
    $error = "";
    if ($camposPendientes || $camposErroneos) {
        if ($camposPendientes) {
            $error.= '<p class="error_vacio">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Login para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error.= '<p class="error">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados en los campos (sólo letras y números y mínimo 5 y máximo 15 caracteres en ambos campos).</p>';
        }
    } else {
        $error.= '<p>Por favor, introduzca su nombre de usuario y password. <br> En ambos casos sólo letras y números; 	mínimo 5 y máximo 15 caracteres en ambos campos.</p>';
    }
    $datos = array(
        "error" => $error,
        "enlace" => "<a href='index.php?registrarse'>Registrarse</a> <a href='index.php?verUsuario=%'>Ver usuarios</a>",
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos),
        "validacionClave" => validateField("clave", $camposPendientes, $camposErroneos),
        "usuario" => setValue("usuario"),
        "clave" => setValue("clave")
    );
    $plantilla = "plantillas/login.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayFormRegistro($camposErroneos = array(), $camposPendientes = array(), $duplicado = false) {
    $error = "";
    if ($camposPendientes || $camposErroneos || $duplicado) {
        if ($camposPendientes) {
            $error.= '<p class="error_vacio">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete los campos en negrita de abajo y haga clic en Registrar para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error.= '<p class="error">Hubo algunos problemas con el formulario que usted presentó. Por favor, introduzca valores adecuados en los campos y pulse Registrar.</p>';
        }
        if ($duplicado) {
            $error.= '<p class="error_duplicado">Hubo algunos problemas con el formulario que usted presentó. El usuario ya existe.</p>';
        }
    } else {
        $error.= '<p>Por favor, rellene el formulario y haga clic en "Registrar". </p>';
    }
    $datos = array(
        "error" => $error,
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos, $duplicado),
        "validacionClave" => validateField("clave", $camposPendientes, $camposErroneos),
        "validacionNombre" => validateField("nombre", $camposPendientes, $camposErroneos),
        "validacionApellidos" => validateField("apellidos", $camposPendientes, $camposErroneos),
        "validacionEmail" => validateField("email", $camposPendientes, $camposErroneos),
        "usuario" => setValue("usuario"),
        "clave" => setValue("clave"),
        "nombre" => setValue("nombre"),
        "apellidos" => setValue("apellidos"),
        "email" => setValue("email"),
        'enlace' => "<a href='index.php'>Volver al inicio</a>"
    );
    $plantilla = "plantillas/registro.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displaySalida() {
    global $mensaje;
    global $enlace;
////    $plantilla = "plantillas/salida.html";
//    $datos = array(
//        "mensaje" => $mensaje,
//        "enlace" => $enlace);
//    $salida = respuesta($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "titulo" => TITULO,
        "formulario" => "<h3>$mensaje</h3>$enlace"
    );
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayError() {
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
