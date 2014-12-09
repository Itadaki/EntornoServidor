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
        }
        displayForm();

        function displayForm() {
            $n = 8;
            echo '<form method="POST" action="">';
            for ($i = 0; $i < $n; $i++) {
                echo $i;
                echo "<input type='text' name='num[]' size='10' value='$i'>";
                echo "<br>";
            }
            echo '<input type="submit" value="Enviar" name="send" /></form>';
        }

        function displayData() {
            $numeros = $_POST['num'];
            $suma = 0;
            echo 'El vector tiene ' . count($numeros) . ' elementos<br>';
            for ($i = 0; $i < count($numeros); $i++) {
                echo $i . ' = ' . $numeros[$i] . '<br>';
                $suma += $numeros[$i];
            }
            echo "La suma es $suma";
        }
        ?>
    </body>
</html>
