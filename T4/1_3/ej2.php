<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">

        </style>
    </head>
    <body>
        <?php
        if (isset($_POST['send'])) {
            displayData();
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <h1>Formulario de inscripcion</h1>
            <p>Gracias pro blabla</p>
            <form method="POST" action="">
                Nombre <input type="text" name="nombre" value="Diego" /> Apellidos <input type="text" name="apellidos" value="Rodríguez" /><br>
                Contraseña <input type="password" name="pass1" value="abcd" /><br>
                Introduce de nuevo la contraseña <input type="password" name="pass2" value="abcd" /><br>
                <label for="hombre" >Hombre</label><input type="radio" name="genero" value="hombre" checked="checked" />
                <label for="mujer" >Mujer</label><input type="radio" name="genero" value="hombre" checked="checked" /><br>
                Juegos favoritos <select name="juegos[]" size="3" multiple="multiple">
                    <option value="Tute">Tute</option><option value="Mus">Mus</option><option value="Bridge">Bridge</option>
                </select><br>
                
                Recibir boletin de noticias <input type="checkbox" name="boletin" value="true" checked="checked" /><br>
                Recibir ofertas <input type="checkbox" name="ofertas" value="true" checked="checked" /><br>
                Comentarios <br><textarea name="comentarios" rows="4" cols="20">Comentario inicial</textarea>
                <br>  
                <input type="submit" name="send" value="Enviar" />
                <input type="reset" value="Borrar" />
            </form>
            <?php
        }

        function displayData() {
            echo '<h1>Gracias!</h1>';
            echo 'Gracias por registrarte. Estos son sus datos: <br>';
            echo '<dt>Nombre:<dt><dd>' . $_POST['nombre'] . '</dd>';
            echo '<dt>Apellidos:<dt><dd>' . $_POST['apellidos'] . '</dd>';
            if ($_POST['pass1'] == $_POST['pass2']) {
                echo '<dt>Contraseña:<dt><dd>' . $_POST['pass1'] . '</dd>';
            }
            echo '<dt>Genero:<dt><dd>' . $_POST['genero'] . '</dd>';
            if (isset($_POST['juegos'])) {
                echo '<dt>Juegos:<dt><dd>';
                $a = $_POST['juegos'];
                foreach ($a as $value) {
                    echo $value . '<br>';
                }
                echo'</dd>';
            }
            echo 'Usted '.(isset($_POST['boletin'])?"":"no " ). 'recibirá noticias.<br>';
            echo 'Usted '.(isset($_POST['ofertas'])?"":"no " ). 'recibirá ofertas.<br>';
            echo '<dt>Comentarios:<dt><dd>' . $_POST['comentarios'] . '</dd>';
            echo '<a href="ej2.php">Volver</a>';
        }
        
        ?>
    </body>
</html>
