<?php

session_start();
$usuarios = array();
$usuarios['juan'] = 'secretjuan';
$usuarios['pepe'] = 'secretpepe';
$usuarios['maria'] = 'secretmaria';
require_once("constantes.php");
require_once("funciones.php");
$productos = array(
    1 => array(
        "cod" => 1,
        "nom" => "Peras",
        "precio" => 3,
        "unidades" => 1
    ),
    2 => array(
        "cod" => 2,
        "nom" => "Manzanas",
        "precio" => 2,
        "unidades" => 1
    ),
    3 => array(
        "cod" => 3,
        "nom" => "Plátanos",
        "precio" => 2,
        "unidades" => 1
    ),
    4 => array(
        "cod" => 4,
        "nom" => "Melocotones",
        "precio" => 4,
        "unidades" => 1
    ),
    5 => array(
        "cod" => 4,
        "nom" => "Naranjas",
        "precio" => 1,
        "unidades" => 1
    ),
);
if (!isset($_SESSION['username'])and ! isset($_POST["login"])) {
    displayLoginForm(array(), array());
} else {
    if (isset($_POST["login"]))
        procesForm();
    elseif (isset($_POST['salir']))
        logout();
    elseif (isset($_GET["action"]) and $_GET["action"] == "addItem")
        addItem();
    elseif (isset($_GET["action"]) and $_GET["action"] == "removeItem")
        removeItem();
    elseif (isset($_GET["action"]) and $_GET["action"] == "carro")
        displayCarro();
    else
        displayLista();
}
