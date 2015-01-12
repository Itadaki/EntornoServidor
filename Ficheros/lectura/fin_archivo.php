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

/* feof (indicador) -> devuelve true o false si el archivo a llegado al final
 * (end of file)
 */
$indicador = fopen('fichero.txt', 'r'); //Devuelve 'Resource id #3'
$i = 1;
while (!feof($indicador)) {
    echo $i++ .' '. fgets($indicador) .' <br/> ';
}