<?php

session_start();
include ("funciones.php");
include("constantes.php");
if (isset($_POST["login"])) {
    login();
    echo 'login';
} elseif (isset($_GET["action"]) and $_GET["action"] == "logout") {
    logout();
    echo 'logout';
} elseif (isset($_SESSION["username"])) {
    displayPagina();
    echo 'pagina';
} else {
    displayForm();
    echo 'form';
}