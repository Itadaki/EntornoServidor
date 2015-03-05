<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("usuarioVista.php");
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
$valores_campos = array();
$consulta = null;
$enlace;
if (isset($_POST["login"])) {
    procesFormLogin();
} elseif (isset($_GET["registrarse"])) {
    displayFormRegistro();
} elseif (isset($_POST["registrar"])) {
    procesFormRegistro();
} else {
    displayFormLogin();
}