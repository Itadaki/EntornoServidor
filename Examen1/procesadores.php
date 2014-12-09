<?php
/**
* Autor = Diego Rodríguez Suárez-Bustillo
* Fecha = 27-oct-2014
* Licencia = gpl30 
* Version = 1.0
* Descripcion = Funciones para procesar los formularios
*/
function errorCampo($nombre_error) {
    echo "<p class='error'>Por favor, rellene el campo $nombre_error correctamente</p>";
}

function precioTotal($tamaño, $numero) {
    $precioBase = 0;
    if ($tamaño == 'Pequeña') {
        $precioBase = 30;
    }
    if ($tamaño == 'Mediana') {
        $precioBase = 45;
    }
    if ($tamaño == 'Grande') {
        $precioBase = 60;
    }
    return $precioBase + ($numero * 5);
}

function procesarDatos() {
    //Declaracion de variables
    //nombre, calle, numero, puerta, localidad, enviar_datos
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }
    $error = false;
    //Letras y espacios. 1er char no espacio
    $pattern_letrasEspacios = "/^[A-Za-z][A-Za-z ]+$/";
    //Solo 1 letra
    $pattern_1letra = "/^[A-Za-z]{1}$/";
    //Entre 1 y 3 numeros
    $pattern_3numeros = "/^[0-9]{1,3}$/";

    //Control de entrada
    if (!preg_match($pattern_letrasEspacios, $nombre)) {
        $error = true;
        errorCampo('Nombre');
    }
    if (!preg_match($pattern_letrasEspacios, $calle)) {
        $error = true;
        errorCampo('Calle');
    }
    if (!preg_match($pattern_letrasEspacios, $localidad)) {
        $error = true;
        errorCampo('Localidad');
    }
    if (!preg_match($pattern_1letra, $puerta)) {
        $error = true;
        errorCampo('Puerta');
    }
    if (!preg_match($pattern_3numeros, $numero)) {
        $error = true;
        errorCampo('Numero');
    }
    //Errores
    if ($error) {
        formularioDatos($nombre, $calle, $numero, $puerta, $localidad);
    } else {
        formularioPizza();
    }
}

function procesarPizza() {
    //Declaracion de variables
    //tamaño, ingredientes[], enviar_pizza
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    if (isset($ingredientes)) {
        $totalIngredientes = count($ingredientes);
        echo 'El número de ingredientes que has elegido es: <b>' . $totalIngredientes . '</b> y son los siguientes:';
        $frase = '';
        foreach ($ingredientes as $value) {
            $frase .= ' ' . $value . ',';
        }
        $frase[strlen($frase) - 1] = '.';
        echo '<b>' . $frase . '</b>';
        echo '<br>El <b>precio asciende</b> a la friolera de: <b>' . precioTotal($tamaño, $totalIngredientes) . ' Euros</b>.';
    } else {
        echo '<b>No has elegido ningun ingrediente</b>, así que el precio tan solo es de: <b>' . precioTotal($tamaño, 0) . ' Euros</b>.';
    }

    echo '<br><a href="pedido_pizzas.php">Volver</a>';
}
