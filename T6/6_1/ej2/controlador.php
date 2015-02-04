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
require_once("constantes.php");
require_once("funciones_modelo.php");
require_once("funciones_vista.php");
$sql_tabla = "CREATE TABLE " . TABLA . "(" .
        "isbn CHAR(15) UNIQUE," .
        "id int auto_increment PRIMARY KEY NOT NULL," .
        "titulo varchar(50) not null," . "fechaedicion date);";
$sql_insertar = "INSERT INTO " . TABLA . " VALUES" .
        "('12345678',0,'El Círculo','2003-10-2')," .
        "('12312312',0,'La Sombra','2000-12-22');";
$sql_select = "SELECT * FROM " . TABLA;
$mensajeBD = "";
$mensajeTabla = "";
$mensajeInsertar = "";
$mensajeDatos = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$salidaDatos = "";
$conexion = '';
if ($conexion = conexion()) {
    if (crearBD()){
        if (crearTabla()) {
            insertar();
            visualizarCampos();
        }
    }
    cerrarConexion();
}
$datos = array(
    "titulo" => TITULO,
    "mensajeBD" => $mensajeBD,
    "mensajeTabla" => $mensajeTabla,
    "mensajeInsertar" => $mensajeInsertar,
    "mensajeDatos" => $mensajeDatos,
    "salidaDatos" => $salidaDatos,
    "mensajeAbrirConexion" => $mensajeAbrirConexion,
    "mensajeCerrarConexion" => $mensajeCerrarConexion
);
$plantilla = "plantillas/plantilla.html";
$html = respuesta($datos, $plantilla);
print ($html);
