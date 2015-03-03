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
$campos = array('dni', 'nombre', 'fechaalta', 'cuota');
if (isset($_POST["guardar"])) {
    procesForm();
} else {
    displayForm(array(), array(), false);
}