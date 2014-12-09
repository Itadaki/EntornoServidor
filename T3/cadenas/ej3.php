<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Funciones substr</title>
    </head>
    <body>
        <h1>Funciones <i>substr</i></h1>
        <table border>
        
        <?php
        $cadena = "Esta es una cadena";
        echo '<tr>';
        echo '<td>cadena</td>';
        echo '<td>'.$cadena.'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>substr(cadena,2)</td>';
        echo '<td>'.substr($cadena,2).'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>substr(cadena,2,3)</td>';
        echo '<td>'.substr($cadena,2,3).'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>substr(cadena,-2)</td>';
        echo '<td>'.substr($cadena,-2).'</td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>substr(cadena,2,-3)</td>';
        echo '<td>'.substr($cadena,2,-3).'</td>';
        echo '</tr>';
        ?>    
        </table>
    </body>
</html>
