<?php

/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 06-feb-2015
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = 
 */

/* 
 * Copyright (C) 2015 Diego Rodríguez Suárez-Bustillo
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

function displayForm($camposPendientes = array(), $camposErroneos = array()){
    $mensaje= '';
    if($camposErroneos){
        $mensaje.='<p class="error">Error</p>';
    }
    if ($camposPendientes){
        $mensaje.='<p class="errorVacil">Vacio</p>';
    }
    
    $datos = array(
        "validacionNombre"=>  validateField('nombre', $camposPendientes, $camposErroneos),
        "valorNombre" => setValue('nombre'),
        "valorEdad"=>  setValue('edad'),
        "sistema" => array(
            "windows" => setSelected('sistema', 'windows'),
            "mac" => setSelected('sistema', 'mac'),
            "linux" => setSelected('sistema', 'linux')
        ),
        "futbol" => setChecked('futbol'),
        "sexo" => array(
            "hombre"=>  setSelected('sexo', 'hombre'),
            "mujer"=>  setSelected('sexo', 'mujer')
        ),
        "valorAficiones"=>  setValue('aficiones')
    );
    $plantilla = 'plantillas/formulario.html';
    $formulario = respuesta($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "error" => $mensaje,
        "formulario" => $formulario
    );
    $html = respuesta($datos, $plantilla);
    print($html);
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function validateField($campo, $camposPendientes, $camposErroneos) {
    if (in_array($campo, $camposPendientes)) {
        return ' class="errorVacio"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error"';
    }
}

function setSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        if ($_POST[$nombreCampo] == $valorCampo) {
            return ' selected="selected"';
        }
    }
}

function setChecked($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
                return ' checked="checked"';
    }
}