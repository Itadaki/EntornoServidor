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
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $habitaciones = $_POST['habitaciones'];
        $transporte = "";
        
        if (isset($_POST['medios'])) {
            foreach ($_POST['medios'] as $medio) {
                $transporte .= $medio . '<br>';
            }
        }
        else $transporte = "No utilizas ningun medio de transporte.";
        //Eliminar coma del final: preg_replace("/,$/", "",$transporte);
        echo "<dt>Nombre:</dt><dd>$nombre</dd><br>";
        echo "<dt>Apellidos:</dt><dd>$apellidos</dd><br>";
        echo "<dt>Número de habitaciones:</dt><dd>$habitaciones</dd><br>";
        echo "<dt>Medios de transporte:</dt><dd>$transporte</dd><br>";
        ?>
    </body>
</html>
