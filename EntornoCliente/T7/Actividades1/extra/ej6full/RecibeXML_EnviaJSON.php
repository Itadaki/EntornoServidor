<?php

/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 12-feb-2015
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = Este documento
 *  RECIBE  ENVIA
 *   XML    JSON
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

$a[1][1] = "Valladolid";
$a[1][2] = "Burgos";
$a[1][3] = "León";
$a[1][4] = "Palencia";
$a[1][5] = "Zamora";
$a[2][1] = "Toledo";
$a[2][2] = "Albacete";
$a[3][1] = "Valencia";
$a[3][2] = "Castellón";
$a[3][3] = "Alicante";

//RECIBIR
$entrada = fopen('php://input', 'r');
$datos = fgets($entrada);
$doc = new DOMDocument();
$doc->loadXML($datos);
$comunidad_nodo = $doc->getElementsByTagName("comunidad");
$comunidad = $comunidad_nodo->item(0)->nodeValue;

//ENVIAR
header('Content-Type: application/json');
// Generar contenidos JSON de respuesta
$json = array("ciudades" => array());
$ciudades = $a[$comunidad];
foreach ($ciudades as $ciudad) {
    $json["ciudades"][] = $ciudad;
}
echo json_encode($json);
