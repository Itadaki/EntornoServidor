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

/*COPIAR*/
/*copy("./origen.txt", "./destino.txt");*/

$indicador = fopen( "./origen.txt", "w");
fwrite($indicador, "origen");
fclose ($indicador);

copy("./origen.txt", "./destino.txt");


/*RENOMBRAR*/
/*rename("./nombre1.txt", "./nombre2.txt");*/
$indicador2 = fopen( "./nombre1.txt", "w");
fwrite($indicador2, "nombre original del archivo: nombre1.txt");
fclose ($indicador2);
rename("./nombre1.txt", "./nombre2.txt");

/*MOVER*/
/*rename("./movido.txt", "./carpeta/movido.txt");*/
$indicador3 = fopen( "./mover.txt", "w");
fwrite($indicador3, "archivo movido desde el raiz");
fclose ($indicador3);
rename("./mover.txt", "./carpeta/mover.txt");

/*ELIMINAR*/
/*unlink("./borrar.txt");*/
$indicador4 = fopen( "./borrar.txt", "w");
fwrite($indicador4, "archivo para borrar");
fclose ($indicador4);
unlink("./borrar.txt");