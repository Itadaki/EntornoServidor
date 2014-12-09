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
        //include_once 'funciones.php';
        $precios = array(1000, 2300, 7000);
        

        function toEuro() {
            $n = func_get_arg(0);
            return sprintf("%02.2f", $n / 166.386);
        }

        function toDolar() {
            $n = func_get_arg(0);
            return sprintf("%02.2f", $n / 131.658);
        }

        function toYen() {
            $n = func_get_arg(0);
            return sprintf("%02.2f", $n / 1.056);
        }

        $array_funciones = array('toEuro', 'toDolar', 'toYen');
        echo '<table border>';
        echo "<TR ALIGN='center'><td>Pesetas</td><td>Euros</td><td>Dolares</td><td>Yenes</td>";
        for ($i = 0; $i < sizeof($precios); $i++) {
            echo "<TR ALIGN='center'>";
            echo "<TD>$precios[$i]</TD>";
            for ($j = 0; $j < sizeof($array_funciones); $j++) {
                $funcion = $array_funciones[$j];
                echo "<TD>" . $funcion($precios[$i]) . "</TD>";
            }
            echo "</TR>";
        }
        echo '</table>';
        ?>
    </body>
</html>
