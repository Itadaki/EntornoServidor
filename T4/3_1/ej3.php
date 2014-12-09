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
        if (isset($_POST['aPaso2'])){
            paso2();
        } else if (isset($_POST['aPaso3'])){
            paso3();
        } else if (isset($_POST['aPaso1'])){
            paso1();
        } else if (isset($_POST['aFin'])){
            fin();
        } else {
            paso1();
        }

        function paso1() {
            ?>
            <form method="POST" action="">
                Nombre <input type="text" name="nombre" value="<?php formSetValue('nombre') ?>" /> 
                Apellidos <input type="text" name="apellidos" value="<?php formSetValue('apellidos') ?>" /><br>
                <input type="hidden" name="genero" value="<?php formSetValue('genero') ?>" />
                <input type="hidden" name="juego" value="<?php formSetValue('juego') ?>" />
                <input type="hidden" name="noticias" value="<?php if (isset($_POST['noticias']) && $_POST['noticias'] == 'ON'){echo 'ON';} ?>" />
                <input type="hidden" name="comentarios" value="<?php formSetValue('comentarios') ?>" />
                <input type="submit" value="Next >" name="aPaso2" />
            </form>
            <?php
        }

        function paso2() {
            ?>
            <form method="POST" action="">
                Género: Masculino <input type="radio" name="genero" value="Masculino" <?php formSetRadioChecked('genero', 'Masculino') ?>/> 
                Femenino <input type="radio" name="genero" value="Femenino" <?php formSetRadioChecked('genero', 'Femenino') ?>/> <br>
                Juego preferido <select name="juego">
                    <option  <?php formSetSingleSelected('juego', 'Tute') ?>>Tute</option>
                    <option <?php formSetSingleSelected('juego', 'Mus') ?>>Mus</option>
                </select><br>
                <input type="hidden" name="nombre" value="<?php formSetValue('nombre') ?>" />
                <input type="hidden" name="apellidos" value="<?php formSetValue('apellidos') ?>" />
                <input type="hidden" name="noticias" value="<?php if (isset($_POST['noticias']) && $_POST['noticias'] == 'ON'){echo 'ON';} ?>" />
                <input type="hidden" name="comentarios" value="<?php formSetValue('comentarios') ?>" />
                <input type="submit" value="< Back" name="aPaso1" />
                <input type="submit" value="Next >" name="aPaso3" />
            </form>
            <?php
        }

        function paso3() {
            ?>
            <form method="POST" action="">
                Recibir noticias del juego: <input type="checkbox" name="noticias" value="ON" <?php if (isset($_POST['noticias']) && $_POST['noticias'] == 'ON'){echo 'checked="checked"';} ?>/><br>
                Comentarios:<br>
                <textarea name="comentarios" rows="4" cols="20"><?php formSetValue('comentarios') ?></textarea><br>
                <input type="hidden" name="genero" value="<?php formSetValue('genero') ?>" />
                <input type="hidden" name="juego" value="<?php formSetValue('juego') ?>" />
                <input type="hidden" name="nombre" value="<?php formSetValue('nombre') ?>" />
                <input type="hidden" name="apellidos" value="<?php formSetValue('apellidos') ?>" />
                <input type="submit" value="< Back" name="aPaso2" />
                <input type="submit" value="Next >" name="aFin" />
            </form>
            <?php
        }

        function fin() {
            echo 'Gracias por tu solicitud, ' . $_POST['nombre'];
        }
        ?>
    </body>
</html>
