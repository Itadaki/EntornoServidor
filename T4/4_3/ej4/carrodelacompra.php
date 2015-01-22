<?php

include("constantes.php");
session_start();
$productos = array(
    1 => array(
        "codProd" => 1,
        "nomProd" => "Samosas de verduras",
        "descripcion"=>"Deliciosas empanadillas",
        "precio" => 8
    ),
    2 => array(
        "codProd" => 2,
        "nomProd" => "Croquetas de Espinacas",
        "descripcion"=>"Crujientes croquetas",
        "precio" => 9
    ),
    3 => array(
        "codProd" => 3,
        "nomProd" => "Pakoras",
        "descripcion"=>"Verduras variadas",
        "precio" => 9
    ),
    4 => array(
        "codProd" => 4,
        "nomProd" => "Rollitos de queso",
        "descripcion"=>"Crujientes rollitos",
        "precio" => 10
    ),
    5 => array(
        "codProd" => 5,
        "nomProd" => "Keema Samosa",
        "descripcion"=>"Deliciosas empanadillas crujientes",
        "precio" => 11
    )
);
if (!isset($_SESSION["carro"]))
    $_SESSION["carro"] = array();
if (isset($_GET["action"]) and $_GET["action"] == "addItem") {
    addItem();
} elseif (isset($_GET["action"]) and $_GET["action"] == "removeItem") {
    removeItem();
} else {
    displayCarro();
}

function addItem() {
    global $productos;
    if (isset($_GET["codProd"])) {
        $codProd = (int) $_GET["codProd"];
        if (!isset($_SESSION["carro"][$codProd])) {
            $_SESSION["carro"][$codProd] = $productos[$codProd];
        }
    }
    session_write_close();
    header("Location: carrodelacompra.php");
}

function removeItem() {
    global $productos;
    if (isset($_GET["codProd"])) {
        $codProd = (int) $_GET["codProd"];
        if (isset($_SESSION["carro"][$codProd])) {
            unset($_SESSION["carro"][$codProd]);
        }
    }
    session_write_close();
    header("Location: carrodelacompra.php");
}

function displayCarro() {
    global $productos;
    $totalPrecio = 0;
    $productosCarro = "";
    $productosLista = "";
    foreach ($_SESSION["carro"] as $producto) {
        $codProd = $producto["codProd"];
        $totalPrecio += $producto["precio"];
        $enlace = "<a href=\"carrodelacompra.php?action=removeItem&amp;codProd=$codProd\">Eliminar producto del carro</a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => number_format($producto["precio"], 2).'€',
            "descripcion" => $producto["descripcion"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto_carro.html";
        $producto = respuesta($datos, $plantilla);
        $productosCarro.=$producto;
    }
    foreach ($productos as $producto) {
        $codProd = $producto["codProd"];
        $enlace = "<a href=\"carrodelacompra.php?action=addItem&amp;codProd=$codProd\">Añadir producto al carro</a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => number_format($producto["precio"], 2).'€',
            "descripcion" => $producto["descripcion"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto_carro.html";
        $producto = respuesta($datos, $plantilla);
        $productosLista.=$producto;
    }
    $datos = array(
        "productosCarro" => $productosCarro,
        "productosLista" => $productosLista,
        "totalPrecio" => number_format($totalPrecio, 2).'€',
        "enlace" => $enlace
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function respuesta($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}
