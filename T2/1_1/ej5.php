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
        define("EURO", 166.386);
        define("CENT",EURO/100);
        ?>
        <h1>Trabajando con constantes</h1>
        <p>El valor de la constante 'euro' es: <?php echo EURO ?>
        <br>Luego 1€ son <?php echo 1*EURO ?>ptas.</p>
        <p>La constante 'centimo' no esta definida
        <br>El valor de la constante 'centimo' es: <?php echo CENT ?></p>
    </body>
</html>