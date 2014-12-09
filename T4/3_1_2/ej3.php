<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Resultados</title>
    </head>
    <body>
        <h1>Resultado del cuestionario</h1>
        <?php
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
        ?>
    </body>
</html>
