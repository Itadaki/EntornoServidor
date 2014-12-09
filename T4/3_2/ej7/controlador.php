<?php

include("funciones.php");
include("constantes.php");
if (isset($_POST["toStep2"])) {
    veriForm();
} else if (isset($_POST["toStep1"])) {
    displaypaso1(array(), $message = "correcto");
} else if (isset($_POST["toEnd"])) {
    procesForm();
} else {
    displaypaso1(array(), $message = "correcto");
}

//función que remarca en rojo los campos obligatorios no rellenados
function validateField($nombreCampo, $camposPendientes) {
    if (in_array($nombreCampo, $camposPendientes)) {
        return ' class="error"';
    }
}

function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1) {
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = "{" . $key1 . "}";
            $html = str_replace($cadena, $valor1, $html);
        }
    }
    return $html;
}

function veriForm() {
    $camposObligatorios = array("nombre", "apellidos", "direccion", "telefono", "email");
    $camposPendientes = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if ($camposPendientes) {
        displayPaso1($camposPendientes);
    } else {
        displayPaso2();
    }
}

function procesForm() {

    $datos = $_POST["nombre"] . ' ' . $_POST["apellidos"] . ' ' . $_POST["direccion"] . ' ' . $_POST["telefono"] . ' ' .
            $_POST["email"];
    $file = 'plantillas/plantilla.html';
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    $html = str_replace('{formulario}', '', $html);
    $salida = 'plantillas/salida.html';
    $salida = file_get_contents($salida);
    $html = str_replace('{datos}', $datos, $salida);
    $html = str_replace('{datos}', $salida, $html);
    print ($html);
}

function displayPaso1($campospendientes) {
    if ($campospendientes) {
        $error = "";
        if ($campospendientes) {
            $error = '<p class="error">Hubo algunos problemas con el formulario que presentaste.
Por favor, completa los campos en negrita de abajo y haz clic en Enviar
para volver a enviar el formulario.</p>';
        }
    } else {
        $error = '<p>por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $ciudades = array('Roma', 'Paris', 'NuevaYork', 'Londres', 'Berlin', 'Atenas');
    $ocultosInfo = "";
    $ocultosCiudades = "";
    foreach ($ciudades as $valor) {
        $valorCampo = setValue2("ciudades", $valor);
        $ocultosCiudades.='<input type="hidden" name="ciudades[]" value="' . $valorCampo . '">';
    }
    $info = array('CorreoPostal', 'Email');
    foreach ($info as $valor) {
        $valorCampo = setValue2("info", $valor);
        $ocultosInfo.='<input type="hidden" name="info[]" value="' . $valorCampo . '">';
    }
    $datos = array(
        "error" => $error,
        "scriptUrl" => "controlador.php",
        "ocultosCiudades" => $ocultosCiudades,
        "ocultosInformacion" => $ocultosInfo,
        "validacionNombre" => validateField("nombre", $campospendientes),
        "valorNombre" => setValue("nombre"),
        "validacionApellidos" => validateField("apellidos", $campospendientes),
        "valorApellidos" => setValue("apellidos"),
        "validacionDireccion" => validateField("direccion", $campospendientes),
        "valorDireccion" => setValue("direccion"),
        "validacionTelefono" => validateField("telefono", $campospendientes),
        "valorTelefono" => setValue("telefono"),
        "valorEmail" => setValue("email"),
        "validacionEmail" => validateField("email", $campospendientes)
    );
    $plantilla = "plantillas/formulario_1.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    $html = str_replace('{datos}', '', $html);
    print ($html);
}

function displayPaso2() {
    $datos = array(
        "valorNombre" => setValue("nombre"),
        "valorApellidos" => setValue("apellidos"),
        "valorDireccion" => setValue("direccion"),
        "valorTelefono" => setValue("telefono"),
        "valorEmail" => setValue("email"),
        "ciudades" => array(
            "Roma" => setSelected("ciudades", "Roma"),
            "Paris" => setSelected("ciudades", "Paris"),
            "NuevaYork" => setSelected("ciudades", "NuevaYork"),
            "Londres" => setSelected("ciudades", "Londres"),
            "Berlin" => setSelected("ciudades", "Berlin"),
            "Atenas" => setSelected("ciudades", "Atenas")
        ),
        "info" => array(
            "CorreoPostal" => setChecked("info", "CorreoPostal"),
            "Email" => setChecked("info", "Email")
        )
    );
    $plantilla = "plantillas/formulario_2.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    $html = str_replace('{datos}', '', $html);
    print ($html);
}
