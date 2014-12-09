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
        <h1>Sentencia <i>foreach</i></h1>
        <table border="1">
            <tr>
                <th>Posición</th>
                <th>Contenido</th>
            </tr>
            <?php
            $coches = array(
                "cougar",
                "ford",
                null,
                2500,
                "V6",
                182
            );
            $coche = array(
                "modelo" => "cougar",
                "marca" => "ford",
                "null" => null,
                "cc" => 2500,
                "Version" => "V6",
                "CV" => 182
            );
            for ($i = 0; $i < 6; $i++) {
                echo '<tr>';
                echo "<td>$i</td>";
                echo "<td>$coches[$i]</td>";
                echo '</tr>';
            }
            echo '<tr style="height:10px;"></tr>';
            foreach ($coche as $key => $value) {
                echo '<tr>';
                echo "<td>$key</td>";
                echo "<td>$value</td>";
                echo '</tr>';
            }
            ?>
        </table>

    </body>
</html>
