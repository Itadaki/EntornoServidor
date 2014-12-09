<!DOCTYPE html>
<!--
15-sep-2014 - 11:13:06
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $indexado=array("Cougar","Ford",null,2500,"V6",182);
        
        $asociativo=array(
            "modelo"=>"Cougar",
            "marca"=>"Ford",
            "fecha"=>null,
            "cc"=>2500,
            "motor"=>"V6",
            "potencia"=>182
        );
        ?>
        <table border="1" cellpadding="2" cellspacing=2">
            <tr>
                <td></td>
                <td>Modelo</td>
                <td>Marca</td>
                <td>Fecha</td>
                <td>CC</td>
                <td>V6</td>
                <td>Potencia</td>
            </tr>
            <tr>
                <td>Matriz 1</td>
                <td><?php echo $indexado[0]; ?></td>
                <td><?php echo $indexado[1]; ?></td>
                <td><?php echo $indexado[2]; ?></td>
                <td><?php echo $indexado[3]; ?></td>
                <td><?php echo $indexado[4]; ?></td>
                <td><?php echo $indexado[5]; ?></td>
            </tr>
            <tr>
                <td>Matriz 2</td>
                <td><?php echo $asociativo["modelo"]; ?></td>
                <td><?php echo $asociativo["marca"]; ?></td>
                <td><?php echo $asociativo["fecha"]; ?></td>
                <td><?php echo $asociativo["cc"]; ?></td>
                <td><?php echo $asociativo["motor"]; ?></td>
                <td><?php echo $asociativo["potencia"]; ?></td>
            </tr>
        </table>
    </body>
</html>
