<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 13-ene-2015
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = 
 */

/*
 * Copyright (C) 2015 Diego Rodríguez Suárez-Bustillo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* Para no tener que hacerlo a mano creo el fichero aqui */
$f = fopen("fichero.txt", "w");
fwrite($f, "Primera linea con texto extra" . PHP_EOL);
fwrite($f, "Segunda linea" . PHP_EOL);
fwrite($f, "Tercera linea" . PHP_EOL);
fwrite($f, "Cuarta linea" . PHP_EOL);
fclose($f);

/* 1. Abre el fichero fichero.txt en modo lectura.
  (tiene 4 lineas) */
$indicador = fopen("fichero.txt", "r");

/* 2. Visualiza el contenido y el número de caracteres del fichero 
 * fichero.txt (tiene 4 líneas de texto) con una función que lea 
 * todo el contenido del fichero y que precise la apertura previa de este. 
 * Cierra el fichero. */
echo "<h1>2. Visualiza el contenido y el número de caracteres del fichero</h1>";
$parcialChar = 0;
$totalChar = 0;
while ($char = fgetc($indicador)) {
    echo $char;
    if ($char === "\n") {
        //No se porque no funciona PHP_EOL y si "\n"
        echo " ($parcialChar)<br>";
        $parcialChar = 0;
    }
    $parcialChar++;
    $totalChar++;
}
echo "Numero de caracteres: $totalChar";

/* 3. Visualiza una a una las líneas del fichero. */
echo "<h1>3. Visualiza una a una las líneas del fichero</h1>";
rewind($indicador);
while ($linea = fgets($indicador)) {
    echo $linea . '<br>';
}

/* 4. Sitúa el puntero al principio del fichero. */
rewind($indicador);

/* 5. Visualiza el contenido del fichero desde el carácter 15. */
echo "<h1>5. Visualiza el contenido del fichero desde el carácter 15.</h1>";
fseek($indicador, 15, SEEK_SET);
$parcialChar = 0;
$totalChar = 0;
while ($char = fgetc($indicador)) {
    echo $char;
    if ($char === "\n") {
        //No se porque no funciona PHP_EOL y si "\n"
        echo " ($parcialChar)<br>";
        $parcialChar = 0;
    }
    $parcialChar++;
    $totalChar++;
}

/* 6. Coloca el puntero al comienzo del fichero. */
rewind($indicador);
/* 7. Visualiza la primera línea. */
echo "<h1>7. Visualiza la primera línea.</h1>";
echo fgets($indicador) . '<br>';
/* 8. Visualiza la posición actual del fichero. */
echo "<h1>8. Visualiza la posición actual del fichero.</h1>";
echo "Posicion actual del puntero: " . ftell($indicador);

/* 9. Cierra el fichero. */
fclose($indicador);

/* 10. Visualiza el contenido del fichero y su número de caracteres 
 * con una función que no requiera la apertura previa. */
echo "<h1>10. Visualiza el contenido del fichero y su número de caracteres</h1>";
$cadena = file_get_contents('fichero.txt');
echo "Caracteres totales del fichero: " . strlen($cadena);

/* 11. Almacena el contenido del fichero en una variable array 
 * y después visualiza el contenido de esta (utiliza foreach()). 
 * Utiliza una función que lea todo el fichero 
 * y devuelva el contenido en forma de array, es decir, 
 * cada línea del fichero es un elemento del array. */
echo "<h1>11. Almacena el contenido del fichero en un array y visualizalo</h1>";
$array = file('fichero.txt');
foreach ($array as $value) {
    echo $value . '<br>';
}

/*12. Copia el fichero en otro llamado copia.txt. 
 * Visualiza un mensaje si ha habido problemas con la copia 
 * y otro si la copia se ha realizado sin problemas.*/
echo "<h1>12. Copia el fichero en otro llamado copia.txt</h1>";
if (copy("fichero.txt", "copia.txt")){
    $mensaje = "Copia realizada correctamente";
} else {
    $mensaje = "Error en la copia del archivo";
}
echo $mensaje;

/*13. Renombra la copia por el nombre otraCopia.txt 
 * con mensajes similares al punto anterior.*/
echo "<h1>13. Renombra la copia por el nombre otraCopia.txt</h1>";
if (rename("copia.txt", "otraCopia.txt")){
    $mensaje = "Renombrado realizado correctamente";
} else {
    $mensaje = "Error en el renombrado del archivo";
}
echo $mensaje;

/*14. Elimina otraCopia.txt.*/
unlink("otraCopia.txt");

/*15. Visualiza la fecha y hora de la última modificación de fichero.txt 
 * (utiliza las funciones date() y filemtime()) 
 * y el tamaño del fichero.*/
echo "<h1>15. Visualiza la fecha y hora de la última modificación de fichero.txt</h1>";
echo "Ultima modificacion ". date('H:i:s A \d\e\l d/m/Y ', filemtime("fichero.txt"));