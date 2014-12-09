<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 27-oct-2014
Licencia = gpl30 
Version = 1.0
Descripcion = Examen PHP1
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pizzeria</title>
        <style type="text/css">
            .error{
                background-color: red; 
                color: white; 
                padding-left: 5px; 
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <h1>PIZZACARA. La pizza más cara de España (y por tanto del mundo)</h1>
        <?php
        include_once 'formularios.php';
        include_once 'procesadores.php';

        if (filter_has_var(INPUT_POST, 'enviar_datos')) {
            procesarDatos();
        } elseif (filter_has_var(INPUT_POST, 'enviar_pizza')) {
            procesarPizza();
        } else {
            formularioDatos('Borja Pijerez Osea', 'Serranillo', '1', 'A', 'Madrid');
        }
        ?>
    </body>
</html>
