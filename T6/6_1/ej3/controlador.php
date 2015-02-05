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
$sql_tabla1 = "CREATE TABLE " . TABLA1 . "(" .
        "dni CHAR(9) PRIMARY KEY NOT NULL," .
        "nombre VARCHAR(50) NOT NULL," .
        "salario INT(5)" .
        ");";
$sql_tabla2 = "CREATE TABLE " . TABLA2 . "(" .
        "id INT NOT NULL AUTO_INCREMENT," .
        "dnitrabajador CHAR(9) NOT NULL," .
        "telefono CHAR(10)," .
        "PRIMARY KEY (id)," .
        "INDEX (dnitrabajador)," .
        "FOREIGN KEY (dnitrabajador) REFERENCES trabajadores(dni) ON UPDATE CASCADE ON DELETE CASCADE" .
        ");";
$sql_insertar1 = "INSERT INTO " . TABLA1 . " VALUES" .
        "('12345678z','Felipe', 1000)," .
        "('12121212z','Luis', 985)," .
        "('12312312a','Sandra', 1050);";
$sql_insertar2 = "INSERT INTO " . TABLA2 . " VALUES" .
        "(0,'12345678z','955970000')," .
        "(0,'12345678z','654332003')," .
        "(0,'12312312a','622012012')," .
        "(0,'12312312a','644111222');";
$sql_select1 = "SELECT * FROM " . TABLA1;
$sql_select2 = "SELECT * FROM " . TABLA2;
$mensajeBD = "";
$mensajeTabla = "";
$mensajeInsertar = "";
$mensajeDatos = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$salidaDatos = "";
$conexion = '';
if ($conexion = conexion()) {
    if (crearBD()) {
        if (crearTabla(TABLA1, $sql_tabla1)) {
            insertar($sql_insertar1);
            visualizarCampos(TABLA1, $sql_select1);
        }
        if (crearTabla(TABLA2, $sql_tabla2)) {
            insertar($sql_insertar2);
            visualizarCampos(TABLA2, $sql_select2);
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
