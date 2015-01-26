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


function displayPaso1($campospendientes=array()) {
    if (isset($_POST["nombre"]))
        $_SESSION["nombre"] = $_POST["nombre"]; // para recuperar valor si no se rellena uno los campos
    if (isset($_POST["apellidos"]))
        $_SESSION["apellidos"] = $_POST["apellidos"]; // para recuperar valor si no se rellena uno los campos
    if (isset($_POST["genero"]))
        $_SESSION["genero"] = $_POST["genero"]; //necesario, si pulsa BACK sin rellenar genero da error
    if (isset($_POST["juegoFavorito"]))
        $_SESSION["juegoFavorito"] = $_POST["juegoFavorito"];
    
    if (isset($_POST["genero"]))
        $_SESSION["genero"] = $_POST["genero"];
    if (isset($_POST["genero"]))
        $_SESSION["juego"] = $_POST["juego"];
    
    if ($campospendientes) {
        $mensaje = '<p class="error">Hubo algunos problemas con el formulario que usted presentó.
Por favor, complete los campos en negrita de abajo y haga clic en Enviar
para volver a enviar el formulario.</p>';
    } else {
        $mensaje = '<p>por favor, rellene sus datos a continuación y haga clic en Enviar.
Los campos marcados con un asterisco (*) son obligatorios.</p>';
    }
    $datos = array(
        "validacionNombre" => validateField("nombre", $campospendientes),
        "validacionApellidos" => validateField("apellidos", $campospendientes),
        "nombre" => setValue("nombre"),
        "apellidos" => setValue("apellidos"),
        "mensaje" => $mensaje
    );
    $plantilla = "plantillas/formulario1.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function displayPaso2(){
    if (isset($_POST["nombre"]))
        $_SESSION["nombre"] = $_POST["nombre"]; // para recuperar valor si no se rellena uno los campos
    if (isset($_POST["apellidos"]))
        $_SESSION["apellidos"] = $_POST["apellidos"]; // para recuperar valor si no se rellena uno los campos
    
    if (isset($_POST["genero"]))
        $_SESSION["genero"] = $_POST["genero"]; //necesario, si pulsa BACK sin rellenar genero da error
    if (isset($_POST["juegoFavorito"]))
        $_SESSION["juegoFavorito"] = $_POST["juegoFavorito"];
    
    if (isset($_POST["noticias"]))
        $_SESSION["noticias"] = $_POST["noticias"];
    if (isset($_POST["comentarios"]))
        $_SESSION["comentarios"] = $_POST["comentarios"];
    
    $datos = array(
        "genero" => array(
          "masculino" => setChecked('genero', 'Masculino'),
          "femenino" => setChecked('genero', 'Femenino')
        ),
        "juego" => array(
            "tute" => setSelected("juego", "Tute").'hola',
            "mus"=>  setSelected("juego", "Mus")
        )
    );
    $plantilla = "plantillas/formulario2.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function displayPaso3(){
    if (isset($_POST["genero"]))
        $_SESSION["genero"] = $_POST["genero"];
    if (isset($_POST["genero"]))
        $_SESSION["juego"] = $_POST["juego"];
    
    if (isset($_POST["genero"]))
        $_SESSION["juego"] = $_POST["juego"];
    
    $datos = array(
        "noticias"=> setChecked('noticias', 'ON'),
        'comentarios'=>  setValue('comentarios')
    );
    $plantilla = "plantillas/formulario3.html";
    $formulario = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $formulario
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function fin(){
    if (isset($_POST["noticias"]))
        $_SESSION["noticias"] = $_POST["noticias"];
    if (isset($_POST["comentarios"]))
        $_SESSION["comentarios"] = $_POST["comentarios"];
    
    echo 'Gracias por tu solicitud, ' . $_SESSION['nombre']. ' ' . $_SESSION['apellidos'];
}

function setValue($nombreCampo) {
    if (isset($_SESSION[$nombreCampo])) {
        return $_SESSION[$nombreCampo];
    }
}

function setChecked($nombreCampo, $valorCampo) {
    if (isset($_SESSION[$nombreCampo]) and $_SESSION[$nombreCampo] == $valorCampo) {
        return ' checked="checked"';
    }
}

function setSelected($nombreCampo, $valorCampo) {
    if (isset($_SESSION[$nombreCampo]) and $_SESSION[$nombreCampo] == $valorCampo) {
        return ' selected="selected"';
    }
}

function validateField($nombreCampo, $camposPendientes) {
    if (in_array($nombreCampo, $camposPendientes)) {
        echo 'class="error"';
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