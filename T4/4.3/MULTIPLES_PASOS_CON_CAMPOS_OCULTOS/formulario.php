<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 03-nov-2014
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
        <?php
        include_once '../../../funciones.php';
        
        if (isset($_POST['toStep1'])){
            paso1();
        } else if (isset($_POST['toStep2'])){
            paso2();
        } else if (isset($_POST['toStep3'])) {
            paso3();
        } else if (isset($_POST['toEnd'])) {
            fin();
        } else {
            paso1();
        }
        
        function paso1(){
            echo '<h1>Formulario por pasos: paso 1</h1>';
            echo '<form method="POST" action="">';
            echo 'Nombre <input type="text" name="nombre" value="'.formSetValue('nombre').'" />';
            echo '<input type="hidden" name="publico" value="'.formSetValue('publico').'" />';
            echo '<input type="hidden" name="comentarios" value="'.formSetValue('comentarios').'" />';
            echo '<input type="submit" value="Next >" name="toStep2" />';
            echo '</form>';
        }
        function paso2(){
            echo '<h1>Formulario por pasos: paso 2</h1>';
            echo '<form method="POST" action="">';
            echo 'Utilizas el transporte publico?<br>';
            echo 'Si <input type="radio" name="publico" value="si" '.  formSetSingleSelected('publico', 'si').'/>';
            echo 'No <input type="radio" name="publico" value="no" '.  formSetSingleSelected('publico', 'no').'/>';
            echo '<input type="hidden" name="nombre" value="'.formSetValue('nombre').'" />';
            echo '<input type="hidden" name="comentarios" value="'.formSetValue('comentarios').'" />';
            echo '<input type="submit" value="< Back" name="toStep1" /> ';
            echo '<input type="submit" value="Next >" name="toStep3" />';
            echo '</form>';
        }
        function paso3(){
            echo '<h1>Formulario por pasos: paso 3</h1>';
             echo '<form method="POST" action="">';
            echo 'Algun comentario?<br>';
            echo '<textarea name="comentario" rows="4" cols="20">'.  formSetValue('comentario').'</textarea>';
            echo 'No <input type="radio" name="publico" value="no" '.  formSetSelected('publico', 'si').'/>';
            echo '<input type="hidden" name="nombre" value="'.formSetValue('nombre').'" />';
            echo '<input type="hidden" name="publico" value="'.formSetValue('publico').'" />';
            echo '<input type="submit" value="< Back" name="toStep2" />';
            echo '<input type="submit" value="Next >" name="toEnd" />';
            echo '</form>';
        }
        function fin(){
            echo 'fin';
        }
        ?>
    </body>
</html>
