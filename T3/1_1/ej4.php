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
        <?php
        $dado = rand(1, 6);
        echo "<h1>As o No</h1>";
        echo "Has sacado un $dado<br>";
        echo "<img src=\"dado/dado$dado.jpg\" height=100 />"; 
        if ($dado == 1){
            echo "<h1>Es un as!!!</h1>";
        }
        ?>
        
    </body>
</html>
