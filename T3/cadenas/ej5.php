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
        <h1>Funciones <i>strlen, trim, ltrim, rtrim</i></h1>
        <table>
        <?php
        $cadena="      cadena    ";
        
        echo '<tr>';
        echo '<td></td>';
        echo "<td>tamaño</td>";
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>cadena\n(6 espacios delante u 4 detras)</td>';
        echo '<td>'.strlen($cadena).'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>Sin blancos a la derecha</td>';
        echo '<td>'.strlen(rtrim($cadena)).'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>Sin blancos a la izquierda</td>';
        echo '<td>'.strlen(ltrim($cadena)).'</td>';
        echo '</tr>';
        ?>
        </table>
    </body>
</html>
