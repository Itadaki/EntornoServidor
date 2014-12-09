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
        <img src="sudo.bmp" /><br>
        <?php
        $microt= microtime();
        echo $microt.'<br>';
        $ms = explode(' ', $microt);
        echo "La pagina tardo en visualizarse.$ms[0] ms";
        ?>
    </body>
</html>
