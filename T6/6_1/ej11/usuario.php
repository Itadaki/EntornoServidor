<?php

function procesForm() {
    global $campos;
    global $valores_campos;
    $camposObligatorios = array("codigo");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["codigo"]) && !empty($_POST["codigo"]) && !preg_match("/^[LR][0-9]{5}$/", $_POST["codigo"])) {
        $camposerroneos[] = "codigo";
    }
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $campo = 'codigo';
        $valor = $_POST["codigo"];
        $valores_campos["$campo"] = $valor;
//añade precio y cantidad a la variable global $campos si el usuario selecciona las opciones adecuandas en el formulario
        if (isset($_POST['mostrarprecio'])) {
            $campos[] = 'precio';
        }
        if (isset($_POST['mostrarcantidad'])) {
            $campos[] = 'cantidad';
        }
        $producto = obtenerProducto(TABLA);
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
    echo $sql_select;
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
