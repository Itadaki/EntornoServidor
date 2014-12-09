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
        <style>
            table{
                border-color: black;
            }
            td{height: 50px;width: 50px;}
            .blanca{background-color: white;}
            .negra{background-color: black;}
        </style>
    </head>
    <body>
        <table border="1" cellpadding="1" cellspacing="1">

            <?php
            $nFilas = 8;
            $nColumnas = 8;
            $isBlack = false;
            for ($i = 1; $i <= $nFilas; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $nColumnas; $j++) {
                    echo "<td class=\""
                    . ($isBlack ? "negra" : "blanca")
                    . "\"></td>";
                    $isBlack = !$isBlack;
                }
                $isBlack = !$isBlack;
                echo "</tr>";
            }
            ?>
    </body>
</html>
