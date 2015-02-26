<?php

require_once("constantes.php");
require_once("usuario.php");
require_once("usuarioVista.php");
require_once("mysql.php");
require_once("sql.php");
$mensajeInsertar = "";
$mensajeCerrarConexion = "";
$mensajeAbrirConexion = "";
$mensaje = '';
$enlace = "";
header('Content-Type: text/html; charset=utf-8');
if ($conexion = conexion()) {
    if (isset($_POST["enviar"])) {
        procesForm();
    } elseif(isset ($_GET['ver'])) {
        ver();
    } else {
        displayForm(array(), array());
    }
    cerrarConexion();
}