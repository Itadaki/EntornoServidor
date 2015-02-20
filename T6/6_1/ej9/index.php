<?php

require_once("constantes.php");
require_once("contador.php");
require_once("contadorVista.php");
require_once("mysql.php");
require_once("sql.php");
$funcion = "";
$colWhere = array();
$colSelect = array();
$colFrom = array();
$ejecutar = array();
$colValue = array();
$tipos = "";
$conexion = "";
$mensaje = "";
$consulta = null;
$valores_campos = array();
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$fila = obtenerContador(); // Obtener primera (y única) fila.
if ($fila) {
    $valorcontador = $fila["visitas"]; // Obtener primer campo de la tabla ($fila[o]).
    $valorcontador++; // Lo incrementamos (pues somos una nueva visita).
    $imagenes = ""; // Cadena que contendrá las imágenes en html de las cifras.
    for ($i = 0; $i < strlen($valorcontador); $i++) {
        $imgnum = substr($valorcontador, $i, 1); // Tomamos cada cifra: 0, 1, 2...
// Mostraremos (con img) el archivo gif de cada cifra: 'img/0.gif', 'img/1.gif', ...
        $imagenes .= "<img alt='$imgnum' border='0' src='img2/" . $imgnum . ".jpg' align='middle'>";
    }
    visualizarPagina($imagenes);
    $valores_campos['visitas'] = $valorcontador;
    aumentarContador($valores_campos);
}