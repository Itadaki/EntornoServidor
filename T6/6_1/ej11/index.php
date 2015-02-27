<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("usuarioVista.php");
require_once("MySQL.php");
require_once("SQL.php");
$campos = array('codigo', 'nombre');
$funcion = "";
$colWhere = array();
$colSelect = array();
$colFrom = array();
$ejecutar = array();
$colValue = array();
$tipos = "";
$conexion = "";
$mensaje = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$valores_campos = array();
$consulta = null;
if (isset($_POST["consultar"])) {
    procesForm();
} else {
    displayForm(array(), array());
}