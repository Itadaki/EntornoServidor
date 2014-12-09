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
        <h1>Sentencia <i>for</i></h1>
        <?php
        $suma=0;
        for ($i=1;$i<=10;$i++){
            $suma+=$i;
        }
        echo "La suma de los 10 primeros numeros es: $suma";
        ?>
    </body>
</html>
