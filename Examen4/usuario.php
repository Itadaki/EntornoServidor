<?php

function procesFormLogin() {
    global $valores_campos, $mensaje, $enlace;
    $camposObligatorios = array("usuario", "clave");
    $camposPendientes = array();
    $camposErroneos = array();
    //Validacion de campos
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !preg_match("/^[a-zA-Z0-9]{5,15}$/", $_POST["usuario"])) {
        $camposErroneos[] = "usuario";
    }
    if (isset($_POST["clave"]) && !empty($_POST["clave"]) && !preg_match("/^[a-zA-Z0-9]{5,15}$/", $_POST["clave"])) {
        $camposErroneos[] = "clave";
    }
    //Si hay algun error
    if ($camposPendientes || $camposErroneos) {
        displayFormLogin($camposErroneos, $camposPendientes);
    }
    //Si esta todo correcto
    else {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $valores_campos['clave']['valor'] = $_POST['clave'];
        $valores_campos['clave']['operador'] = "=";
        //Comprobar que el usuario existe en la base de datos
        $existe = load(TABLA_LOGIN);
        if ($existe) {
            $visitas = getVisitas();
            $mensaje .= "</p>Validación realizada correctamente.<br>Eres la visita nº $visitas.</p>";
            $enlace = "<a href='index.php'>Volver al login</a>";
        } else {
            $mensaje .= "</p>Usuario incorrecto.</p>";
            $enlace = "<a href='index.php'>Volver al login</a>";
        }
        displaySalida();
    }
}

function procesFormRegistro() {
    global $valores_campos, $mensaje, $enlace;
    $duplicado = false;
    $camposObligatorios = array("usuario", "clave", "nombre", "apellidos", "email");
    $camposPendientes = array();
    $camposErroneos = array();
    //Comprobar si ya existe el usuario
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"])) {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $duplicado = existe();
    }
    //Validacion de campos
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !preg_match("/^[a-zA-Z0-9]{5,15}$/", $_POST["usuario"])) {
        $camposErroneos[] = "usuario";
    }
    if (isset($_POST["clave"]) && !empty($_POST["clave"]) && !preg_match("/^[a-zA-Z0-9]{5,15}$/", $_POST["clave"])) {
        $camposErroneos[] = "clave";
    }
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-Z ñÑáéíóúÁÉÍÓÚüÜÇç]+$/", $_POST["nombre"])) {
        $camposErroneos[] = "nombre";
    }
    if (isset($_POST["apellidos"]) && !empty($_POST["apellidos"]) && !preg_match("/^[a-zA-Z ñÑáéíóúÁÉÍÓÚüÜÇç]+$/", $_POST["apellidos"])) {
        $camposErroneos[] = "apellidos";
    }
    if (isset($_POST["email"]) && $_POST["email"]) {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $camposErroneos[] = "email";
        }
    }
    //Si hay algun error
    if ($camposPendientes || $camposErroneos || $duplicado) {
        displayFormRegistro($camposErroneos, $camposPendientes, $duplicado);
    }
    //Si esta todo correcto
    else {
        foreach ($camposObligatorios as $campo) {
            $valor = $_POST[$campo];
            $valores_campos[$campo]["valor"] = $valor;
        }
        if (guardar(TABLA_LOGIN)) {
            $mensaje .= "<p>Usuario registrado</p>";
            $enlace = "<a href='index.php'>Volver al login</a>";
        } else {
            $mensaje .= "<p>Se ha producido un error al registrar el usuario</p>";
            $enlace = "<a href='index.php?registrarse'>Volver a intentarlo</a>";
        }
        displaySalida();
    }
}

function getVisitas() {
    global $valores_campos, $enlace;
    $filas = getAll(TABLA_VISITAS);
    if ($filas) {
        //Me daba error con $filas[0]['vistas']
        //porque el indice array devuelto es el de addSelect, que es '*'
        $visitas = $filas[0]['*'] + 1;
        $valores_campos['visitas']['valor'] = $visitas;
        if (modificarContador()) {
            return $visitas;
        }
    }
    return 0;
}

function getAll($tabla) {
    addTable($tabla);
    setFuncion("select");
    addSelect("*");
    $sql_select = generar();
    return ejecutar($sql_select, $tabla);
}

function modificarContador() {
    global $valores_campos;
    addTable(TABLA_VISITAS);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        addSelect("$campo=?");
        addValue("?");
        addTipo($valor['valor']);
    }
    $sql_update = generar();
    return ejecutar($sql_update, $valores_campos, TABLA_VISITAS);
}

function guardar($tabla) {
    global $tipos, $valores_campos;
    $tipos = '';
    addTable($tabla);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
        addTipo($valor['valor']);
    }
    $sql_insertar = generar();
    return ejecutar($sql_insertar, $valores_campos, $tabla);
}

function existe() {
    if (load(TABLA_LOGIN)) {
        return true;
    }
    return false;
}

function load($tabla) {
    global $tipos, $valores_campos;
    $tipos = '';
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $key => $campo) {
        addSelect("$key");
    }
    foreach ($valores_campos as $key => $value) {
        $campo = $key;
        $operador = $value["operador"];
        $where = "$campo " . $operador . " ?";
        addWhere($where);
        addTipo($value['valor']);
    }
    $sql_select = generar();
    return ejecutar($sql_select, $tabla);
}
