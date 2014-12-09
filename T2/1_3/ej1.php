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
        $cadena="3.1416 es el valor de PI";
        ?>
        <h1>Usando gettype() y settype()</h1>
        <p>El valor de $cadena es: <?php echo $cadena;?><br>
            Es de tipo <?php echo gettype($cadena)?></p>
        <p>Si lo paso a float obtengo: <?php settype($cadena, "float"); echo $cadena ?><br>
            Si lo paso a entero obtengo: <?php settype($cadena, "integer"); echo $cadena ?></p>
        
        
    </body>
</html>
