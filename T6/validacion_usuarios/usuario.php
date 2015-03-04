<?php

function procesFormLogin() {
    global $mensaje;
    global $enlace;
    $camposObligatorios = array("usuario", "clave");
    $camposPendientes = array();
    $camposErroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ0-9]{5,15}$/", $_POST["usuario"])) {
        $camposErroneos[] = "usuario";
    }
    if (isset($_POST["clave"]) && !empty($_POST["clave"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ0-9]{5,15}$/", $_POST["clave"])) {
        $camposErroneos[] = "clave";
    }
    if ($camposPendientes || $camposErroneos) {
        displayFormLogin($camposErroneos, $camposPendientes);
    } else {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $valores_campos['clave']['valor'] = $_POST['clave'];
        $valores_campos['clave']['operador'] = "=";
        $usuarioExiste = load($valores_campos, TABLA);
        if ($usuarioExiste) {
            $mensaje = "Validación realizada positivamente.";
            $enlace = "<a href='index.php'>Volver al login</a>";
        } else {
            $mensaje = "Usuario incorrecto.";
            $enlace = "<a href='index.php'>Volver a a intentarlo</a><br>
<a href='index.php?accion=registro'>Registrarse</a>";
        }
        visualizarResultado();
    }
}

function procesFormRegistro() {
    global $mensaje;
    global $enlace;
    $usuarioDuplicado = '';
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"])) {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $usuarioDuplicado = existe($valores_campos);
    }
    $camposObligatorios = array("usuario", "clave", "nombre", "apellidos", "email");
    $camposPendientes = array();
    $camposErroneos = array();
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
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-Z ñÑáéíóúÁÉÍÓÚuüÜÇç]+$/", $_POST["nombre"])) {
        $camposErroneos[] = "nombre";
    }
    if (isset($_POST["apellidos"]) && !empty($_POST["apellidos"]) && !preg_match("/^[a-zA-Z ñÑáéíóúÁÉÍÓÚuüÜÇç]+$/", $_POST["apellidos"])) {
        $camposErroneos[] = "apellidos";
    }
    /* if (isset ($_POST["email"]) && !empty($_POST["email"]) && !preg_match("/^[A-Za-z0-9_.\-]+@[A-Za-z0-9_.\-]+\.[A-Za-z]{2,3}$/",$_POST["email"])) {
      $camposErroneos[]="email";
      }
     */
    if (isset($_POST["email"]) && $_POST["email"]) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
            $camposErroneos[] = "email";
        }
    }
    if ($camposPendientes || $camposErroneos || $usuarioDuplicado) {
        displayFormRegistro($camposErroneos, $camposPendientes, $usuarioDuplicado);
    } else {
        foreach ($camposObligatorios as $campo) {
            $valor = $_POST["$campo"];
            $valores_campos["$campo"]["valor"] = $valor;
        }
        $registro = guardar($valores_campos, TABLA);
        if ($registro) {
            $mensaje = "Usuario registrado";
            $enlace = "<a href='index.php'>Volver al login</a>";
        }
        visualizarResultado();
    }
}

function load($valores_campos, $tabla) {
    global $campos;
    global $tipos;
    $tipos = '';
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $key => $campo) {
        addSelect("$key");
    }
    foreach ($valores_campos as $campo => $valor) {
        $operador = $valor["operador"];
        $where = "$campo " . $operador . " ?";
        addWhere($where);
        addTipo($valor['valor']);
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

function guardar($valores_campos, $tabla) {
    global $tipos;
    $tipos = '';
    addTable($tabla);
    setFuncion("insert");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
//cuidado aquí pues $valores_campos es un array bidimensional;
        addTipo($valor['valor']);
    }
    $sql_insertar = generar();
    if (ejecutar($sql_insertar, $valores_campos, $tabla)) {
        return true;
    }
}

function existe($valores_campos) {
    $duplicado = '';
    $resultado = load($valores_campos, TABLA);
    if ($resultado) {
        $duplicado = 1;
    }
    return $duplicado;
}
