<!DOCTYPE html>
<!--
Crea un programa que permita visualizar la tabla de multiplicar de un número 
introducido por el usuario a través del siguiente formulario.
Utiliza dos funciones (procesarFormulario y VisualizarFormulario).
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            .error{background-color:red; color:white; width:300px}
        </style>
    </head>
    <body>
        <?php
        $v = rand(0, 10);
        echo '<h1>Suma de 8 números</h1>';
        if (isset($_POST['send']) && !empty($_POST['num'])) {
            check();
        } else {
            displayForm($v);
        }

        function check() {
            if ($_POST['num'] < 0 || $_POST['num'] > 10 || !is_numeric($_POST['num'])) {
                displayForm($_POST['num']);
                echo '<p class="error">Por favor, introduce un número entre 0 y 10</p>';
            } else {
                displayData();
            }
        }

        function displayForm($value) {
            echo '<form method="POST" action="">';
            echo 'TABLA DE MULTIPLICAR<br>';
            echo 'Introduzca un número entero';
            echo "<input type='text' name='num' size='2' value='$value'>";
            echo "<br>";
            echo '<input type="submit" value="Enviar datos" name="send" /></form>';
        }

        function displayData() {
            $numero = $_POST['num'];
            $display = 10;
            echo "TABLA DE MULTIPLICAR DEL $numero:<br>";
            for ($i = 1; $i <= $display; $i++) {
                echo "$i x $numero = " . ($i * $numero) . '<br>';
            }
            echo '<br><a href="ej3.php">Volver</a>';
        }
        ?>
    </body>
</html>
