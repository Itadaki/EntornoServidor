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
    <body style="background-color: brown;">
        <?php
        if (isset($_POST['user']) and isset($_POST['pass']) and !empty($_POST['user']) and !empty($_POST['pass'])){
            echo '<h2>Bienvenido</h2>';
            include_once 'ej2_2.php';
        }
        else{
            echo '<h1>Usuario o contraseña incorrectos</h1>';
            //echo '<img src="img.png" />';
        }
        ?>
        
    </body>
</html>
