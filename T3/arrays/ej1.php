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
        <h1>Arrays <i>multidimensionales</i></h1>
        <table border>
            <tr>
                <td class="y"></td>
                <td class="y">Moneda</td>
                <td class="y">Cambio €</td>
            </tr>
            <?php
            $escalar = array(
                array("peseta", 166.386),
                array("dolar", 0.96)
            );
            $asociativo = array(
                "moneda1" => array("moneda" => "peseta", 166.386),
                "moneda2" => array("moneda" => "dolar", 0.96)
            );
            $mixto = array(
                array("moneda" => "peseta", 166.386),
                array("moneda" => "dolar", 0.96)
            );

            for ($i=0; $i<count($escalar);$i++) {
                echo '<tr>';
                echo "<td class='y'>\$escalar$i</td>";
                foreach ($escalar[$i] as $b) {
                    echo "<td>$b</td>";
                }
            }
            
            foreach ($asociativo as $key => $value) {
                echo '<tr>';
                echo '<td class="y">$asociativo</td>';
                foreach ($value as $key2 => $value2) {
                    echo "<td>$value2</td>";
                }
            }
            
            for ($i=0; $i<count($mixto);$i++) {
                echo '<tr>';
                echo "<td class='y'>\$mixto$i</td>";
                foreach ($mixto[$i] as $key => $value) {
                    echo "<td>$value</td>";
                }
            }
            ?>
        </table>

    </body>
</html>
