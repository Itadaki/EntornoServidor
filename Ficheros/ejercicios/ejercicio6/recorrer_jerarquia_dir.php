<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <title>Mostrar el contenido de un directorioy</title>
        <style>
            h2,ul{background: rgba(60,0,100,0.05)}
            h2{margin-bottom: 0}
        </style>
    </head>
    <body>
        <h1>Mostrar el contenido de un directorio</h1>
        <?php
        if(isset($_GET['path']) && is_dir($_GET['path'])){
            $dirPath = $_GET['path'];
        } else {
        $dirPath = ".";
        }

        /**
         * @description Funcion recursiva - Recorre toda la jerarquia de directorios
         * @param type $dir
         */
        function recorrerDir($dir) {
            echo "<h2>Listando '$dir' </h2>";
            //Abrir el directorio - Si no, fin del script
            if (!($indicador = opendir($dir))) {
                die("No se puede abrir $dir.");
            }
            //Alberga lista de nombres de archivos en el directorio
            $files = array();
            //Lee el directorio y añade al array
            while ($file = readdir($indicador)) {
                if ($file != "." && $file != "..") {
                    //Si es directorio le añadimos / al final para que el usuario sepa
                    if (is_dir($dir . "/" . $file)) {
                        $file .= "/";
                    }
                    $files[] = $file;
                }
            }
            //Ordenar alfabeticamente
            sort($files);
            echo "<ul>";
            //Visualizar array files
            foreach ($files as $file) {
                echo "<li>$file</li>";
            }
            
            //Busca en la lista aquel que tena / en el nombre y le aplica recursividad
            foreach ($files as $file) {
                if (substr($file, -1) == "/") {
                    recorrerDir("$dir/" . substr($file, 0, -1));
                }
            }
            echo "</ul>";
            closedir($indicador);
        }

        recorrerDir($dirPath);
        ?>
    </body>
</html>