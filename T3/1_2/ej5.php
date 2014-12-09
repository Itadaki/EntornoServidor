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
                <?php
                $coches = array(
                    "cougar",
                    "ford",
                    null,
                    2500,
                    "V6",
                    182
                );

                for ($i = 0; $i < 6; $i++) {
                    echo "<td>$coches[$i]</td>";
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($coches as $a) {
                    echo "<td>$a</td>";
                }
                ?>
            </tr>
        </table>

    </body>
</html>
