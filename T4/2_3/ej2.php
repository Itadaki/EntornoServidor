<!DOCTYPE html>
<!--
Crea un programa que permita introducir a través de formulario 8 números que 
almacenará en un array y después obtendrá el resultado de la suma. 
Como en el anterior, define dos funciones. En esta ocasión utilizarás un array 
pero en lugar de declarar uno a uno los elementos del formulario con el nombre 
de cada elemento del array, utilizarás el siguiente bucle:
for ($i=0; $i<$n; $i++){
echo $i;
echo "<input type = 'text' name = 'vec[]' size='10'>";
echo "<br>";
}
Ten en cuenta que para hacer referencia a una variable de tipo array dentro de 
la superglobal $_POST es: $_POST["vec"].
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
