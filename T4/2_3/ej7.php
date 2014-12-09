<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            .error{background-color:red; color:white; width:300px; padding-left: 5px;}
        </style>
    </head>
    <body>
        <?php
        $nombre = 'Diego';
        $apellido = 'Rodríguez';
        echo '<h1>Encuesta(libros)</h1>';

        if (isset($_POST['send_name'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $mal = false;
            if (!check($_POST['nombre'])) {
                echo '<p class="error">Por favor, rellena correctamente el nombre</p>';
                $mal = true;
            }
            if (!check($_POST['apellido'])) {
                echo '<p class="error">Por favor, rellena correctamente los apellidos</p>';
                $mal = true;
            }
            if ($mal) {
                displayFormName($nombre, $apellido);
            } else {
                displayFormBook();
            }
        } elseif (isset($_POST['send_book'])) {
            displayData();
        } else {
            displayFormName($nombre, $apellido);
        }

        function displayFormName($nombre, $apellido) {
            echo '<form method="POST" action="">';
            echo '<input type="text" name="nombre" value="' . $nombre . '" />Nombre<br>';
            echo '<input type="text" name="apellido" value="' . $apellido . '" />Apellidos<br>';
            echo '<input type="submit" value="Enviar" name="send_name" />';
            echo '</form>';
        }

        function displayFormBook() {
            echo '<h2>Hola ' . $_POST['nombre'] . ' ' . $_POST['apellido'] . '¿Qué tipo de libros prefieres?</h2>';
            echo '<form method="POST" action="">';
            echo '<input type="radio" name="genero" value="Fantasía" checked />Fantasía ';
            echo '<input type="radio" name="genero" value="Ciencia Ficción" />Ciencia Ficción ';
            echo '<input type="radio" name="genero" value="Novela Negra" />Novela Negra<br>';
            echo '<input type="submit" value="Enviar" name="send_book" />';
            echo '</form>';
            echo '<br><a href="ej7.php">Volver</a>';
        }

        function displayData() {
            echo 'Te gustan los libros de ' . $_POST['genero'];
            echo '<br><a href="ej7.php">Volver</a>';
        }

        function check($v) {
            return (preg_match("/^[A-Za-z áéíóú]+$/", $v)) ;
        }
        ?>
    </body>
</html>
