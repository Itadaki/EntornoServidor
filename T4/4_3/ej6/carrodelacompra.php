<?php

$productos = array(
    1 => array(
        "codProd" => 1,
        "nomProd" => "Samosas de verduras",
        "descripcion" => "Deliciosas empanadillas",
        "precio" => 8,
        "unidades" => 1
    ),
    2 => array(
        "codProd" => 2,
        "nomProd" => "Croquetas de Espinacas",
        "descripcion" => "Crujientes croquetas",
        "precio" => 9,
        "unidades" => 1
    ),
    3 => array(
        "codProd" => 3,
        "nomProd" => "Pakoras",
        "descripcion" => "Verduras variadas",
        "precio" => 9,
        "unidades" => 1
    ),
    4 => array(
        "codProd" => 4,
        "nomProd" => "Rollitos de queso",
        "descripcion" => "Crujientes rollitos",
        "precio" => 10,
        "unidades" => 1
    ),
    5 => array(
        "codProd" => 5,
        "nomProd" => "Keema Samosa",
        "descripcion" => "Deliciosas empanadillas crujientes",
        "precio" => 11,
        "unidades" => 1
    )
);

function addItem() {
    global $productos;
    if (isset($_GET["codProd"])) {
        $codProd = (int) $_GET["codProd"];
        if (!isset($_SESSION["carro"][$codProd])) {
            $_SESSION["carro"][$codProd] = $productos[$codProd];
        } else {
            $_SESSION["carro"][$codProd]["unidades"] ++;
        }
    }
    session_write_close();
    header("Location: login.php");
}

function removeItem() {
    global $productos;
    if (isset($_GET["codProd"])) {
        $codProd = (int) $_GET["codProd"];
        if (isset($_SESSION["carro"][$codProd])) {
            if ($_SESSION["carro"][$codProd]["unidades"] > 1) {
                $_SESSION["carro"][$codProd]["unidades"] --;
            } else {
                unset($_SESSION["carro"][$codProd]);
            }
        }
    }
    session_write_close();
    header("Location: login.php?action=carro");
}

function displayCarro() {
    global $productos;
    $totalPrecio = 0;
    $productosCarro = "";
    $productosLista = "";
    $enlace = "";
    foreach ($_SESSION["carro"] as $producto) {
        $codProd = $producto["codProd"];
        $totalPrecio += $producto["precio"] * $producto["unidades"];
        $enlace = "<a href=\"login.php?action=removeItem&amp;codProd=$codProd\"><img src='img/delete.png' width='20' /></a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => '[UDs: ' . $producto["unidades"] . '] ' . number_format($producto["precio"] * $producto["unidades"], 2) . '€',
            "descripcion" => $producto["descripcion"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto_carro.html";
        $producto = respuesta($datos, $plantilla);
        $productosCarro.=$producto;
    }
    $datos = array(
        "productosCarro" => $productosCarro,
        "totalPrecio" => number_format($totalPrecio, 2) . '€',
        "enlace" => $enlace,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/carro.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function displayProductos() {
    global $productos;
    $totalPrecio = 0;
    $productosLista = "";
    foreach ($productos as $producto) {
        $codProd = $producto["codProd"];
        $enlace = "<a href=\"login.php?action=addItem&amp;codProd=$codProd\"><img src='img/carro.png' width='30' /></a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => number_format($producto["precio"], 2) . '€',
            "descripcion" => $producto["descripcion"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto_carro.html";
        $producto = respuesta($datos, $plantilla);
        $productosLista.=$producto;
    }
    $datos = array(
        "productosLista" => $productosLista,
        "totalPrecio" => number_format($totalPrecio, 2) . '€',
        "enlace" => $enlace,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/catalogo.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}
