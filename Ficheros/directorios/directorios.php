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

/* CONSEJOS
 * Si escribes php para windows, usa / como separador (y no \) y omite la unidad raiz (C:, E:, etc.)
 * En pos de la portabilidad
 */

/* ABRIR */
/* $indicador = opendir("/home/juan");
 * Abre el directorio pasado como parámetro. 
 * Devuelve un descriptor de directorio. 
 * Si existe un problema al abrir el directorio 
 * (por ejemplo, si el directorio no existe), 
 * opendir() devuelve false en lugar del indicador de directorio.
 */

$indicador1 = opendir("./directorio");

/* CERRAR */
/* closedir(indicador);
 * Cierra el directorio que corresponde al indicador
 */

closerdir($indicador1);

/* LEER */
/* readdir(indicador);
 * Devuelve el nombre de la siguiente entrada del directorio.
 * Las entradas son devueltas en el orden en que fueron almacenadas
 * por el sistema de ficheros.
 * Devuelve FALSE si llega al final
 */
$indicador = opendir("./directorio");
echo readdir($indicador) . '<br>';
echo readdir($indicador) . '<br>';
echo readdir($indicador) . '<br>';

/* Ejemplo de lectura total del directorio */
echo "Empieza el while<br>";
while (false !== ($entrada = readdir($indicador))) {
    echo "$entrada<br>";
}
echo readdir($indicador) . '<hr>'; //Esto lee false

/* MOVER PUNTERO ATRAS */
/* rewinddir($indicador);
 * Retrocede el puntero al principio
 */
rewinddir($indicador);
echo readdir($indicador) . '<br><hr>';

/* CAMBIAR DIRECTORIO */
/* chdir("/home/micarpeta");
 * devuelve true si PHP ha conseguido cambiar al directorio especificado, 
 * o false si hubo un error (como directorio no encontrado).
 * El directorio actual es el directorio donde PHP busca primero los archivos. 
 * Si especifica una ruta que no sea una ruta absoluta o relativa, 
 * PHP busca el archivo dentro del directorio actual. 
 * Por eso, el siguiente código:
 * chdir("/home/micarpeta");
 * $indicador = fopen("mifichero.txt");
 * abre el mismo archivo mifichero.txt como:
 * $indicador = fopen("/home/micarpeta/mifichero.txt");
 */

/* Estoy en EntornoServidor/Ficheros/directorios */
chdir(".."); //Me muevo a Ficheros
$indicador2 = opendir(".."); //Abro EntornoServidor
while (false !== ($entrada = readdir($indicador2))) {
    echo "$entrada<br>";
}
echo '<hr>';

/* DIRECTORIO ACTUAL */
/* getcwd();
 * Devuelve el directorio actual de trabajo
 */
chdir("./ejemplos");
echo getcwd().'<hr>';

/* CREAR DIRECTORIO */
/* mkdir(directorio);
 * Crea un directorio
 * Se pueden establecer permisos tipo linux
 */
mkdir("./nuevo_dir");
echo "Creado nuevo_dir<hr>";

/*BORRAR DIRECTORIO*/
/* rmdir(directorio);
 * Eimina el directorio
 * Debe estar vacio y tener permisos
 * Devuelve booleano
 */
rmdir("./nuevo_dir");
echo "Eliminado nuevo_dir<hr>";

/*OBTENER RUTA DE UN ARCHIVO*/
/* dirname(ruta);
 * Devuelve la parte del directorio de una ruta
 * Complementa a basename();
 */
echo "La parte del directorio de /home/pedro/docs/index.html es: ";
echo dirname("/home/pedro/docs/index.html").'<hr>';

/*ESPACIO LIBRE Y TOTAL*/
/* disk_free_space(directorio);
 * disk_total_space(directorio);
 * Devuelve los tamaños libre y total del directorio en bytes
 */
echo "Espacio libre en disco: " . disk_free_space('.') . ' bytes<hr>';