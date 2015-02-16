<?php

function procesForm() {
    global $enlace, $conexion;
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
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-Z][a-zA-Z ]+$/", $_POST["nombre"])) {
        $camposerroneos[] = "nombre";
    }
    if (isset($_POST["dni"]) && !empty($_POST["dni"]) && !preg_match("/^[0-9]{7,8}[a-zA-Z]$/", $_POST["dni"])) {
        $camposerroneos[] = "dni";
    }
    if ($campospendientes or $camposerroneos or $duplicado) {
        displayForm($camposerroneos, $campospendientes, $duplicado);
    } else {
        $valores_campos_trabajador['dni'] = $_POST['dni'];
        $valores_campos_trabajador['nombre'] = $_POST['nombre'];
        if ($_POST['salario'] == '')
            $valores_campos_trabajador['salario'] = "NULL";
        else
            $valores_campos_trabajador['salario'] = (int) $_POST['salario'];
        guardar($valores_campos_trabajador, TABLA1);
        if ($_POST['telefono1']) { //sin telefono no tiene sentido insertar en la tabla telefonos
            $valores_campos_telefono['dnitrabajador'] = $_POST['dni'];
            if ($_POST['telefono1'] == '')
                $valores_campos_telefono['telefono'] = "NULL";
            else
                $valores_campos_telefono['telefono'] = $_POST['telefono1'];
            guardar($valores_campos_telefono, TABLA2);
        }
        if ($_POST['telefono2']) { //sin telefono no tiene sentido insertar en la tabla telefonos
            $valores_campos_telefono['dnitrabajador'] = $_POST['dni'];
            if ($_POST['telefono2'] == '')
                $valores_campos_telefono['telefono'] = "NULL";
            else
                $valores_campos_telefono['telefono'] = $_POST['telefono2'];
            guardar($valores_campos_telefono, TABLA2);
        }
        $enlace = " <a href='index.php'>Ir al formulario de introducción de datos</a>";
        visualizarDatos();
    }
}

function guardar($valores_campos, $tabla) {
    addTable($tabla);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
        addTipo($valor);
    }
    $sql_insertar = generar();
    ejecutar($sql_insertar, $valores_campos, $tabla);
}

function load($valores_campos, $tabla) {
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addWhere("$campo = ?");
        addTipo($valor);
    }
    $sql_select = generar();
    return ejecutar($sql_select, $valores_campos, $tabla);
}

function existe($valor, $campo) {
    $duplicado = '';
    $valores_campos["$campo"] = $valor;
    $resultado = load($valores_campos, TABLA1);
    if ($resultado)
        $duplicado = 1;
    return $duplicado;
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
