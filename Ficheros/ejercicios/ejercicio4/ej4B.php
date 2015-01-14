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

if (isset($_GET['path'])) {
    displayDatos($_GET['path']);
} else {
    displayDatos();
}

function displayDatos($path = '.') {
    echo "<h1>Contenido del directorio '$path'</h1>";

    if (is_dir($path)) {
        recorrer($path);
    } else {
        
    }
}

function recorrer($path) {
    $dir = opendir($path);
    $files = array();
    while (false !== ($file = readdir($dir))) {
        if ($file != "." && $file != "..") {
            if (is_dir($file)) {
                $file .= "/";
            }
            $files[] = $file;
        }
    }
    sort($files);
    foreach ($files as $value) {
        echo '<li>'.$value.'</li>';
    }
}
