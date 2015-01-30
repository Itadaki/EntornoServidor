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

function consultarCampos() {
    global $mensajeCampos;
    global $conexion;
    $campos = array();
    $consulta = "SHOW FIELDS from " . TABLA;
    $resultado = @mysqli_query($conexion, $consulta);
    $numerror = mysqli_connect_errno();
    $descrerror = mysqli_connect_error();
    if ($numerror <> 0) {
        $mensajeCampos = "<h2>Se ha producido un error nº $numerror que corresponde a: $descrerror <br><h2>";
    }
    return ($resultado);
}

function crearBD() {
    $operacion = true;
    global $conexion, $mensajeBD;
    $consulta = "SELECT COUNT(*) as existe_bd FROM INFORMATION_SCHEMA.schemata WHERE schema_name='" . BD . "'";
    $resultado = mysqli_query($conexion, $consulta);
    $valor = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    if (!$valor['existe_bd']) {
#si la base de datos no existe la creamos y escribimos el mensaje de exito
#si existe, avisamos de su existencia y evitamos intentar crearla
        $consulta = "CREATE DATABASE IF NOT EXISTS " . BD;
        mysqli_query($conexion, $consulta);
        $numerror = mysqli_connect_errno();
        $descrerror = mysqli_connect_error();
        if ($numerror == 0) {
            $mensajeBD = "<h2>Base de datos creada correctamente.</h2>";
        } else {
            $operacion = false;
            $mensajeBD = "<h2>Error al crear la base de datos.Se ha producido un error nº $numerror que corresponde a: $descrerror </h2>";
        }
    } else
        $mensajeBD = "<h2> La base de datos ya existe</h2>";
    return($operacion);
}

function conexion() {
    if($conexion = mysqli_connect(SERVIDOR, USUARIO, PASSWORD)){
        //Conexion establecida
        $mensajeAbrirConexion = 'Conexion establecida';
    } else {
        $mensajeAbrirConexion = 'Error de conexion';
    }
    return $conexion;
}

function crearTabla() {
    global $conexion;
    $consulta = "CREATE TABLE " . TABLA . " (id INTEGER UNSIGNED NOT NULL 
 		AUTO_INCREMENT,nombre VARCHAR(40), sexo VARCHAR(6), 
                edad TINYINT(2), sistema VARCHAR(9), aficiones VARCHAR(140), 
                futbol CHAR(1) PRIMARY KEY(id))";

    if (mysqli_query($conexion, $consulta)) {
        //Creada correctamente
        $mensajeTabla = "Tabla creada correctamente";
    } else {
        //Error al crear
        $mensajeTabla = "Trror al crear la tabla";
    }

    function cerrarConexion() {
        global $conexion, $mensajeCerrarConexion;
        if (mysqli_close($conexion)) {
            //Cerrada correctamente
            $mensajeCerrarConexion='Cerrada correctamente';
        } else {
            //Error al cerrar conexion
            $mensajeCerrarConexion ='Error al cerrar conexion';
        };
    }

}

function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1) {
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = "{" . $key1 . "}";
            $html = str_replace($cadena, $valor1, $html);
        }
    }
    return $html;
}
