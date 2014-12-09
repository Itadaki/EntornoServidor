<!DOCTYPE html>
<!--
Crea un programa que permita introducir a través de formulario un número variable
de números, que almacenará en un array, y después obtenga el resultado de la suma. 
Es decir, el formulario permitirá definir el número de valores a introducir para 
calcular la suma. Como en el anterior, define dos funciones.
Ten en cuenta que tienes que definir dos formularios en la función displayForm(). 
El segundo se visualizará sólo si se han enviado los datos del primero.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            .error{background-color:red; color:white; width:300px; padding-left: 5px;}
        </style>
    </head>
    <body>
        <?php
        echo '<h1>Suma de varios numeros</h1>';

        if (isset($_POST['send'])) {
            displayData();
        }
        displayPrimaryForm();
        if (isset($_POST['set'])){
            if (!is_numeric($_POST['n']) || $_POST['n'] <= 0){
                echo "<p class='error'>Introduce un número entero positivo</p>";
            }
        }
        if (isset($_POST['set'])){
            if (is_numeric($_POST['n']) && $_POST['n'] > 0){
                displaySecondaryForm();
            }
        }

        function displayPrimaryForm() {
            $var = (isset($_POST['n'])&&(!empty($_POST['n'])))?$_POST['n']:4;
            echo '<form method="POST" action="">';
            echo 'Número de elementos:<br>';
            echo "<input type='text' name='n' value='$var' /> ";
            echo '<input type="submit" value="Enviar" name="set" />';
            echo '</form><br>';
        }

        function displaySecondaryForm() {
            $max = $_POST['n'];
            echo '<form method="POST" action="">';
            for ($i = 0; $i < $max; $i++) {
                echo "$i <input type='text' name='suma[]' value='" . ($i + 1) . "' /><br>";
            }
            echo '<br><input type="submit" value="Enviar datos" name="send" />';
            echo '</form>';
        }

        function displayData() {
            $nums = $_POST['suma'];
            $total = count($nums);
            $suma = 0;
            echo "El vector tiene $total elementos<br>";
            for ($i = 0; $i < $total; $i++) {
                echo "$i = $nums[$i]<br>";
                $suma += $nums[$i];
            }
            echo "La suma es: $suma<br>";
        }
        ?>
    </body>
</html>
