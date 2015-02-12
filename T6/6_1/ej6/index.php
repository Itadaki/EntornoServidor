<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("UsuarioVista.php");
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
$mensajeInsertar = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$enlace = "";
if (isset($_POST["enviar"])) {
    procesForm();
} else {
    displayForm(array(), array());
}