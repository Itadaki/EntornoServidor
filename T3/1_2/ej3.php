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
        <table border="1" cellpadding="2" cellspacing="2">

            <?php
            $nFilas = rand(1, 7);
            $nColumnas = rand(1, 7);
            for ($i = 1; $i <= $nFilas; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $nColumnas; $j++) {
                    echo "<td>" . ($i * $j) . "</td>";
                }
                echo "</tr>";
            }
            ?>
    </body>
</html>
