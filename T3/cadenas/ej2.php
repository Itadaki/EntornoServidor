<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Funcion strlen</title>
    </head>
    <body>
        <h1>Funcion <i>strlen</i></h1>
        <table>
            <tr>
                <th>Caracter</th>
                <th>Posicion</th>
            </tr>
        <?php
        $cadena = "Saludos";
        for ($i=0; $i<strlen($cadena);$i++){
           echo '<tr align="center">';
           echo "<td>$cadena[$i]</td>";
           echo "<td>$i</td>";
           echo "</tr>";
        }
        ?>
        </table>
    </body>
</html>
