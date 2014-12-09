<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 05-nov-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Crea un script para visualizar un formulario por pasos como el siguiente, 
de forma que la información introducida se mantenga cuando avanzamos o retrocedemos:
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
    </head>
    <body>
        <?php
        include_once '../../funciones.php';
        if (isset($_POST['aPaso2'])) {
            paso2();
        } else if (isset($_POST['aPaso1'])) {
            paso1();
        } else if (isset($_POST['aFin'])) {
            fin();
        } else {
            paso1();
        }

        function paso1() {
            ?>
            <form method="POST" action="">
                Nombre <input type="text" name="nombre" value="<?php formSetValue('nombre') ?>" /> 
                Email <input type="email" name="email" value="<?php formSetValue('email') ?>" /><br>
                Recibir informacion deportiva: 
                Si<input type="radio" name="info" value="si" <?php formSetRadioChecked('info', 'si') ?>/> 
                No <input type="radio" name="info" value="no" <?php formSetRadioChecked('info', 'no') ?>/><br>
                A que te dedicas <select name="ocupacion">
                    <option <?php formSetSingleSelected('ocupacion', 'Estudiante') ?>>Estudiante</option>
                    <option <?php formSetSingleSelected('ocupacion', 'Trabajador') ?>>Trabajador</option>
                </select><br>
                <?php
                $deportes = array('Futbol', 'Tenis', 'Padel', 'Baloncesto', 'Esqui', 'Natacion', 'Senderismo', 'Ciclismo', 'Atletismo');
                foreach ($deportes as $valor) {
                    ?>
                    <input type='hidden' name='interes[]' value="<?php setValue2("interes", $valor); ?>"/>
                    <?php
                }
                ?>
                <input type="submit" value="Next >" name="aPaso2" />
            </form>
            <?php
        }

        function paso2() {
            ?>
            <form method="POST" action="">
                Indica los deportes que te interesan<br>
                Futbol <input type="checkbox" name="interes[]" value="Futbol" <?php formSetChecked('interes', 'Futbol') ?> /> 
                Tenis <input type="checkbox" name="interes[]" value="Tenis" <?php formSetChecked('interes', 'Tenis') ?> /> 
                Padel <input type="checkbox" name="interes[]" value="Padel" <?php formSetChecked('interes', 'Padel') ?> /><br>
                Baloncesto <input type="checkbox" name="interes[]" value="Baloncesto" <?php formSetChecked('interes', 'Baloncesto') ?> /> 
                Esqui <input type="checkbox" name="interes[]" value="Esqui" <?php formSetChecked('interes', 'Esqui') ?> />
                Natacion <input type="checkbox" name="interes[]" value="Natacion" <?php formSetChecked('interes', 'Natacion') ?> /><br>
                Senderismo <input type="checkbox" name="interes[]" value="Senderismo" <?php formSetChecked('interes', 'Senderismo') ?> /> 
                Ciclismo <input type="checkbox" name="interes[]" value="Ciclismo" <?php formSetChecked('interes', 'Ciclismo') ?> /> 
                Atletismo <input type="checkbox" name="interes[]" value="Atletismo" <?php formSetChecked('interes', 'Atletismo') ?> /><br>

                <input type="hidden" name="nombre" value="<?php formSetValue('nombre') ?>" />
                <input type="hidden" name="email" value="<?php formSetValue('email') ?>" />
                <input type="hidden" name="info" value="<?php formSetValue('info') ?>" />
                <input type="hidden" name="ocupacion" value="<?php formSetValue('ocupacion') ?>" />
                <input type="submit" value="< Back" name="aPaso1" />
                <input type="submit" value="Next >" name="aFin" />
            </form>
            <?php
        }

        function fin() {
            echo 'Gracias por tu solicitud, ' . $_POST['nombre'] . '<br>';
            foreach ($_POST['interes'] as $value) {
                echo $value . ' ';
            }
        }

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
        ?>
    </body>
</html>
