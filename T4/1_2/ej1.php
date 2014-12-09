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
        if (isset($_POST['numero']) and is_numeric($_POST['numero']) and ! empty($_POST['numero'])) {
            $numero = $_POST['numero'];
            echo "El número $numero es " .
            (($numero % 2 == 0) ? "par" : "impar");
        }
        else{
            echo 'No has introducido un numero';
        }
        ?>
        <br>
        <a href="ej1.html">VOLVER</a>
    </body>
</html>
