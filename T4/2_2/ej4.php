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
        if (isset($_POST['send'])) {
            processForm();
        } else {
            displayForm();
        }

        function processForm() {
            $nombres = $_POST['nombres'];
            echo '<h1>Los nombres introducidos son:</h1>';
            echo '<ul>';
            for ($i = 0; $i < count($nombres); $i++) {
                echo '<li>' . $nombres[$i] . '</li>';
            }
            echo '</ul>';
            echo '<br><a href="ej4.php">Volver</a>';
        }

        function displayForm() {
            ?>
            <h1>Introduce los nombres</h1>
            <form method="POST" action="">
                <input type="text" name="nombres[]" value="Patricia" /><br>
                <input type="text" name="nombres[]" value="Sergio" /><br>
                <input type="text" name="nombres[]" value="Diego" /><br>
                <input type="text" name="nombres[]" value="Alvaro" /><br>
                <input type="text" name="nombres[]" value="Paul" /><br>
                <input type="text" name="nombres[]" value="Daniel" /><br>
                <input type="submit" value="Enviar" name="send" /> <input type="reset" value="Borrar" name="del" />
            </form>
            <?php
        }
        ?>
    </body>
</html>
