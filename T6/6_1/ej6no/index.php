<?php

require_once("constantes.php");
require_once("trabajador.php");
require_once("trabajadorVista.php");
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
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$enlace = "";
if (isset($_POST["enviar"])) {
    procesForm();
} else {
    displayForm(array(), array(), array());
}