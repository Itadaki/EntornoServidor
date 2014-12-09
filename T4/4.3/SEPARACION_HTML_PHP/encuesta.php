<?php

include("relleno_campos.php");
include("constantes.php");
if (isset($_POST["enviar"])) {
// El formulario se ha ejecutado, así que trabajamos con sus datos
    verifForm();
} else {
//No se ha ejecutado el formulario, así que ejecutamos la función que lo crea
    displayForm(array());
}

//función que remarca en rojo los campos obligatorios no rellenados
function validateField($nombreCampo, $camposPendientes) {
    if (in_array($nombreCampo, $camposPendientes)) {
        return ' class="error"';
    }
}

function verifForm() {
    $camposObligatorios = array("nombreUsuario", "apellidos",);
    $camposPendientes = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio] or ! preg_match("/^[a-zA-Z][a-zA-Z ]+$/", $_POST[$campoObligatorio])) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if ($camposPendientes) {
        displayForm($camposPendientes);
    } else {
        procesForm();
    }
}

function procesForm() {
    $userName = $_POST["nombreUsuario"];
    $apellidos = $_POST["apellidos"];
    $tipoMusica = "";
    $tipoLibros = "";
    if (isset($_POST["tipoMusica"])) {
        foreach ($_POST["tipoMusica"] as $musica) {
            $tipoMusica.= $musica . ", ";
        }
    }
    if (isset($_POST["tipoLibros"])) {
        foreach ($_POST["tipoLibros"] as $libro) {
            $tipoLibros.= $libro . ", ";
        }
    }
// preg.replace() sustituye la coma y el espacio en blanco al final (“/, $/”) por nada (“”)
    $tipoMusica = preg_replace("/, $/", "", $tipoMusica);
    $tipoLibros = preg_replace("/, $/", "", $tipoLibros);
    $datos = array(
        "userName" => $userName,
        "apellidos" => $apellidos,
        "tipoMusica" => $tipoMusica,
        "tipoLibros" => $tipoLibros);
    $file = 'plantillas/plantilla.html';
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    $html = str_replace('{formulario}', '', $html);
    $salida = 'plantillas/salida.html';
    $salida = file_get_contents($salida);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $salida = str_replace($cadena, $dato, $salida);
    }
    $html = str_replace('{datos}', $salida, $html);
    print ($html);
}

function displayForm($camposPendientes) {
    if ($camposPendientes) {
        $error = '<p class="error">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete correctamente los campos remarcados de abajo y haga clic en Enviar para volver a enviar el formulario.</p>';
    } else {
        $error = '<p>por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $resultados = array(
        "error" => $error,
        "scriptUrl" => "encuesta.php",
        "validacionNombreUsuario" => validateField("nombreUsuario", $camposPendientes),
        "valorNombreUsuario" => setValue("nombreUsuario"),
        "validacionApellidos" => validateField("apellidos", $camposPendientes),
        "valorApellidos" => setValue("apellidos"),
        "tipoMusica" => array(
// cuidado porque los valores (Rock, Pop, Novela Negra, etc. deben coincidir con los valores de value en el formulario
            "Rock" => setSelected("tipoMusica", "Rock"),
            "Pop" => setSelected("tipoMusica", "Pop"),
            "Regee" => setSelected("tipoMusica", "Regee"),
            "Clasica" => setSelected("tipoMusica", "Clasica")
        ),
        "tipoLibros" => array(
            "novelaNegra" => setChecked("tipoLibros", "Novela Negra"),
            "cienciaFiccion" => setChecked("tipoLibros", "Ciencia Ficcion"),
            "fantasia" => setChecked("tipoLibros", "Fantasia")
        )
    );
    $file = 'plantillas/plantilla.html';
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    $formulario = 'plantillas/encuesta_form.html';
    $formulario = file_get_contents($formulario);
    foreach ($resultados as $key1 => $valor1)
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $formulario = str_replace($cadena, $valor2, $formulario);
            }
        } else {
            $cadena = '{' . $key1 . '}';
            $formulario = str_replace($cadena, $valor1, $formulario);
        }
    $html = str_replace('{formulario}', $formulario, $html);
    $html = str_replace('{datos}', '', $html);
    print ($html);
}
