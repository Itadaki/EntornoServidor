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
        $meses = array(
            "enero"=>31,
            "febrero"=>28,
            "marzo"=>31,
            "abril"=>30,
            "mayo"=>31,
            "junio"=>30,
            "julio"=>31,
            "agosto"=>31,
            "septiembre"=>30,
            "octubre"=>31,
            "noviembre"=>30,
            "diciembre"=>31
        );

        echo '<h1>MESES DEL AÑO</h1>';

        echo "<p>El mes de enero tiene $meses[enero] dias</p>";
        echo "<p>El mes de febrero tiene $meses[febrero] dias</p>";
        echo "<p>El mes de marzo tiene $meses[marzo] dias</p>";
        echo "<p>El mes de abril tiene $meses[abril] dias</p>";
        echo "<p>El mes de mayo tiene $meses[mayo] dias</p>";
        echo "<p>El mes de junio tiene $meses[junio] dias</p>";
        echo "<p>El mes de julio tiene $meses[julio] dias</p>";
        echo "<p>El mes de agosto tiene $meses[agosto] dias</p>";
        echo "<p>El mes de septiembre tiene $meses[septiembre] dias</p>";
        echo "<p>El mes de octubre tiene $meses[octubre] dias</p>";
        echo "<p>El mes de noviembre tiene $meses[noviembre] dias</p>";
        echo "<p>El mes de diciembre tiene $meses[diciembre] dias</p>";
        ?>
    </body>
</html>