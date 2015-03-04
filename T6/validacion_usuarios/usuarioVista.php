<?php

function validateField($campo, $camposNoRellenados, $camposErroneos, $duplicado = false) {
    if (in_array($campo, $camposNoRellenados)) {
        return ' class="error1"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error2"';
    } elseif ($campo == 'usuario' && $duplicado)
        return ' class="error3"';
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function displayFormLogin($camposErroneos, $camposPendientes) {
    $enlace = "<a href='index.php?accion=registro'>Registrarse</a>";
    $error = "";
    if ($camposPendientes || $camposErroneos) {
        if ($camposPendientes) {
            $error .= '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Login
para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error .= '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos (sólo letras y números
y mínimo 5 y máximo 15 caracteres en ambos campos).</p>';
        }
    } else {
        $error .= '<p>Por favor, introduzca su nombre de usuario y password. <br> En ambos casos sólo letras y números; mínimo 5 y máximo 15 caracteres en ambos campos.</p>';
    }
    $datos = array(
        "error" => $error,
        "enlace" => $enlace,
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos),
        "usuario" => setValue("usuario"),
        "validacionClave" => validateField("clave", $camposPendientes, $camposErroneos),
        "clave" => setValue("clave")
    );
    $plantilla = "plantillas/formularioLogin.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function displayFormRegistro($camposErroneos, $camposPendientes, $duplicado) {
    $error = "";
    if ($camposPendientes || $camposErroneos || $duplicado) {
        if ($camposPendientes) {
            $error .= '<p class="error1">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Registrar
para volver a enviar el formulario.</p>';
        }
        if ($camposErroneos) {
            $error .= '<p class="error2">Hubo algunos problemas con el formulario que usted presentó.
Por favor, introduzca valores adecuados en los campos y pulse Registrar.</p>';
        }
        if ($duplicado) {
            $error .= '<p class="error3">Hubo algunos problemas con el formulario que usted presentó.
El usuario ya existe.</p>';
        }
    } else {
        $error .= '<p>Por favor, rellene el formulario y haga clic en "Registrar". </p>';
    }
    $datos = array(
        "error1" => $error,
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos, $duplicado),
        "usuario" => setValue("usuario"),
        "validacionClave" => validateField("clave", $camposPendientes, $camposErroneos),
        "clave" => setValue("clave"),
        "validacionNombre" => validateField("nombre", $camposPendientes, $camposErroneos),
        "nombre" => setValue("nombre"),
        "validacionApellidos" => validateField("apellidos", $camposPendientes, $camposErroneos),
        "apellidos" => setValue("apellidos"),
        "validacionEmail" => validateField("email", $camposPendientes, $camposErroneos),
        "email" => setValue("email")
    );
    $plantilla = "plantillas/formularioRegistro.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

function visualizarResultado() {
    global $mensaje;
    global $enlace;
    $plantilla = "plantillas/salida.html";
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
