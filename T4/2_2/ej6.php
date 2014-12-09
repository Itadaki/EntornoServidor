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
        echo '<h1>Suma de 8 números</h1>';
        if (isset($_POST['send'])) {
            displayData();
        } else {
            displayForm();
        }

        function displayForm() {
            echo '<form method="POST" action="">';
            echo 'TABLA DE MULTIPLICAR<br>';
            echo 'Introduzca un número entero';
            echo "<input type='text' name='num' size='2' value='8'>";
            echo "<br>";
            echo '<input type="submit" value="Enviar datos" name="send" /></form>';
        }

        function displayData() {
            $numero = $_POST['num'];
            $display = 10000000;
            echo "TABLA DE MULTIPLICAR DEL $numero:<br>";
            for ($i = 1; $i <= $display; $i++) {
                echo "$i x $numero = " . ($i * $numero) . '<br>';
            }
            echo '<br><a href="ej6.php">Volver</a>';
        }
        ?>
    </body>
</html>
