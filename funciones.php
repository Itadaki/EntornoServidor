<?php

/*
 * Copyright (C) 2014 Diego Rodríguez Suárez-Bustillo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 
  si existe la variable, echo al valor
 */
function formSetValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        echo $_POST[$nombreCampo];
    }
}

/*
  función que muestra el contenido de los campos de casilla de verificación ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function formSetChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                echo 'checked="checked"';
            }
        }
    }
}

function formSetRadioChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo]) && $_POST[$nombreCampo] == $valorCampo) {
        echo 'checked="checked"';
    }
}

/*
  función que muestra el contenido de los campos de lista de multiselección ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function formSetSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                echo 'selected="selected"';
            }
        }
    }
}

/*
  función que muestra el contenido de los campos de lista de multiselección ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

function formSetSingleSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo]) && $_POST[$nombreCampo] == $valorCampo) {
        echo 'selected="selected"';
    }
}

/*
  función que evalua si el campo esta rellenado
 */

function formValidateField($nombreCampo, $camposPendientes) {
    if (in_array($nombreCampo, $camposPendientes)) {
        echo 'class="error"';
    }
}
function formValidateField2($nombreCampo, $camposPendientes, $camposErroneos) {
    if (in_array($nombreCampo, $camposPendientes) || in_array($nombreCampo, $camposErroneos)) {
        echo 'class="error"';
    }
}

/* * **** */

function setValue2($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                echo $valorC;
            }
        }
    }
}

function setChecked2($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        foreach ($_POST[$nombreCampo] as $valorC) {
            if ($valorC == $valorCampo) {
                echo ' checked="checked"';
            }
        }
    }
}
