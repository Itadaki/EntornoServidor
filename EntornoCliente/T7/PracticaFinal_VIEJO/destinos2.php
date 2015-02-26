<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 23-feb-2015
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

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (@mysqli_close($conexion)) {
        $mensajeCerrarConexion .= "<h2> Conexión cerrada con exito</h2>";
    } else {
        $mensajeCerrarConexion .= "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function generarDestino($id_origen) {
    global $conexion;
    $query = "select id,nombre FROM billetes.ciudades where id in (select destino FROM billetes.viajes where origen='$id_origen')";
    $resultado = mysqli_query($conexion, $query);
    $errorNo = mysqli_errno($conexion);
    $errorMsg = mysqli_error($conexion);
    $ciudades = array();
    while ($campos = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $ciudades[] = array($campos['id'] => $campos['nombre']);
    }
    cerrarConexion();
    return $ciudades;
}

/*
 * <destinos>
 *   <ciudad>
 *     <id>  </id>
 *     <nombre>  </nombre>
 *   </ciudad>
 *   <ciudad>
 *     <id>  </id>
 *     <nombre>  </nombre>
 *   </ciudad>
 * </destinos>
 */
header('Content-Type: text/xml');
if (isset($_POST['origen']) && $conexion = conexion()) {
    $destinos = generarDestino($_POST['origen']);
    cerrarConexion();
    //Generar contenidos XML de respuesta
    $xml = '<destinos>';
    foreach ($destinos as $destino) {
        foreach ($destino as $id => $nombre) {
            $xml .= "<ciudad><id>$id</id><nombre>$nombre</nombre></ciudad>";
        }
    }
    $xml.='</destinos>';
    echo $xml;
} else {
    echo'<destinos/>';
}


