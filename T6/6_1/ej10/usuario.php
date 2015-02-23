<?php

function procesForm() {
    $camposObligatorios = array("nombre");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ0-9 ]{2,30}$/", $_POST["nombre"])) {
        $camposerroneos[] = "nombre";
    }
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $campo = 'nombre';
        $valor = $_POST["nombre"];
        $valores_campos["$campo"] = $valor;
        $producto = obtenerProducto($valores_campos, TABLA);
        visualizarDatos($producto);
    }
}

function load($valores_campos, $tabla) {
    addTable($tabla);
    setFuncion("select");
    addSelect('*');
    foreach ($valores_campos as $campo => $valor) {
        addWhere("$campo = ?");
        addTipo($valor);
    }
    $sql_select = generar();
    return ejecutar($sql_select, $valores_campos, $tabla);
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
