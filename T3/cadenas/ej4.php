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
        <h1>Funciones <i>str_replace</i></h1>
        <table>
        <?php
        $cadena="El murcielago vuela sobre el lago";
        $patron="lago";
        $reemplazo="-LAGO-";
        
        echo '<tr>';
        echo '<td>cadena</td>';
        echo "<td>$cadena</td>";
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>patron</td>';
        echo "<td>$patron</td>";
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>reemplazo</td>';
        echo "<td>$reemplazo</td>";
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>TU MISMO</td>';
        echo '<td>'.  str_replace($patron, $reemplazo, $cadena).'</td>';
        echo '</tr>';
        ?>
        </table>
    </body>
</html>
