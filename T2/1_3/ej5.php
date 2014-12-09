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
        <h1>Incrementos y Decrementos</h1>
        <?php
        $a = 7;
        $b = 7;
        $c;
        echo "El valor inicial de \$a es $a<br>";
        echo "Al preincrementar (++\$a) devuelve". ++$a."<br>";
        echo "Al posincrementar (\$a++) devuelve". $a++."<br>";
        echo "El valor final de \$a es $a<br><br>";
        
        echo "El valor inicial de \$b es $b<br>";
        echo "Al preincrementar (--\$b) devuelve".--$b."<br>";
        echo "Al posincrementar (\$b-) devuelve".$b--."<br>";
        echo "El valor final de \$b es $b<br><br>";
        
        echo "A \$c le asignamos '\$b-- +3'";
        $c=$b-- + 3;
        echo "Valor final de \$b: $b. Valor final de \$c: $c";
        ?>
    </body>
</html>
