<?php

session_start();
include ("funciones.php");
include("constantes.php");
if (isset($_POST["login"])) {
    login();
} elseif (isset($_GET["action"]) and $_GET["action"] == "logout") {
    logout();
} elseif (isset($_SESSION["username"])) {
    displayPagina();
} else {
    displayForm();
}