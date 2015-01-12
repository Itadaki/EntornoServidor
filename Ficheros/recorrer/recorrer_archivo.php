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
/* rewind (indicador): Sitúa el puntero de lectura/escritura al principio del fichero.*/

/*
 * fseek(indicador, desplaz[, desde_donde])
 * Desplaza la posición del puntero de lectura/escritura desplaz posiciones. 
 * El tercer parámetro puede tomar los valores SEEK_SET, SEEK_CUR y SEEK_END, 
 * lo que significará que los desplazamientos son relativos al principio 
 * del fichero, la posición actual del puntero o al final del fichero 
 * (entonces desplaz será negativo), respectivamente.
 */

/*ftell(indicador): Devuelve la posición del puntero.*/

$indicador = fopen("hola_mundo.txt", "r");
fseek($indicador, 5);
echo 'Indicador del puntero: ' . ftell($indicador) .'<br>';
echo fread($indicador, 5).'<br>'; // Visualiza “mundo”
rewind($indicador);
echo 'Indicador del puntero: ' . ftell($indicador) .'<br>';
fclose($indicador);
