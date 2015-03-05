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
require_once("MySQL.php");
require_once("SQL.php");
require_once("constantes.php");

function generarDestino($id_origen) {
    $conexion = conexion();
    $consulta = mysqli_stmt_init($conexion);
    mysqli_stmt_prepare($consulta, "select destino FROM billetes.viajes where origen=$id_origen");
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $destino);
    $arrDestinos = array();
    while (mysqli_stmt_fetch($consulta)) {
        $arrDestinos[] = $destino;
    }
    $destinos = implode(',', $arrDestinos);
    mysqli_stmt_prepare($consulta, "select id,nombre FROM billetes.ciudades where id in ($destinos)");
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $idDestino, $nombreDestino);
    $destinos = array();
    while (mysqli_stmt_fetch($consulta)) {
        $destinos[$idDestino] = $nombreDestino;
    }
    cerrarConsulta($consulta);
    return $destinos;
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
if (isset($_GET['origen'])) {
    $origen = $_GET['origen'];
    $destinos = generarDestino($origen);

    //Generar contenidos XML de respuesta
    $xml = '<destinos>';

    foreach ($destinos as $id => $nombre) {
        $xml .= "<ciudad><id>$id</id><nombre>$nombre</nombre></ciudad>";
    }
    $xml.='</destinos>';
    echo $xml;
} else {
    echo'<destinos/>';
}


