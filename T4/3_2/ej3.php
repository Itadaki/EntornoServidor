<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 17-nov-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Crea un script que muestre un formulario que permita al usuario
seleccionar una de lastres tiendas Amazon (amazon.com, amazon.ca y amazon.co.uk) 
y luego salte a la tienda en cuestión según la elección del usuario. 
Utiliza la función header().
Ten en cuenta:
- Crea una función que visualice el formulario y una estructura switch 
que redirija a la página seleccionada en el formulario 
(por ejemplo: header( "Location: http://www.amazon.com/" );) y listo.
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
        if (isset($_POST['send'])) {
            header("Location: http://www." . $_POST['tienda'] . "/");
            exit;
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <form method="POST" action="" >
                Escoja su tienda: <select name="tienda">
                    <option>Amazon.com</option>
                    <option>Amazon.ca</option>
                    <option>Amazon.co.uk</option>
                </select><br>
                <input type="submit" value="Visitar tienda" name="send" />
            </form>
            <?php
        }
        ?>
    </body>
</html>
