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
        <style type="text/css">
            .error { 
                background: #d33; 
                color: white; 
                padding: 0.2em; 
                width: 300px;
            }
        </style>
    </head>
    <body>
        <h1>Conversor de moneda</h1>
        <?php
        include_once 'funciones.php';

        //Si todo es correcto
        if (isset($_POST["send"]) && !empty($_POST["pts"]) && preg_match("/^[0-9]+$/", $_POST["pts"])) {
            processForm();
        }
        //Si pesetas esta vacio o esta mal rellenado
        elseif (isset($_POST["pts"]) && empty($_POST["pts"]) or isset($_POST["pts"]) && !preg_match("/^[0-9]+$/", $_POST["pts"])) {
            ?>
            <p class="error">Hubo algunos problemas con el formulario que usted presentó.
                Por favor, rellene el campo <b>pesetas</b> correctamente.</p>
            <?php
            displayForm();
        } else {
            displayForm();
        }

        function processForm() {
            $pesetas = $_POST['pts'];
            $to = $_POST['moneda'];
            $func = array(
                'Euros' => 'toEuro',
                'Dolares' => 'toDolar',
                'Yenes' => 'toYen');

            $conversion = $func[$to]($pesetas);

            echo "$pesetas pesetas son $conversion $to";
            echo '<br><a href="ej3.php">Volver</a>';
        }

        function displayForm() {
            ?>
            <form method="POST" action="">
                Pesetas: <input type="text" name="pts" value="3456" size="5" /><br>
                <input type="radio" name="moneda" value="Euros" checked="checked" /> a Euros<br>
                <input type="radio" name="moneda" value="Dolares" /> a Dolar<br>
                <input type="radio" name="moneda" value="Yenes" /> a Yens<br><br>
                <input type="submit" value="Enviar" name="send" /> <input type="reset" value="Borrar" name="del" />
            </form>
        <?php } 
        //+ minimo 1 |||| * minimo 0
        //preg_match("/^[0-9]+$/", cadena)) //solo numeros
        //preg_match("/^[0-9]{1,3}$/", cadena)) //solo 3 numeros
        //preg_match("/^[0-9]{1}$/", cadena)) //solo 1 numero
        //preg_match("/^[A-Za-z]{1}$/", cadena)) //solo letras
        //preg_match("/^[A-Za-z ]{1}$/", cadena)) //solo letras con espacios
        //preg_match("/^[A-Za-z/]{1}$/", cadena)) //solo letras con barras
        //preg_match("/^[A-Za-z][A-Za-z ]+{1}$/", cadena)) //solo letras con espacios y el primer char tiene que ser letra
        
        ?>


    </body>
</html>
