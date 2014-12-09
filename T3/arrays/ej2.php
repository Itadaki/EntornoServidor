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
        <style>.y{background-color: yellow;font-weight: bold}</style>
    </head>
    <body>
        <?php
        $matriz1[3] = "cougar";
        $matriz1[5] = "ford";
        $matriz1[7] = "2.500";
        $matriz1[] = "V6";
        $matriz1[] = 172;
        $matriz2['modelo'] = "cougar";
        $matriz2['marca'] = "ford";
        $matriz2['fecha'] = null;
        $matriz2['cc'] = "2.500";
        $matriz2['motor'] = "V6";
        $matriz2['potencia'] = 182;
        ?>
        <h1>Arrays funciones<br><i>reset, end, next, prev, current y key</i></h1>
        <table border>
            <?php
            echo '<tr>';
            echo '<td class="y">posicion</td>';
            do {
                echo '<td class="y">' . key($matriz1) . '</td>';
            } while (next($matriz1));
            echo '</tr>';
            reset($matriz1);
            echo '<tr>';
            echo '<td class="y">valor</td>';
            do {
                echo '<td>' . current($matriz1) . '</td>';
            } while (next($matriz1));
            echo '</tr>';
            ?>
        </table>
        <br>
        <table border>
            <?php
            echo '<tr>';
            echo '<td class="y">clave</td>';
            end($matriz2);
            do {
                echo '<td class="y">' . key($matriz2) . '</td>';
            } while (prev($matriz2));
            echo '</tr>';
            end($matriz2);
            echo '<tr>';
            echo '<td class="y">valor</td>';
            do {
                echo '<td>' . current($matriz2) . '</td>';
            } while (prev($matriz2));
            echo '</tr>';
            ?>
        </table>
    </body>
</html>
