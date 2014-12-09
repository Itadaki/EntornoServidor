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
        <h1>Operadores Aritméticos</h1>
        <?php
        $euro = 166.386;
        intval($euro);
        echo "1000€ son ".($euro*1000)."<br>";
        echo "1000pts. son ".(intval((1000/$euro)*100)/100)."<br>";
        $b50 =  intval(157/50);
        $b1 = 157%50;
        echo "157€ son $b50 billetes de 50 y $b1 €";
        ?>
    </body>
</html>
