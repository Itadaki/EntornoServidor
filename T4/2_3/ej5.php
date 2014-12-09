<!DOCTYPE html>
<!--
Crea un programa que permita visualizar parejas de números de la siguiente manera. 
Utiliza dos funciones (procesarFormulario y VisualizarFormulario).
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST['send'])){
            displayData();
        } else { 
            displayForm();
        }
        
        function displayData(){
            echo '<p>LISTA DE PARES:</p>';
            $inicio = $_POST['inicio'];
            $fin = $_POST['fin'];
            for ($i = $inicio, $f=$fin; $i <= $fin, $f >= $inicio; $i++, $f--) {
                echo "($i, $f) ";
            }
            echo '<br><a href="ej5.php">Volver</a>';
        }


        function displayform() {
            echo 'LISTA DE NUMEROS<br>';
            ?>
            <form method="POST" action="">
                Número entero menor <input type="text" name="inicio" value="15" /><br>
                Número entero mayor <input type="text" name="fin" value="56" /><br>
                <input type="submit" value="Enviar datos" name="send" />
            </form>
            <?php
        }
        ?>
    </body>
</html>
