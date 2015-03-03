<?php

function procesForm() {
    global $valores_campos;
    $duplicado = '';
    if (isset($_POST["dni"]) && !empty($_POST["dni"])) {
        $valor = $_POST["dni"];
        $campo = 'dni';
        $duplicado = existe($valor, $campo);
    }
    $camposObligatorios = array("nombre", "dni");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ ]{5,50}$/", $_POST["nombre"])) {
        $camposerroneos[] = "nombre";
    }
    if (isset($_POST["dni"]) && !empty($_POST["dni"]) && !preg_match("/^[0-9]{7,8}[a-zA-Z]$/", $_POST["dni"])) {
        $camposerroneos[] = "dni";
    }
    if (isset($_POST["fechaalta"]) && !empty($_POST["fechaalta"]) && !preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2}([0-9]{2})?$/", $_POST["fechaalta"])) {
        $camposerroneos[] = "fechaalta";
    }
    if (isset($_POST["cuota"]) && !empty($_POST["cuota"]) && !preg_match("/^[0-9]+(\,[0-9]{1,2})?$/", $_POST["cuota"])) {
        $camposerroneos[] = "cuota";
    }
    if ($campospendientes or $camposerroneos or $duplicado) {
        displayForm($camposerroneos, $campospendientes, $duplicado);
    } else {
        $valores_campos['dni']['valor'] = $_POST['dni'];
        $valores_campos['nombre']['valor'] = $_POST['nombre'];
        if (!empty($_POST["fechaalta"])) {
            $fechaalta_array = explode("/", $_POST['fechaalta']);
            $fechaalta = $fechaalta_array[2] . "-" . $fechaalta_array[1] . "-" . $fechaalta_array[0];
            $valores_campos['fechaalta']['valor'] = $fechaalta;
        }
        if (!empty($_POST["cuota"])) {
            $valores_campos['cuota']['valor'] = str_replace(",", ".", $_POST['cuota']);
        }
        guardar(TABLA);
        $socios = obtenerNotas(array(),TABLA);
        visualizarDatos($socios);
    }
}
function obtenerNotas($valores_campos, $tabla) {
    global $campos;
    global $mensaje;
    $resultado = load($valores_campos, TABLA);
//$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
    if (!$resultado && $mensaje) {
        visualizarError();
    } else {
        return $resultado;
    }
}
function existe($valor, $campo) {
    global $valores_campos;
    $duplicado = '';
    $valores_campos["$campo"]['valor'] = $valor;
    $valores_campos["$campo"]["operador"] = '=';
    $resultado = load($valores_campos, TABLA);
    if ($resultado) {
        $duplicado = 1;
    }
    return $duplicado;
}

function guardar($tabla) {
    global $valores_campos;
    addTable($tabla);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
//cuidado aquí pues $valores_campos es un array bidimensional;
        addTipo($valor['valor']);
    }
    $sql_insertar = generar();
//    echo $sql_insertar.'<br>';
    ejecutar($sql_insertar,$valores_campos, $tabla);
}

function load($valores_campos, $tabla) {
    global $campos;
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
//    echo $sql_select.'<br>';
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
