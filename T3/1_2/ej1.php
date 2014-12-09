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
        <?php
        $var = 5;
        $factorial = 1;
        for ($i = $var; $i > 0; $i--) {
            $factorial*=$i;
        }
        echo "Factorial de $var = $factorial";
        ?>
    </body>
</html>
