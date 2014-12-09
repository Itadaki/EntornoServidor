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
        <h1>Sentencia <i>for</i></h1>
        <table border="1" cellpadding="2" cellspacing="2"> 
            <tr>
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    echo "<th>x$i</th>";
                }
                ?>
            </tr>
            <?php
            for ($i = 1; $i < 10; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= 10; $j++) {
                    echo "<td>" . ($i * $j) . "</td>";
                }
                echo "</tr>";
            }
            ?>

        </table>
    </body>
</html>
