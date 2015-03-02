<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("usuarioVista.php");
require_once("MySQL.php");
require_once("SQL.php");
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
$campos = array('id', 'asignatura', 'nota', 'curso', 'alumno');
if (isset($_POST["consultar"])) {
    procesForm();
} else {
    displayForm(array(), array());
}