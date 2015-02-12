<?php

function procesForm() {
    global $enlace, $conexion;
    $camposObligatorios = array("nombre");
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
    if ($campospendientes or $camposerroneos) {
        displayForm($camposerroneos, $campospendientes);
    } else {
        $valores_campos['nombre'] = $_POST['nombre'];
        $valores_campos['sexo'] = $_POST['sexo'];
        $valores_campos['sistema'] = $_POST['sistema'];
        $valores_campos['aficiones'] = $_POST['aficiones'];
        if ($_POST['edad'] == '')
            $valores_campos['edad'] = "NULL";
        else
            $valores_campos['edad'] = (int) $_POST['edad'];
        if (!isset($_POST['futbol'])) // Si no se marcó la casilla fútbol...
            $valores_campos['futbol'] = "N";
        else
            $valores_campos['futbol'] = $_POST['futbol'];
        guardarUsuario($valores_campos);
    }
    $enlace = "<a href='index.php'>Ir al formulario de introducción de datos</a>";
    visualizarDatos();
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
