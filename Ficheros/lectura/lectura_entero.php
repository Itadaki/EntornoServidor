<?php

/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 09-ene-2015
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

/*file(nombre_fichero [,ruta_busqueda]) -> Lee todo el fichero y devuelve un array con las lineas*/
$indicador = fopen('fichero.txt', 'r');
$array = file('fichero.txt');

for ($i = 0; $i < count($array); $i++) {
    echo $array[$i] . '<br>';
}

/*file_get_contents(nombre_fichero [,ruta_busqueda],[desde donde], [,total_chars_a_leer])
 Similar a file() solo que devuelve el contenido del fichero en una cadena.*/

$cadena = file_get_contents('fichero.txt');
echo $cadena;

/*readfile(nombre_fichero [,ruta_busqueda] ) 
 *Lee el contenido de un fichero y lo muestra por la salida estándar.*/
readfile('fichero.txt');

/*
 * fpassthru (indicador): 
 * Igual a readfile(), excepto en que el parámetro que necesita es un descriptor 
 * de fichero, en que lee y muestra a partir de donde se encuentre la posición 
 * del puntero de lectura y que necesita que previamente se abra el fichero 
 * (con fopen()). Cierra automáticamente el fichero.
 */

fpassthru($indicador);