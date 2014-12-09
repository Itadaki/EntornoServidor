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
        <table>
            <tr>
                <td style="background-color:salmon">
                    <?php
                    $principio = rand(0, 50);
                    $final = rand(0, 50);
                    cuentaAtras($principio, $final, "BTOOM!");
                    ?>
                </td>
                <td style="background-color:lightyellow">
                    <?php cuentaAtras($principio, $final, "SPLASH!"); ?>
                </td>
            </tr>
        </table>
        <?php

        function cuentaAtras(&$inicio, &$fin, $msg) {
            $inicio += 2;
            $fin += 2;
            if ($inicio > $fin) {
                for ($i=$inicio; $i > $fin; $i--) {
                    echo $i . '<br>';
                }
            } else {
                for ($i=$fin; $i > $inicio; $i--) {
                    echo $i . '<br>';
                }
            }
            echo $msg;
        }
        ?>
    </body>
</html>