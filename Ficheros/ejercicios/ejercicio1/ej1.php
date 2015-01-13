<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
<?php

/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 12-ene-2015
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

/* 1 Abre el archivoFich1.txt para lectura y escritura. 
 * Cualquier contenido de archivo existente se perderá. 
 * Si el archivo no existe, se crea.*/
$indicador = fopen("fich1.txt", "w+");

//2 Escribe en el fichero: "Esta es la primera línea que escribimos en el fichero".
fwrite($indicador, "Esta es la primera línea que escribimos en el fichero");
echo "<h2>Este es el resultado después del primer fwrite</h2>";

//3 Cierra el fichero. Visualiza el contenido del fichero.
fclose($indicador);
echo fgets(fopen("fich1.txt", "r"));

/*4 Abre el fichero de forma que cuando escribas en el fichero la frase: 
 * “Esto se sobreescribe” se escriba al principio del fichero sobreescribiendo 
 * el contenido del fichero.*/
$indicador1 = fopen("fich1.txt", "r+");
fwrite($indicador1, "Esto se sobreescribe");
fclose($indicador1);
echo "<h2>Este es el resultado después del segundo fwrite</h2>";
echo fgets(fopen("fich1.txt", "r"));

/*5 Abre el fichero de forma que al añadir la frase: 
 * "Esto se añadirá al final", que añadirá al final del fichero.*/
$indicador2 = fopen("fich1.txt", "a");
fwrite($indicador2, "Esto se añade al final");
fclose($indicador2);
echo "<h2>Este es el resultado después del tercer fwrite</h2>";
echo fgets(fopen("fich1.txt", "r")).'<br>';

/*6. Abre el fichero, lee el primer carácter del fichero y visualízalo*/
$indicador3 = fopen("fich1.txt", "r");
for ($i = 0; $i < 3; $i++) {
    echo "Caracter número $i: ".fgetc($indicador3).'<br>';
}
fclose($indicador3);

/*11. Abre el fichero y visualiza todo el contenido.*/
$indicador4 = fopen("fich1.txt", "r");
readfile("fich1.txt");