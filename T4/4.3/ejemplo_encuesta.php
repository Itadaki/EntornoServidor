<html>
    <head>
        <title>Encuesta</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        include ("funciones_relleno.php");
        include("formulario.php");
        if (isset($_POST["enviar"]) && !empty($_POST["nombreUsuario"]) && preg_match("/^[a-zA-Z][a-zAZ ]+$/", $_POST["nombreUsuario"]) && !empty($_POST["apellidos"]) && preg_match("/^[a-zA-Z][a-zA-z]+$/", $_POST["apellidos"])) {
            procesForm();
        } else {
            displayForm();
        }

        function procesForm() {
            $userName = $_POST["nombreUsuario"];
            $apellidos = $_POST["apellidos"];
            $tipoMusica = "";
            $tipoLibros = "";
            if (isset($_POST["tipoMusica"])) {
                foreach ($_POST["tipoMusica"] as $musica) {
                    $tipoMusica.= $musica . ", ";
                }
            }
            if (isset($_POST["tipoLibros"])) {
                foreach ($_POST["tipoLibros"] as $libro) {
                    $tipoLibros.= $libro . ", ";
                }
            }
// preg.replace() sustituye la coma y el espacio en blanco al final (“/, $/”) por nada (“”)
            $tipoMusica = preg_replace("/, $/", "", $tipoMusica);
            $tipoLibros = preg_replace("/, $/", "", $tipoLibros);
            print "<h2>Hola, $userName $apellidos!</h2> \n";
            ?><dl>
            </dd>
            <dt>Te gusta escuchar esta música:</dt><dd>
                <?php
                if (isset($_POST["tipoMusica"])) {
                    echo $tipoMusica;
                }
                ?></dd>
            <dt>Y te gusta este tipo de literatura:</dt><dd>
                <?php
                if (isset($_POST["tipoLibros"])) {
                    echo $tipoLibros;
                }
                ?></dd>
        </dl>
<?php } ?>
</body>
</html>