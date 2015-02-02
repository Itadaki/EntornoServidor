<?php

session_start();
$usuarios = array(
    "diego" => 123,
    "paco" => 123
);
$nombreCookieVisitas = 'visitas';
$t_expiracion = time() + 600;
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
require_once("constantes.php");
require_once("funciones.php");

if (!isset($_SESSION['usuario']) && !isset($_POST["entrar"])) {
    displayLoginForm();
} else {
    if (isset($_POST["entrar"])) {
        procesForm();
    } else if (isset($_POST['logout'])) {
        logout();
    } else if (isset($_GET["action"])) {
        if ($_GET["action"] == "addItem") {
            addItem();
        } else if ($_GET["action"] == "removeItem") {
            removeItem();
        } else if ($_GET["action"] == "verCarro") {
            displayCarro();
        }
    } else {
        displayLista();
    }
}
    