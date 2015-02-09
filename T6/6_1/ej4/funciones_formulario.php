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

function displayForm($camposPendientes = array(), $camposErroneos = array()) {
    $mensaje = '';
    if ($camposErroneos) {
        $mensaje.='<p class="error">Error: has introducido valores erroneos</p>';
    }
    if ($camposPendientes) {
        $mensaje.='<p class="errorVacio">Hay campos obligatorios sin rellenar</p>';
    }

    $datos = array(
        "validacionNombre" => validateField('nombre', $camposPendientes, $camposErroneos),
        "valorNombre" => setValue('nombre'),
        "valorEdad" => setValue('edad'),
        "sistema" => array(
            "windows" => setSelected('sistema', 'windows'),
            "mac" => setSelected('sistema', 'mac'),
            "linux" => setSelected('sistema', 'linux')
        ),
        "futbol" => setChecked('futbol'),
        "sexo" => array(
            "hombre" => setRadioChecked('sexo', 'hombre'),
            "mujer" => setRadioChecked('sexo', 'mujer')
        ),
        "valorAficiones" => setValue('aficiones')
    );
    $plantilla = 'plantillas/formulario.html';
    $formulario = respuesta($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "titulo" => TITULO,
        "error" => $mensaje,
        "formulario" => $formulario
    );
    $html = respuesta($datos, $plantilla);
    print($html);
}

function veriForm() {
    $camposObligatorios = ['nombre'];
    $camposPendientes = array();
    $camposErroneos = array();

    foreach ($camposObligatorios as $campoObligatorio) {
        //Evalua ($edad) como false si $edad='0' -> Entonces sale como no rellenado
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"])) {
        if (!preg_match('/^[A-Za-z][A-Za-z ]+$/', $_POST["nombre"])) {
            if (!in_array("nombre", $camposPendientes)) {
                $camposErroneos[] = 'nombre';
            }
        }
    }

    if ($camposErroneos || $camposPendientes) {
        displayForm($camposPendientes, $camposErroneos);
    } else {
        procesform();
    }
}

function procesForm() {
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $sistema = $_POST['sistema'];
    $aficiones = $_POST['aficiones'];
    if ($_POST['edad'] == '') {
        $edad = "NULL";
    } else {
        $edad = (int) $_POST['edad'];
    }
    if (!isset($_POST['futbol'])) { // Si no se marcó la casilla fútbol...
        $futbol = "N";
    } else {
        $futbol = "S";
    }
    $sql_insertar = "INSERT INTO " . TABLA .
            "(nombre,sexo,edad,sistema,aficiones,futbol)" .
            " VALUES('$nombre', '$sexo', $edad, '$sistema', '$aficiones', '$futbol')";
    
    if ($conexion = conexion()) {
        $mensajeInsertar = insertar($conexion, $sql_insertar);
        $mensajeCerrarConexion = cerrarConexion($conexion);
        displayGracias($mensajeInsertar, $mensajeCerrarConexion);
    } else {
        echo 'error';
    }
}

function displayGracias($mensajeInsertar, $mensajeCerrarConexion) {
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $sistema = $_POST['sistema'];
    $aficiones = $_POST['aficiones'];
    if ($_POST['edad'] == '') {
        $edad = "0";
    } else {
        $edad = (int) $_POST['edad'];
    }
    if (!isset($_POST['futbol'])) { // Si no se marcó la casilla fútbol...
        $futbol = "No te";
    } else {
        $futbol = "Te";
    }

    $datos = array(
        "nombre" => $nombre,
        "sexo" => $sexo,
        "edad" => $edad,
        "sistema" => $sistema,
        "futbol" => $futbol,
        "aficiones" => $aficiones,
        "mensajeInsercion" => $mensajeInsertar,
        "mensajeCierre" => $mensajeCerrarConexion
    );

    $plantilla = 'plantillas/gracias.html';
    $gracias = respuesta($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "titulo" => TITULO,
        "error" => '',
        "formulario" => $gracias
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

function setRadioChecked($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        if ($_POST[$nombreCampo] == $valorCampo) {
            return ' checked="checked"';
        }
    }
}
