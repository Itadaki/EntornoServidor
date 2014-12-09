<?php

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        echo $_POST[$nombreCampo];
    }
}

/*
  función que muestra el contenido de los campos de casilla de verificación ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function setChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                echo ' checked="checked"';
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
                echo ' selected="selected"';
            }
        }
    }
}

?>