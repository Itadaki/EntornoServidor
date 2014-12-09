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
                <td style="background-color:salmon"><?php cuentaAtras(rand(0, 100)); ?>
                </td>
                <td style="background-color:lightyellow"><?php cuentaAtras(rand(0, 100)); ?>
                </td>
            </tr>
        </table>
        <?php
        function cuentaAtras($n) {
            for ($i = $n; $i > 0; $i--) {
                echo $i . '<br>';
            }
            echo 'BOOOOOM';
        }
        ?>
    </body>
</html>
