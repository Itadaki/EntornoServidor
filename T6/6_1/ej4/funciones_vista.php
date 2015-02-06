<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 30-ene-2015
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

function visualizarCampos($query) {
    global $salidaDatos;
    global $mensajeDatos;
    global $conexion;
    $resultado = @mysqli_query($conexion, $query);
    $errorNo = mysqli_errno($conexion);
    $errorMsg = mysqli_error($conexion);
    if ($errorNo == 0) {
        $mensajeDatos .= "<h2>Consulta realizada correctamente</h2>";
    } else {
        $mensajeDatos .= "<h2>Se ha producido un error nº $errorNo que corresponde a: $errorMsg </h2>";
    }
    $salidaDatos .= '<h3>Registro de la consulta</h3>';
    $num = mysqli_num_rows($resultado);
        $salidaDatos .= "<b>La tabla tiene $num entradas</b><br>";
    while ($campos = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $salidaDatos .='<b>Nombre</b> '. $campos['nombre'] . ' - <b>Telf</b> '.$campos['telefono'].'<br>';
    }
}

function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1)
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = '{' . $key1 . '}';
            $html = str_replace($cadena, $valor1, $html);
        }
    return $html;
}
