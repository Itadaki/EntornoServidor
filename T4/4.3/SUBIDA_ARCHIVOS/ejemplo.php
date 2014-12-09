<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 12-nov-2014
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
<head>
    <title>Subir una foto</title>
    <meta charset="UTF-8">
</head>
<body>
    <?php
    if (isset($_POST["enviarFoto"])) {
        processForm();
    } else {
        displayForm();
    }

    function processForm() {
        if (isset($_FILES["foto"]) and $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
            if ($_FILES["foto"]["type"] != "image/gif") {
                // con esta línea podríamos trabajar con los dos navegadores:
                // if ($_FILES["foto"]["type"] != "image/pjpeg") and if ($_FILES["foto"]["type"] != "image/jpeg") {
                echo "<p>JPEG fotos solamente, gracias!</p>";
                // no olvidar crear la carpeta fotos dentro de wamp/www
            } elseif (!move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/" .
                            basename($_FILES["foto"]["name"]))) {
                echo "<p>Lo sentimos, hubo un problema al subir esa foto.</p>" .
                $_FILES["foto"]["error"];
            } else {
                displayThanks();
            }
        } else {
            switch ($_FILES["foto"]["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                    $message = "La foto es más grande de lo que permite el servidor.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $message = "La foto es más grande de lo que permite el formulario.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $message = "No se ha subido ningún archivo.";
                    break;
                default:
                    $message = "Póngase en contacto con el administrador del servidor para obtener ayuda.";
            }
            echo "<p>Lo sentimos, hubo un problema al subir la foto $message</p>";
        }
    }

    function displayForm() {
        ?>
        <h1>Subir una foto</h1>
        <p>Por favor, introduzca el nombre de la foto y pulse el botón ENVIAR_FOTO.</p>
        <form action="" method="post" enctype="multipart/form-data">
            <div style="width: 30em;">
                <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="" />
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" value="" />
                <div style="clear: both;">
                    <input type="submit" name="enviarFoto" value="Enviar Foto" />
                </div>
            </div>
        </form>
        <?php
    }

    function displayThanks() {
        ?>
        <h1>Gracias</h1>
        <p>Gracias por enviar su foto<?php if ($_POST["nombre"])
            echo ", " .
            $_POST["nombre"]
            ?>!</p>
        <p>Esta es su foto:</p>
        <p><img src="fotos/<?php echo $_FILES["foto"]["name"] ?>" alt="Foto" /></p>
    <?php
}
?>
</body>
</html>
