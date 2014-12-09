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
            echo 'Gracias, ' . $_POST['nombre'] . ' ' . $_POST['apellidos'] . '<br>';
            if (isset($_POST['musica'])) {
                echo 'Te gusta: ';
                foreach ($_POST['musica'] as $v) {
                    echo $v . ', ';
                }
                echo'<br>';
            }
            echo (isset($_POST['novela']) ? 'Te' : 'No te') . ' gusta la novela negra.<br>';
            echo (isset($_POST['ciencia']) ? 'Te' : 'No te') . ' gusta la ciencia ficcion.<br>';
            echo (isset($_POST['fantasia']) ? 'Te' : 'No te') . ' gusta la fantasia.<br>';
            echo '<a href="ej3.php">Volver</a>';
        } else {
            displayForm();
        }

        function displayForm() {
            ?>
            <form method="POST" action="">
                <fieldset><legend><h1>Encuesta</h1></legend>
                    Escribe tu nombre: 
                    <input type="text" name="nombre" value="Diego" /><br>
                    Escribe tus apellidos: 
                    <input type="text" name="apellidos" value="Rodríguez" /><br>
                    Musica que te gusta <select name="musica[]" size="4" multiple="multiple">
                        <option selected>Pop</option>
                        <option selected>Rock</option>
                        <option>Regge</option>
                        <option>Clasica</option>
                    </select><br>
                    Libros que lees<br>
                    <input type="checkbox" name="novela" value="true" checked="checked" />Novela negra<br>
                    <input type="checkbox" name="ciencia" value="true" checked="checked" />Ciencia ficcion<br>
                    <input type="checkbox" name="fantasia" value="true" checked="checked" />Fantasia <br>
                </fieldset>
                <input type="submit" value="Enviar" name="send" /> 
            </form>
    <?php
}

//filter_has_var(INPUT_POST, "enviar")
//$_REQUEST[] (=post +get)
?>


    </body>
</html>
