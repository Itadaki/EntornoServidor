<?php

session_start();
$usuarios = array();
$usuarios['diego'] = 123;
$usuarios['juan'] = 'secretjuan';
$usuarios['pepe'] = 'secretpepe';
$usuarios['maria'] = 'secretmaria';
$nombreCookieVisitas = 'visitas';
require_once("constantes.php");
require_once("funciones.php");
$productos = array(
    1 => array(
        "codProd" => 1,
        "nomProd" => "Pera",
        "precio" => 3,
        "unidades" => 1
    ),
    2 => array(
        "codProd" => 2,
        "nomProd" => "Manzana",
        "precio" => 2,
        "unidades" => 1
    ),
    3 => array(
        "codProd" => 3,
        "nomProd" => "Plátano",
        "precio" => 2,
        "unidades" => 1
    ),
    4 => array(
        "codProd" => 4,
        "nomProd" => "Melocoton",
        "precio" => 4,
        "unidades" => 1
    ),
    5 => array(
        "codProd" => 5,
        "nomProd" => "Naranja",
        "precio" => 1,
        "unidades" => 1
    ),
);


//if (isset($_SESSION['username']) && isset($_POST["entrar"])) {
//    if (isset($_POST["entrar"])) {
//        procesForm();
//    } else if (isset($_POST['salir'])) {
//        logout();
//    } else if (isset($_GET["action"]) && $_GET["action"] == "addItem") {
//        addItem();
//    } else if (isset($_GET["action"]) && $_GET["action"] == "removeItem") {
//        removeItem();
//    } else if (isset($_GET["action"]) && $_GET["action"] == "carro") {
//        displayCarro();
//    } else {
//        displayLista();
//    }
//} else {
//    displayLoginForm();
//}

if (!isset($_SESSION['usuario']) && !isset($_POST["entrar"])) {
    displayLoginForm();
} else {
    if (isset($_POST["entrar"])) {
        procesForm();
    } else if (isset($_GET['salir'])) {
        logout();
    } else if (isset($_GET["action"]) && $_GET["action"] == "addItem") {
        addItem();
    } else if (isset($_GET["action"]) && $_GET["action"] == "removeItem") {
        removeItem();
    } else if (isset($_GET["action"]) && $_GET["action"] == "carro") {
        displayCarro();
    } else {
        displayLista();
    }
}
    