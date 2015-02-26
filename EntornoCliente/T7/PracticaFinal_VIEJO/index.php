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
$mensajeInsertar = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$mensaje = '';
$enlace = "";
$consulta=null;
$valores_campos=array();
$cerrarConsulta='si';
$id = 0;
$ref = 0;
header('Content-Type: text/html; charset=utf-8');

if (isset($_POST["enviar"])) {
    procesForm();
} else {
    displayForm(array(), array(), 0);
}