<?php

// esta funciones ahora tienen que retornar valor con return no un echo.
/*
  función que muestra el contenido de los campos de texto ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */
function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

/*
  función que crea un array con los nombres de los campos obligatorios e inicializa un array con los nombre de los campos obligatorios no rellenados.
 */
function validateField($nombreCampo, $camposPendientes, $camposMal) {
    if (in_array($nombreCampo, $camposPendientes)) {
        return ' class="error"';
    }
    if (in_array($nombreCampo, $camposMal)) {
        return ' class="error_formato"';
    }
}

/*
  función que rellena las plantillas
 */
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
?>
