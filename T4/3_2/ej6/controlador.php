<?php

include("funciones.php");
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
    $camposObligatorios = array("nombre", "clave");
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
    //Procesa los datos entrantes
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $color = $_POST['color'][0];
    $precio = $_POST['precio'][0];
    $comentarios = $_POST['comentarios'];
    $extras = "";
    foreach ($_POST['extras'] as $value) {
        $extras .=' ' . $value;
    }
    //Rellena el array que tiene los datos de la sustitucion
    $datos = array(
        "nombre" => $nombre,
        "clave" => $clave,
        "color" => $color,
        "extras" => $extras,
        "precio" => $precio,
        "comentarios" => $comentarios);
    //Abre la plantilla html
    $file = 'plantillas/plantilla.html';
    $html = file_get_contents($file);
    //Rellena las variables
    $html = str_replace('{titulo}', TITULO, $html);
    //Rellena el formulario VACIO {formulario} => ''
    $html = str_replace('{formulario}', '', $html);
    //Abre la plantilla de salida
    $salida = 'plantillas/salida.html';
    $salida = file_get_contents($salida);
    //Sustituye las {etiquetas} por sus valores
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $salida = str_replace($cadena, $dato, $salida);
    }
    //Rellena los datos en la plantilla html {datos} => salida.html
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
        "scriptUrl" => "controlador.php",
        "validacionNombre" => validateField("nombre", $camposPendientes),
        "valorNombre" => setValue("nombre"),
        "validacionClave" => validateField("clave", $camposPendientes),
        "color" => array(
            "Rojo" => setSelected("color", "Rojo"),
            "Verde" => setSelected("color", "Verde"),
            "Azul" => setSelected("color", "Azul")
        ),
        "precio" => array(
            "menos" => setSelected("extras", "menos"),
            "8000" => setSelected("extras", "8000"),
            "10000" => setSelected("extras", "10000"),
            "12000" => setSelected("extras", "12000"),
            "14000" => setSelected("extras", "14000"),
            "mas" => setSelected("extras", "mas")
        ),
        "color" => array(
            "Rojo" => setChecked("color", "Rojo"),
            "Verde" => setChecked("color", "Verde"),
            "Azul" => setChecked("color", "Azul")
        ),
        "valorComentarios" => setValue("comentarios")
    );
    //Coje la plantilla html
    $file = 'plantillas/plantilla.html';
    $html = file_get_contents($file);
    //Posiciona las constantes
    $html = str_replace('{titulo}', TITULO, $html);
    //Coje la plantilla del formulario
    $formulario = 'plantillas/formulario.html';
    $formulario = file_get_contents($formulario);
    //Sustituye en la plantilla las {etiquetas} por los valores
    foreach ($resultados as $key1 => $valor1)
    //Si es un array, es decir count>1
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}"; // => {etiqueta valor}
                $formulario = str_replace($cadena, $valor2, $formulario);
            }
        }
        //Si es un valor suelto
        else {
            $cadena = '{' . $key1 . '}'; // => {etiqueta}
            $formulario = str_replace($cadena, $valor1, $formulario);
        }
    //Reemplaza en la plantilla html todo el formulario
    $html = str_replace('{formulario}', $formulario, $html);
    //Remplaza en la plantilla html los datos por VACIO
    $html = str_replace('{datos}', '', $html);
    print ($html);
}
