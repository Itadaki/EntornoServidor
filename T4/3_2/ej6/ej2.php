<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 30-oct-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Modifica el script que realizaste para el siguiente formularioconsigue que los elementos del formulario nombre y password se hayan com 
y pletado y que cuando vuelva a visualizarse el formulario 
(con los campos no rellenados marcados en rojo), todos lo que hayas 
seleccionado o rellenado se mantenga. El color verde debe estar preseleccionado
(pero no debe preseleccionarse en una segunda visualización del formulario).
Ten en cuenta que la función de rellenado y los botones de radio y de lista 
de opciones no puede ser la misma pues el en primer caso sólo se elige una 
opción y en el segundo se pueden elegir varias. 
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
        include_once '../../../funciones.php';
        if (isset($_POST['enviar'])) {
            verificar();
        } else {
            displayForm(array());
        }

        function displayForm($pendientes) {
            if ($pendientes) {
                echo '<p class="error">Hubo algunos problemas con el formulario que usted presentó. Por favor, complete correctamente los campos remarcados de abajo y haga clic en Enviar para volver a enviar el formulario.</p>';
            } else {
                echo '<p>Por favor, rellene sus datos a continuación y haga clic en Enviar. Los campos marcados con un asterisco (*) son obligatorios.</p>';
            }
            ?>
            <form method="POST" action="">
                <h1>Cuestionario</h1>
                <span <?php formValidateField('nombre', $pendientes) ?>>Escribe tu nombre *</span>
                <input type="text" name="nombre" value="Diego" /><br>
                <span <?php formValidateField('pass', $pendientes) ?>>Escribe tu clave *</span>
                <input type="password" name="pass" value="psswd" /><br>
                Elige tu color de coche favorito<br>
                <input type="radio" name="color" value="Rojo" />Rojo<br>
                <input type="radio" name="color" value="Verde" checked />Verde<br>
                <input type="radio" name="color" value="Azul" />Azul<br>
                Elige los extras<br>
                <input type="checkbox" name="aa" value="true" />Aire Acondicionado<br>
                <input type="checkbox" name="piel" value="true" checked/>Tapicería de piel<br>
                <input type="checkbox" name="aluminio" value="true" />Llantas de aluminio<br>
                ¿Cual es el precio máximo<br>que estas dispuesto a pagar?<br>
                <select name="precio">
                    <option>Menos de 6.000 euros</option>
                    <option>6.001 - 8.000 euros</option>
                    <option selected>8.001 - 10.000 euros</option>
                    <option>10.001 - 12.000 euros</option>
                    <option>12.001 - 14.000 euros</option>
                    <option>Más de 14.000 euros</option>
                </select><br>
                Comentarios:<br>
                <textarea name="comentarios" rows="4" cols="20">O Ferrari o nada</textarea><br>

                <input type="submit" value="Enviar" name="enviar"/>
                <input type="reset" value="Borrar" />
            </form>
            <?php
        }

        function verificar() {
            $obligatorios = array("nombre", "pass");
            $pendientes = array();
            foreach ($obligatorios as $campo) {
                if (!isset($_POST[$campo]) or ! $_POST[$campo] or ! preg_match("/^[a-zA-Z][a-zA-Z ]+$/", $_POST[$campo])) {
                    $pendientes[] = $campo;
                }
            }
            if ($pendientes) {
                displayForm($pendientes);
            } else {
                procesForm();
            }
        }

        function procesForm() {
            $nombre = $_POST['nombre'];
            $pass = $_POST['pass'];
            $color = $_POST['color'];
            $precio = $_POST['precio'];
            $comentarios = $_POST['comentarios'];
            $extras = "";

            if (isset($_POST['aa'])) {
                $extras .= 'Aire Acondicionado<br>';
            }
            if (isset($_POST['piel'])) {
                $extras .= 'Tapiceria de piel<br>';
            }
            if (isset($_POST['aluminio'])) {
                $extras .= 'Llantas de aluminio';
            }

            echo "<dt>Nombre:</dt><dd>$nombre</dd><br>";
            echo "<dt>Clave:</dt><dd>$pass</dd><br>";
            echo "<dt>Color:</dt><dd>$color</dd><br>";
            echo "<dt>Extras:</dt><dd>$extras</dd><br>";
            echo "<dt>Precio:</dt><dd>$precio</dd><br>";
            echo "<dt>Comentarios:</dt><dd>$comentarios</dd>";
        }
        ?>
    </body>
</html>
