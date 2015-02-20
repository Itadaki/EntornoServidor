<?php

function getAll($tabla) {
    addTable($tabla);
    setFuncion("select");
    addSelect("*");
    $sql_select = generar();
    return ejecutar($sql_select, $valores_campos = array(), $tabla);
}

function modificarContador($valores_campos, $tabla) {
    addTable($tabla);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        addSelect("$campo=?");
        addValue("?");
        addTipo($valor);
    }
    $sql_update = generar();
    return ejecutar($sql_update, $valores_campos, $tabla);
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
