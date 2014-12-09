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
        $cadena="38E6";
        ?>
        <h1>Conversioón de variables</h1>
        <p>El valor de $cadena es: <?php echo $cadena ?></p>
        <p>
            El resultado de convertirlo a entero es 
                <?php echo intval($cadena) ?><br>
            El resultado de convertirlo a octal es 
                <?php echo intval($cadena,8) ?><br>
            El resultado de convertirlo a hexadecimal es 
                <?php echo intval($cadena,16) ?><br>
            El resultado de convertirlo a doble es 
                <?php echo doubleval($cadena) ?><br>
            El resultado de convertirlo a cadena es 
                <?php echo strval($cadena) ?><br>
        </p>
    </body>
</html>
