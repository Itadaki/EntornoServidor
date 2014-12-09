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

include("cabecera.php");
include("relleno_campos.php");
include("formulario.php");
include("pie.php");
if (isset($_POST["enviar"])) {
    // El formulario se ha ejecutado, así que trabajamos con sus datos
    veriForm();
} else {
//No se ha ejecutado el formulario, así que ejecutamos la función que lo crea
    displayForm(array());
}

//función que remarca en rojo los campos obligatorios no rellenados
function validateField($nombreCampo, $campospendientes) {
    if (in_array($nombreCampo, $campospendientes)) {
        echo ' class="error"';
    }
}

function veriForm() {
    $camposObligatorios = array("nombreUsuario", "apellidos",);
    $campospendientes = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio] or ! preg_match("/^[a-zA-Z][a-zA-Z ]+$/", $_POST[$campoObligatorio])) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if ($campospendientes) {
        displayForm($campospendientes);
    } else {
        procesForm();
    }
}

function procesForm() {
    $userName = $_POST["nombreUsuario"];
    $apellidos = $_POST["apellidos"];
    $tipoMusica = "";
    $tipoLibros = "";
    if (isset($_POST["tipoMusica"])) {
        foreach ($_POST["tipoMusica"] as $musica) {
            $tipoMusica.= $musica . ", ";
        }
    }
    if (isset($_POST["tipoLibros"])) {
        foreach ($_POST["tipoLibros"] as $libro) {
            $tipoLibros.= $libro . ", ";
        }
    }
// preg.replace() sustituye la coma y el espacio en blanco al final (“/, $/”) por nada (“”)
    $tipoMusica = preg_replace("/, $/", "", $tipoMusica);
    $tipoLibros = preg_replace("/, $/", "", $tipoLibros);
    print "<h2>Hola, $userName $apellidos!</h2> \n";
    ?><dl>
    </dd>
    <dt>Te gusta escuchar esta música:</dt><dd>
        <?php
        if (isset($_POST["tipoMusica"])) {
            echo $tipoMusica;
        }
        ?></dd>
    <dt>Y te gusta este tipo de literatura:</dt><dd>
        <?php
        if (isset($_POST["tipoLibros"])) {
            echo $tipoLibros;
        }
        ?></dd>
    </dl>
<?php
}

pie();
?>