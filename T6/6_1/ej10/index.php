<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("UsuarioVista.php");
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
$valores_campos = array();
if (isset($_POST["consultar"])) {
    procesForm();
} else {
    displayForm(array(), array());
}