<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 13-nov-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Crea un script donde se soliciten los siguientes datos en 
un primer formulario: nombre, apellidos, dirección, teléfono móvil, 
dirección de correo y foto personal. Los campos nombre, apellidos y 
dirección de correo son obligatorios. En el segundo formulario, se 
solicitará seleccionar las ciudades sobre las que se desea recibir 
información (se podrán elegir varias opciones entre 6) y por qué medio: 
correo postal o electrónico (mediante casillas de verificación).
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
        if (isset($_POST["toStep2"])) {
            veriForm();
        } else if (isset($_POST["toStep1"])) {
            displaypaso1(array(), $message = "correcto");
        } else if (isset($_POST["toEnd"])) {
            fin();
        } else {
            displaypaso1(array(), $message = "correcto");
        }

        function displaypaso1($campospendientes, $message) {
            ?>
            <h1>Solicitud información: paso 1</h1>
            <?php
            if ($campospendientes or $message != "correcto") {
                if ($campospendientes) {
                    ?>
                    <p class="error">Hubo algunos problemas con el formulario que presentaste.
                        Por favor, completa los campos en negrita de abajo y haz clic en Enviar
                        para volver a enviar el formulario.</p> <?php
                }
                if ($message != 'correcto') {
                    ?>
                    <p class="error">Hubo algunos problemas con la foto</p>
                    <?php
                    echo $message;
                }
            } else {
                ?>
                <p>Por favor, rellene sus datos a continuación y haga clic en Enviar.
                    Los campos marcados con un asterisco (*) son obligatorios.</p>
                <?php
            }
            ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <span <?php formValidateField('nombre', $campospendientes) ?>>Nombre*</span>
                <input type="text" name="nombre" value="<?php formSetValue('nombre') ?>" /> 
                <span <?php formValidateField('apellidos', $campospendientes) ?>>Apellidos* </span>
                <input type="text" name="apellidos" value="<?php formSetValue('apellidos') ?>" /><br>
                <span <?php formValidateField('direccion', $campospendientes) ?>>Direccion </span>
                <input type="text" name="direccion" value="<?php formSetValue('direccion') ?>" /> 
                <span <?php formValidateField('telf', $campospendientes) ?>>Telf </span>
                <input type="text" name="telf" value="<?php formSetValue('telf') ?>" /><br>
                <span <?php formValidateField('email', $campospendientes) ?>>eMail </span>
                <input type="text" name="email" value="<?php formSetValue('email') ?>" /><br>
                Foto: <input type="file" name="foto" /><br>
                <input type="submit" value="Next >" name="toStep2" />

                <?php
                $ciudades = array('Roma', 'París', 'Nueva York', 'Londres', 'Berlin', 'Atenas');
                foreach ($ciudades as $valor) {
                    ?>
                    <input type="hidden" name="ciudades[]" value="<?php setValue2("ciudades", $valor) ?>">
                    <?php
                }
                $informacion = array('Correo Postal', 'Email');
                foreach ($informacion as $valor) {
                    ?>
                    <input type="hidden" name="info[]" value="<?php setValue2("info", $valor) ?>">
                    <?php }
                ?>
            </form>
            <?php
        }

        function displaypaso2() {
            move_uploaded_file($_FILES['foto']['tmp_name'], "fotos/tmp.jpg");
            ?>
                
            <form method="POST" action="">
                <select name="ciudades[]" size="6" multiple="multiple">
                    <option <?php formSetSelected("ciudades", "Roma") ?>>Roma</option>
                    <option <?php formSetSelected("ciudades", "París") ?>>París</option>
                    <option <?php formSetSelected("ciudades", "Nueva York") ?>>Nueva York</option>
                    <option <?php formSetSelected("ciudades", "Londres") ?>>Londres</option>
                    <option <?php formSetSelected("ciudades", "Berlin") ?>>Berlin</option>
                    <option <?php formSetSelected("ciudades", "Atenas") ?>>Atenas</option>
                </select><br>
                correo postal <input type="checkbox" name="info[]" value="Correo Postal" <?php formSetChecked('info', 'Correo Postal') ?>/><br>
                email <input type="checkbox" name="info[]" value="Email" <?php formSetChecked('info', 'Email') ?>/><br>
                <input type="submit" value="< Back" name="toStep1" />
                <input type="submit" value="Next >" name="toEnd" />
                <input type="hidden" name="nombre" value="<?php formSetValue('nombre') ?>" />
                <input type="hidden" name="apellidos" value="<?php formSetValue('apellidos') ?>" />
                <input type="hidden" name="direccion" value="<?php formSetValue('direccion') ?>" />
                <input type="hidden" name="telf" value="<?php formSetValue('telf') ?>" />
                <input type="hidden" name="email" value="<?php formSetValue('email') ?>" />
                <input type="hidden" name="foto" value="<?php echo 'tmp'; ?>" />
            </form>
            <?php
        }

        function fin() {
            $foto = $_POST['foto'];
            echo 'Gracias '. $_POST['nombre'] . "<img src='fotos/$foto.jpg' />";
        }

        function veriForm() {
            $camposObligatorios = array("nombre", "apellidos", "email");
            $campospendientes = array();
            foreach ($camposObligatorios as $campoObligatorio) {
                if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
                    $campospendientes[] = $campoObligatorio;
                }
            }
            if (isset($_FILES["foto"]) and $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
                if ($_FILES["foto"]["type"] != "image/jpeg") {
                    $message = "JPEG fotos solamente, gracias!";
                } elseif (!move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/" . basename($_FILES["foto"]["name"]))) {
                    $message = "Lo sentimos, hubo un problema al subir esa foto" . $_FILES["foto"]["error"];
                } else {
                    $message = "correcto";
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
                        $message = "Ponte en contacto con el administrador del servidor para obtener ayuda.";
                }
            }
            if ($campospendientes or $message != 'correcto') {
                displaypaso1($campospendientes, $message);
            } else {
                displaypaso2();
            }
        }

        function displayGracias() {

            echo '<h1>Gracias </h1>';
            echo "Gracias ", $_POST["nombre"], ", tu solicitud ha sido recibida";
            ?>
            <p>Esta es su foto:</p>
            <p><img src="fotos/<?php echo $_POST["foto"] ?>" alt="Photo" ></p>
        <?php } ?>

    </body>
</html>
