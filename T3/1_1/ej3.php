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
        $hora = date("G");
        $año = date("Y");
        $esBisiesto;
        
        $saludo;
        if ($hora >= 5 && $hora <= 12){
            $saludo = "Buenos días";
        }
        elseif ($hora > 12 && $hora <= 18){
            $saludo = "Buenas tardes";
        }
        else{
            $saludo = "Buenas noches";
        }
        echo "<h1>$saludo</h1>";
        
        //bisiesto si es divisible por 4 y no por 100, o divisible por 400
        if (($año%4==0 && $año%100!=0) || $año%400==0){
            $esBisiesto=true;
        }
        else{
            $esBisiesto=false;
        }
        
        echo "¿Sabes que el año $año".($esBisiesto?"":" no")." es bisiesto?";
        
        ?>
    </body>
</html>
