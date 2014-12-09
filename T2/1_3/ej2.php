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
    </head>
    <body>
        <?php
        $cadena="Hola a todos";
        ?>
        <h1>Comprobando el tipo de las variables</h1>
        <p>La variable $cadena contiene <b><?php echo $cadena ?></b></p>
        <p>La variable $cadena <?php echo (is_int($cadena)?'':'no') ?> es de tipo entero<br>
            La variable $cadena <?php echo (is_double($cadena)?'':'no') ?> es de tipo doble<br>
            La variable $cadena <?php echo (is_string($cadena)?'':'no') ?> es de tipo cadena</p>
    </body>
</html>
