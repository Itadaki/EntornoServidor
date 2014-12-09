<?php
// Generamos los valores que se van a especificar para la cookie
$nombre = 'Contador';
// Obtenemos el valor del contador (evitando warnings no deseados...)
if (!isset($_COOKIE[$nombre]))
    $veces = 1;
else
    $veces = $_COOKIE[$nombre] + 1;
// Expira el 01/01/2019 a las 00:00:00
$fecha_expiracion = mktime(0, 0, 0, 1, 1, 2019);
// Esta cookie sólo la verá el script actual
$path = $_SERVER['REQUEST_URI'];
// Ahora enviamos la cookie y después generamos el documento
setcookie($nombre, $veces, $fecha_expiracion, $path, '', 0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP: Contador de Accesos (cookies)</title>
    </head>
    <body>
        <h2 align="center">Contador de Accesos (cookies)</h2>
        <?php
        if ($veces == 1) // Es la primera vez
            echo "Bienvenido por primera vez a nuestra página\n";
        else
            echo "Has visitado nuestra página $veces veces\n";
        ?>
        <br />Pulsa <a href=''>aquí</a> para volver a visitarnos...
    </body>
</html>
