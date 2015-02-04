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

function conexion() {
    global $mensajeAbrirConexion;
    $conexion = @mysqli_connect(SERVIDOR, USUARIO, PASSWORD);
    $errorNo = mysqli_connect_errno();
    $errorMsg = mysqli_connect_error();
    if ($errorNo == 0) {
        $mensajeAbrirConexion = "<h2>Conexión establecida con el servidor</h2>";
    } else {
        $mensajeAbrirConexion = "<h2>No se ha podido establecer la conexión con el servidor. Se ha producido un error nº $errorNo que corresponde a: $errorMsg</h2>";
    }
    return $conexion;
}

function crearBD() {
    $operacion = true;
    global $conexion, $mensajeBD;
    $consulta = "SELECT COUNT(*) as existe_bd FROM
INFORMATION_SCHEMA.schemata
WHERE schema_name='" . BD . "'";
    $resultado = mysqli_query($conexion, $consulta);
    $valor = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    if (!$valor['existe_bd']) {
#si la base de datos no existe la creamos y escribimos el mensaje de exito
        $consulta = "CREATE DATABASE IF NOT EXISTS " . BD;
        mysqli_query($conexion, $consulta);
        $errorNo = mysqli_connect_errno();
        $errorMsg = mysqli_connect_error();
        if ($errorNo == 0) {
            $mensajeBD = "<h2>Base de datos creada correctamente.</h2>";
        } else {
            $operacion = false;
            $mensajeBD = "<h2>Error al crear la base de datos.Se ha producido un error nº $errorNo que corresponde a: $errorMsg </h2>";
        }
#si existe, avisamos de su existencia y evitamos intentar crearla
    } else {
        $mensajeBD = "<h2> La base de datos ya existe</h2>";
    }
    return($operacion);
}

function crearTabla() {
    $operacion = true;
    global $conexion;
    global $mensajeTabla;
    global $sql_tabla;
#comprobamos si existe la tabla
    $consulta = "SELECT COUNT(*) as existe_tabla FROM
INFORMATION_SCHEMA.tables
WHERE table_schema='" . BD . "' and table_name='" . SOLOTABLA . "'";
    $resultado = mysqli_query($conexion, $consulta);
    $valor = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    if (!$valor['existe_tabla']) {
#si la tabla no existe la creamos y escribimos el mensaje de exito
//        $consulta = "CREATE TABLE " . TABLA . "(
//isbn CHAR(15) UNIQUE,
//id int auto_increment PRIMARY KEY NOT NULL,
//título varchar(50) not null,
//fechaedición date)";
        @mysqli_query($conexion, $sql_tabla);
        $errorNo = mysqli_connect_errno();
        $errorMsg = mysqli_connect_error();
        if ($errorNo == 0) {
            $mensajeTabla = "<h2>Tabla creada correctamente.</h2>";
        } else {
            $operacion = false;
            $mensajeTabla = "<h2>Error al crear la tabla. Se ha producido un error nº $errorNo que corresponde a: $errorMsg</h2>";
        }
#si existe, avisamos de su existencia y evitamos intentar crearla
    } else {
        $mensajeTabla = "<h2> La tabla ya existe</h2>";
    }
    return($operacion);
}

function consultarCampos() {
    global $mensajeCampos;
    global $conexion;
    global $sql_select;
    $resultado = true;
    $consulta = "SHOW FIELDS from " . TABLA;
    $resultado = @mysqli_query($conexion, $consulta);
    $errorNo = mysqli_connect_errno();
    $errorMsg = mysqli_connect_error();
    if ($errorNo == 0) {
        $mensajeCampos = "<h2>Datos visualizados correctamente</h2>";
    } else {
        $mensajeCampos = "<h2>Se ha producido un error nº $errorNo que corresponde a: $errorMsg </h2>";
        $resultado = false;
    }
    return ($resultado);
}

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (@mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> Conexión cerrada con exito</h2>";
    } else {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function insertar(){
    global $conexion;
    global $sql_insertar;
    $resultado = true;
    $resultado = @mysqli_query($conexion, $sql_insertar);
    $errorNo = mysqli_connect_errno();
    $errorMsg = mysqli_connect_error();
    if ($errorNo == 0) {
        $mensajeCampos = "<h2>Datos almacenados correctamente</h2>";
    } else {
        $mensajeCampos = "<h2>Se ha producido un error nº $errorNo que corresponde a: $errorMsg </h2>";
        $resultado = false;
    }
    return ($resultado);
}