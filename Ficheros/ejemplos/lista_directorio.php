<html>
    <head>
        <title>Mostrar el contenido de un directorio</title>
    </head>
    <body>
        <h1>Mostrar el contenido de un directorio</h1>
        <?php
        $dirPath = ".";
        if (!($indicador = opendir($dirPath))) {
            die("No puede abrirse el directorio");
        }
        ?>
        <p><?php echo $dirPath ?> contiene los siguientes ficheros y carpetas:</p>
        <ul>
            <?php
            /* Como la lectura se hace en el orden de creacion
             * Para que salgan ordenados alfabeticamente
             * Guardo los nombres en un array y lo ordeno
             */
            $entradas = array();
            while ($fichero = readdir($indicador)) {
                $entradas[] = $fichero;
            }
            closedir($indicador);
            sort($entradas);
            foreach ($entradas as $fichero) {
                if ( $fichero != "." && $fichero != ".." ) {
                    echo "<li>$fichero</li>";
                }
            }
            ?>
        </ul>
    </body>
</html>