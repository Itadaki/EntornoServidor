<?php

function procesForm() {
    global $enlace, $conexion;
    $camposObligatorios = array("nombre", "dni");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-Z][a-zA-Z ]+$/", $_POST["nombre"])) {
        $camposerroneos[] = "nombre";
    }
    if (isset($_POST["dni"]) && !empty($_POST["dni"]) && !preg_match("/^[0-9]{8}[a-zA-Z]{1}$/", $_POST["dni"])) {
        $camposerroneos[] = "dni";
    }
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $valores_campos['nombre'] = $_POST['nombre'];
        $valores_campos['dni'] = $_POST['dni'];
        $valores_campos['salario'] = $_POST['salario'];
        $valores_campos['telf'] = $_POST['telf'];
        guardarUsuario($valores_campos);
        $enlace = "<a href='index.php'>Ir al formulario de introducción de datos</a>";
        visualizarDatos();
    }
//    $enlace = "<a href='index.php'>Ir al formulario de introducción de datos</a>";
//    visualizarDatos();
}

function guardarUsuario($valores_campos) {
    addTable(TABLA);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
        addTipo($valor);
    }
    $sql_insertar = generar();
    ejecutar($sql_insertar, $valores_campos);
}

function addTipo($campo) {
    global $tipos;
    switch (gettype($campo)) {
        case "integer":
            $tipos.="i";
            break;
        case "double":
            $tipos.="d";
            break;
        case "string":
            $tipos.="s";
            break;
    }
}
