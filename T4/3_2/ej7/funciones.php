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
function setValue2($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC){
            if ($valorC == $valorCampo){
                return $valorC;
            }
        }
    }
}

/*
  función que muestra el contenido de los campos de casilla de verificación ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function setChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                return ' checked="checked"';
            }
        }
    }
}

/*
  función que muestra el contenido de los campos de lista de multiselección ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function setSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                return ' selected="selected"';
            }
        }
    }
}

/*
  función que crea un array con los nombres de los campos obligatorios e inicializa un array con los nombre de los campos obligatorios no rellenados.
 */
?>
