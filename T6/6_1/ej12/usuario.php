<?php

function procesForm() {
    global $campos;
    global $valores_campos;
    $camposObligatorios = array("asignatura");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["asignatura"]) && !empty($_POST["asignatura"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ ]{2,50}$/", $_POST["asignatura"])) {
        $camposerroneos[] = "asignatura";
    }
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $campo = 'nota';
        $valor = 5;
        if ($_POST['nota'] == "suspensos") {
            $valores_campos["$campo"]["valor"] = $valor;
            $valores_campos["$campo"]["operador"] = '<';
        } elseif ($_POST['nota'] == "aprobados") {
            $valores_campos["$campo"]["valor"] = $valor;
            $valores_campos["$campo"]["operador"] = '>=';
        }
        $campo = 'asignatura';
        $valor = $_POST['asignatura'];
        $valores_campos["$campo"]["valor"] = $valor;
        $valores_campos["$campo"]["operador"] = '=';
        $campo = 'curso';
        $valor = $_POST['curso'];
        if ($valor != "todos" && $valor != "ninguno") {
            $valores_campos["$campo"]["valor"] = $valor;
            $valores_campos["$campo"]["operador"] = '=';
        }
        $notas = obtenerNotas($valores_campos,TABLA);
        visualizarDatos($notas);
    }
}

function load($valores_campos, $tabla) {
    global $campos;
//    global $valores_campos;
    addTable($tabla);
    setFuncion("select");
    foreach ($campos as $campo) {
        addSelect("$campo");
    }
    foreach ($valores_campos as $key1 => $valor1) {
        $campo = $key1;
        $operador = $valor1["operador"];
        $where = "$campo " . $operador . " ?";
        addWhere($where);
        addTipo($valor1['valor']);
    }
    $sql_select = generar();
    return ejecutar($sql_select,$valores_campos, $tabla);
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
