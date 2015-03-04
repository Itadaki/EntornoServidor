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
$enlace;
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
if (isset($_POST["login"]))
    procesFormLogin();
elseif (isset($_GET["accion"]) and $_GET["accion"] == "registro")
    displayFormRegistro(array(), array(), array());
elseif (isset($_POST["registrar"]))
    procesFormRegistro();
else
    displayFormLogin(array(), array());