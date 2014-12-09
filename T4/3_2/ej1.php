<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 12-nov-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Crea un formulario que permita introducir un nombre y 
subir hasta tres fotos. Después de enviar el formulario, visualizará 
el nombre y las fotos numerándolas e indicando si ha habido algún tipo 
de error con alguna.
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
        if (isset($_POST["send"])) {
            processForm();
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <form method="POST" action="" enctype="multipart/form-data">
                Nombre <input type="text" name="nombre" value="Diego" /><br>
                Foto nº1: <input type="file" name="foto1" accept="image/gif"/><br>
                Foto nº2: <input type="file" name="foto2" accept="image/gif"/><br>
                Foto nº3: <input type="file" name="foto3" accept="image/gif"/><br>
                <input type="submit" value="Enviar Fotos" name="send" />
            </form><?php
        }

        function processForm() {
            $code = "";
            $i = 1;
            foreach ($_FILES as $file) {
                if ($file["error"] == UPLOAD_ERR_OK &&
                        $file["type"] == "image/gif" &&
                        move_uploaded_file($file["tmp_name"], "fotos/$i.gif")) {
                    $code .= "<p>Esta es su foto número $i:<br><img src='fotos/$i.gif'/></p>";
                } else {
                    $code .= "<p>Lo sentimos, hubo un problema al subir la foto $i</p>";
                }
                $i++;
            }
            echo $code;
        }
        ?>
    </body>
</html>
