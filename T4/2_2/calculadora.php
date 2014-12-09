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
        <h1>Calculadora Cientifica</h1>

        <?php
        include_once 'funciones.php';

        if (isset($_POST['send'])) {
            procesForm();
        }
        displayForm();

        function procesForm() {
            $valor1 = $_POST['a'];
            $valor2 = $_POST['b'];
            $funcion = strtolower($_POST['send']);
            $resultado = $funcion($valor1, $valor2);
            echo ucfirst($funcion) . " $valor1 y $valor2 da $resultado";
        }

        function displayForm() {
            ?>
            <form method="POST" action="">
                <table>
                    <tr>
                        <td>A</td>
                        <td><input type="text" name="a" value="<?php if (isset($_POST['a'])) echo $_POST['a']; else echo '7'; ?>" size="5" /></td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td><input type="text" name="b" value="<?php if (isset($_POST['b'])) echo $_POST['b']; else echo '8'; ?>" size="5" /></td>
                    </tr>
                </table>
                <input type="submit" value="Sumar" name="send" /> 
                <input type="submit" value="Restar" name="send" /> 
                <input type="submit" value="Multiplicar" name="send" /> 
                <input type="submit" value="Dividir" name="send" /> 
            </form>
        <?php } ?>
    </body>
</html>
