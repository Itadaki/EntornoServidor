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
    <body style="background-color: gray; color: whitesmoke">
        <?php
        $maxFrases = 3;
        $frases = array(
            "Hola navegante.",
            "Bienvenido a mi web.",
            "Gracias por visitarnos.",
            "Te recomiendo visitar nuestro foro.",
            "Visca el Barça.",
            "Puedes enviarnos las sugerencias que quieras.",
            "No dejes de visitarnos estos días, tendremos nuevas sorpresas."
        );
        $elegidos = array();

        for ($i = 0; $i < $maxFrases; $i++) {
            $n = rand(0, (count($frases) - 1));
            $repetido = false;
            foreach ($elegidos as $value) {
                if ($value == $n) {
                    $repetido = true;
                }
            }
            if (!$repetido) {
                $elegidos[] = $n;
            } else {
                $i--;
            }
        }

        foreach ($elegidos as $value) {
            echo "<p>$frases[$value]</p>";
        }
        ?>
    </body>
</html>
