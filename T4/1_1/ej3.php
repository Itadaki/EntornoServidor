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
        if (isset($_POST['n']) and !empty($_POST['n'])) {
            $restos = array(
                "Cero",
                "Uno",
                "Dos",
                "Tres",
                "Cuatro",
                "Cinco",
                "Seis",
                "Siete",
                "Ocho",
                "Nueve",
                "Diez",
                "Once"
            );
            $dividendo = $_POST['n'];
            $divisor = 12;
            $resto = $dividendo % $divisor;
            echo "El resultado de dividir $dividendo entre $divisor es: " . $restos[$resto];
        } else {
            echo 'No ha introducido el número';
        }
        ?>
    </body>
</html>
