<?php

require_once("constantes.php");
require_once("coche.php");
require_once("cocheVista.php");
require_once("mysql.php");
require_once("sql.php");
$colFrom = array();
$ejecutar = array();
$colValue = array();
$colUpdate = array();
$colWhere = array();
$tipos = "";
$conexion = "";
$mensaje = "";
$enlace;
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
if (isset($_POST["guardar_coche"])) {
    procesForm("insercion");
} elseif (isset($_POST["guardar_modificacion"])) {
    procesForm("modificacion");
} elseif (isset($_POST["eliminar"])) {
    procesForm("eliminacion");
} elseif (isset($_POST["buscar"])) {
    procesForm("buscar");
} elseif (isset($_POST["editar"])) {
    displayFormEditar();
} elseif (isset($_GET["accion"]) && $_GET["accion"] == "insertar") {
    displayFormInsertar();
} elseif (isset($_GET["accion"]) && $_GET["accion"] == "buscar") {
    displayFormBuscar();
} else {
    displayFormInicio();
}