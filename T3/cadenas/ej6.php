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
        <h1>Funciones <i>strtok</i></h1>
        <table>
            <?php
            $cadena = "dato1, dato2, dato3, dato4, dato5";
            $patron = ", ";
            $token = strtok($cadena, $patron);

            echo '<tr>';
            echo '<td>cadena</td>';
            echo "<td>$cadena</td>";
            echo '</tr>';

            while ($token) {
                echo '<tr>';
                echo '<td>patron</td>';
                echo "<td>$token</td>";
                echo '</tr>';
                $token = strtok($patron);
            }
            ?>
        </table>
    </body>
</html>
