<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <title>Contador</title>
    </head>
    <body>
        <h1>Un sencillo contador</h1>
        <?php
        $fichContador = "./contador.dat";
        if (!file_exists($fichContador)) {
            if (!($indicador = fopen($fichContador, "w"))) {
                die("No puede crearse el fichero contador.");
            } else {
                fwrite($indicador, 0);
                fclose($indicador);
            }
        }
        if (!($indicador = fopen($fichContador, "r"))) {
            die("No puede leerse el fichero contador.");
        }
        $contador = (int) fread($indicador, 20);
        fclose($indicador);
        $contador++;
        echo "<p>Usted es el visitante no. $contador.</p>";
        if (!($indicador = fopen($fichContador, "w"))) {
            die("No se puede abrir el fichero contador para escritura.");
        }
        fwrite($indicador, $contador);
        fclose($indicador);
        ?>
    </body>
</html>