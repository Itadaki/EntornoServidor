<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 30-oct-2014
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = 
 */

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

/*
  función que muestra el contenido de los campos de texto ya rellenados cuando el formulario se muestra de nuevo por faltar campos obligatorios por rellenar
 */

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

/*
  función que crea un array con los nombres de los campos obligatorios e inicializa un array con los nombre de los campos obligatorios no rellenados.
 */
?>
