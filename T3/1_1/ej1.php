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
        <h1>Sentencia <i>if</i></h1>
        <?php
        $v1=3;
        $v2=7;
        $v3=9;
        $mayor;
        echo "Los tres números a comparar son $v1, $v2 y $v3<br>";
        if ($v1 > $v2 && $v1 > $v3){
            $mayor = $v1;
        }
        if ($v2 > $v1 && $v2 > $v3){
            $mayor = $v2;
        }
        if ($v3 > $v2 && $v3 > $v1){
            $mayor = $v3;
        }
        echo "El mayor es el <b>$mayor</b>";
        ?>
    </body>
</html>
