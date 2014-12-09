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
        if (isset($_GET['nombre'])) {
            echo 'Hola <b>' . $_GET['nombre'] . '</b> ¿Que tal estás?<br>';
        }
        if (isset($_GET['golf'])) {
            echo ($_GET['golf'] ? 'Te' : 'No te') . ' gusta el golf<br>';
        }
        if (isset($_GET['sysli'])) {
            echo 'Tu sistema favorito es ' . $_GET['sysli'] . '<br>';
        }
        echo (isset($_GET['futbol']) ? 'Te' : 'No te') . ' gusta el futbol<br>';
        if (isset($_GET['aficiones'])) {
            echo 'Tus aficiones son:<br>' . $_GET['aficiones'] . '<br>';
        }
        ?>
        <br><br><hr>
        <a href="ej4.html">VOLVER AL FORMULARIO</a>
    </body>
</html>
