<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 29-oct-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Crea una aplicación que visualice un el siguiente formulario y 
después visualice los resultados. Ten en cuenta que el único campo obligatorio 
de rellenar es edad y que si este no se rellena adecuadamente 
(de uno a tres dígitos), el formulario debe visualizarse de nuevo con un mensaje
aclaratorio y el resto de los campos deben aparecer con el contenido previamente
rellenado.
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

        if (filter_has_var(INPUT_POST, 'enviar')) {
            procesarDatos();
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <form method="POST" action="">
                Edad * <input type="text" name="edad" value="<?php if (!filter_has_var(INPUT_POST, 'enviar')){echo'0';} formSetValue('edad') ?>" size="2" /><br>
                ¿Asistes a algunos de estos espectaculos durante el año? <br>
                <select name="espectaculos[]" size="4" multiple="multiple">
                    <option <?php if (!filter_has_var(INPUT_POST, 'enviar')){echo'selected';} formSetSelected('espectaculos', 'Teatro') ?>>Teatro</option>
                    <option <?php formSetSelected('espectaculos', 'Cine') ?>>Cine</option>
                    <option <?php formSetSelected('espectaculos', 'Futbol') ?>>Futbol</option>
                    <option <?php formSetSelected('espectaculos', 'Conciertos') ?>>Conciertos</option>
                    <option <?php  formSetSelected('espectaculos', 'Algo mas') ?>>Algo mas</option>
                </select><br>
                ¿Que tipo de restaurante prefieres?<br>
                Americano <input type="checkbox" name="restaurantes[]" value="Americano" <?php formSetChecked('restaurantes', 'Americano') ?>/><br>
                Japones <input type="checkbox" name="restaurantes[]" value="Japones" <?php formSetChecked('restaurantes', 'Japones') ?> /><br>
                Chino <input type="checkbox" name="restaurantes[]" value="Chino" <?php formSetChecked('restaurantes', 'Chino') ?> /><br>
                Italiano <input type="checkbox" name="restaurantes[]" value="Italiano" <?php formSetChecked('restaurantes', 'Italiano') ?> /><br>
                <br><input type="submit" value="Enviar encuesta" name="enviar" />
            </form>
            <?php
        }

        function displayData() {
            echo 'Edad: ' . $_POST['edad'].'<br>';
            echo 'Durante el año asistes a los siguientes espectaculos:<br>';
            foreach ($_POST['espectaculos'] as $v) {
                echo '<dd>'.$v . '</dd>';
            }
            echo 'Y prefieres los siguientes tipos de restaurantes:';
            foreach ($_POST['restaurantes'] as $v) {
                echo '<dd>'.$v . '</dd>';
            }
        }

        function errorCampo($nombre_error) {
            echo "<p class='error'>Por favor, rellene el campo $nombre_error correctamente</p>";
        }

        function procesarDatos() {
            //Declaracion de variables
            //nombre, calle, numero, puerta, localidad, enviar_datos
            foreach ($_POST as $key => $value) {
                $$key = $value;
            }
            $error = false;

            //Entre 1 y 2 numeros
            $pattern_2numeros = "/^[0-9]{1,2}$/";

            if (!preg_match($pattern_2numeros, $edad)) {
                $error = true;
                errorCampo('Edad');
            }
            //Errores
            if ($error) {
                displayForm();
            } else {
                displayData();
            }
        }
        ?>
    </body>
</html>
