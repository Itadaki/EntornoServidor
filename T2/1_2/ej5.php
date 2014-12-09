<!DOCTYPE html>
<!--
15-sep-2014 - 11:23:00
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $pi="3.1416 es el valor de Pi";
        $entero=(int)$pi;
        $flotante=(float)$pi;
        ?>
        <h1>Conversion de tipos por casting</h1>
        <p><?php echo 'El valor de $pi es: '.$pi ?></p>
        <p><?php echo "El resultado de convertirla a entero es $entero";
        echo "<br>El resultado de convertirla a float es $flotante" ?></p>
    </body>
</html>
