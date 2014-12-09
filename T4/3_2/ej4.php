<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 19-nov-2014
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
    </head>
    <body>
        <h1>Adivina el numero</h1>

        <?php
        if (isset($_POST["send"]) and !empty($_POST["respuesta"])) {
            procesarForm();
        } else {
            visualizarForm(5,rand(1, 100));
        }

        function visualizarForm($intentos, $respuesta, $mensaje = '') {
            echo "<br>Tienes $intentos intentos<br>$mensaje<br>";
            ?>
            <form method="POST" action="">
                ¿Que número crees que es? <input type="text" name="respuesta" value="" />
                <input type="submit" value="Enviar" name="send" />
                <input type="hidden" name="solucion" value="<?php echo $respuesta ?>" />
                <input type="hidden" name="intentos" value="<?php echo $intentos ?>" />
            </form>
            <?php
        }
        
        function procesarForm() {
            $respuesta = (int) $_POST["respuesta"];
            $intentos = (int) $_POST["intentos"] - 1;
            $solucion = (int) $_POST["solucion"];
            if ($solucion == $respuesta) {
                visualizarAcierto($respuesta);
            } elseif ($intentos == 0) {
                visualizarFallo($respuesta);
            } elseif ($solucion > $respuesta) {
                visualizarForm($intentos, $respuesta, "Demasiado bajo, prueba de nuevo!");
            } else {
                visualizarForm($intentos, $respuesta, "Demasiado alto, prueba de nuevo!");
            }
        }
        function visualizarAcierto(){
            echo 'Acierto';
        }
        function visualizarFallo(){
            echo 'Fallo';
            
        }
        ?>
    </body>
</html>
