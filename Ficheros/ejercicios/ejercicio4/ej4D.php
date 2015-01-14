<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 14-ene-2015
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

displayDatos();

function displayDatos() {
    if (isset($_GET['path'])) {
        if (is_dir($_GET['path'])) {
            recorrer($_GET['path']);
        }
    } else {
        recorrer();
    }
}

function recorrer($path = '.') {
    echo "<h1>Contenido del directorio '$path'</h1>";
    $dir = opendir($path);
    $files = array();
    while (false !== ($file = readdir($dir))) {
        if ($file != "." && $file != "..") {
            if (is_dir($path.'/'.$file)) {
                $file .= "/";
            }
            $files[] = $file;
        }
    }
    sort($files);
    
    $archivo = fopen("lista.txt", "w+");
    foreach ($files as $value) {
        fwrite($archivo, $value . PHP_EOL);
    }
    rewind($archivo);
    
    while($linea = fgets($archivo)){
        if(is_dir(rtrim($path.'/'.$linea, PHP_EOL))){
            echo "<img src='./dir.png' width='10'>";
        } else {
            echo "<img src='./file.png' width='10'>";
        }
        echo "$linea</br>";
    }
    fclose($archivo);
}
