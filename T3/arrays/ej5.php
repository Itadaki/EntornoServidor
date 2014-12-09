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
        <table border>
            <tr>
                <td class="y">Posicion</td>
                <td class="y">Valor</td>
            </tr>
        
        <?php
        $matriz1[0] = "Madrid";
        $matriz1[1] = "Zaragoza";
        $matriz1[2] = "Bilbao";
        $matriz1[3] = "Valencia";
        $matriz1[4] = "Lerida";
        $matriz1[5] = "Alicante";
        sort($matriz1);
        for ($i=0; $i<count($matriz1);$i++){
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$matriz1[$i]</td>";
            echo "</tr>";
        }
        rsort($matriz1);
        echo '<tr class="y"><td colspan="2"></td></tr>';
        for ($i=0; $i<count($matriz1);$i++){
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$matriz1[$i]</td>";
            echo "</tr>";
        }
        ?>
        </table>
    </body>
</html>
