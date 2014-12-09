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
        include 'funciones.php';
        if (isset($_REQUEST['send'])) {
            $n1 = $_REQUEST['n1'];
            $n2 = $_REQUEST['n2'];
            $n3 = $_REQUEST['n3'];
            $n4 = $_REQUEST['n4'];
            $n5 = $_REQUEST['n5'];
            echo "El numero mayor es " . \mayor($n1, $n2, $n3, $n4, $n5);
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <form method="POST" action="">
                n1 <input type="text" name="n1" value="5" /><br>
                n2 <input type="text" name="n2" value="8" /><br>
                n3 <input type="text" name="n3" value="2" /><br>
                n4 <input type="text" name="n4" value="3" /><br>
                n5 <input type="text" name="n5" value="9" /><br>
                <input type="submit" name="send" value="Enviar" />
            </form>
            <?php
        }
        ?>


    </body>
</html>
