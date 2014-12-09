<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 21-nov-2014
Licencia = gpl30 
Version = 1.0
Descripcion = 
-->

<!--
Copyright (C) 2014 Diego Rodríguez Suárez-Bustillo

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            .error{
                background-color: red; 
                color: white; 
                padding-left: 5px; 
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php
        include_once '../../funciones.php';
        if (isset($_POST["send"])) {
            veriForm();
        } else {
            displayForm(array(), array());
        }

        function displayForm($campospendientes, $camposerroneos) {
            if (!empty($campospendientes)) {
                echo '<p class="error">Algun campo obligatorio no se relleno</p>';
            }
            if (!empty($camposerroneos)) {
                echo '<p class="error">Algun campo numerico contiene letras</p>';
            }
            ?>
            <form method="POST" action="">
                <span <?php formValidateField2('nombre', $campospendientes, $camposerroneos) ?>>Nombre: </span>
                <input type="text" name="nombre" value="<?php formSetValue('nombre') ?>" /><br>
                <span <?php formValidateField2('edad', $campospendientes, $camposerroneos) ?>>Edad: </span>
                <input type="text" name="edad" value="<?php formSetValue('edad') ?>" /><br>
                <span <?php formValidateField2('precio', $campospendientes, $camposerroneos) ?>>Precio maximo </span>
                <input type="text" name="precio" value="<?php formSetValue('precio') ?>" /><br>
                <span <?php formValidateField2('email', $campospendientes, $camposerroneos) ?>>email: </span>
                <input type="text" name="email" value="<?php formSetValue('email') ?>" /><br>
                <span <?php formValidateField2('telf', $campospendientes, $camposerroneos) ?>>Telf: </span>
                <input type="text" name="telf" value="<?php formSetValue('telf') ?>" /><br>
                <input type="submit" value="Enviar" name="send" />
            </form>
            <?php
        }

        function fin() {

            echo 'nombre ' . $_POST['nombre'] . '<br>';
            echo 'edad ' . $_POST['edad'] . '<br>';
            echo 'precio ' . $_POST['precio'] . '<br>';
            echo 'email ' . $_POST['email'] . '<br>';
            echo 'telf ' . $_POST['telf'] . '<br>';
        }

        function veriForm() {
            $camposNumericos = array("edad", "precio");
            $camposObligatorios = array("nombre");
            $campospendientes = array();
            $camposerroneos = array();
            foreach ($camposNumericos as $camposNumerico) {
                if (isset($_POST[$camposNumerico]) and $_POST[$camposNumerico]) {
                    if (filter_var($_POST[$camposNumerico], FILTER_VALIDATE_INT) == false) {
                        $camposerroneos[] = $camposNumerico;
                    }
                }
            }
            foreach ($camposObligatorios as $campoObligatorio) {
                if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
                    $campospendientes[] = $campoObligatorio;
                }
            }
            if (isset($_POST["email"]) and $_POST["email"]) {
                if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
                    $camposerroneos[] = "email";
                }
            }
            if (isset($_POST["telefono"]) and $_POST["telefono"]) {
                $_POST["telefono"] = filter_var($_POST["telefono"], FILTER_SANITIZE_NUMBER_INT);
            } else {
                $camposerroneos[] = "telefono";
            }

            if (empty($campospendientes) || empty($camposerroneos)) {
                fin();
            } else {
                displayForm($campospendientes, $camposerroneos);
            }
        }
        ?>

    </body>
</html>
