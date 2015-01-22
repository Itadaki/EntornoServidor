<?php

session_start();
include ("funciones.php");
include ("carrodelacompra.php");
include("constantes.php");
if (isset($_POST["login"])) {
    login();
} elseif (isset($_GET["action"]) and $_GET["action"] == "logout") {
    logout();
} elseif (isset($_SESSION["username"])) {
    if (!isset($_SESSION["carro"]))
        $_SESSION["carro"] = array();
    if (isset($_GET["action"]) and $_GET["action"] == "addItem") {
        addItem();
    } elseif (isset($_GET["action"]) and $_GET["action"] == "removeItem") {
        removeItem();
    } else {
        displayCarro();
    }
} else {
    displayForm();
}
