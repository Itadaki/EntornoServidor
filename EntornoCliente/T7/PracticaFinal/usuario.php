<?php

function procesForm() {
    global $enlace, $conexion;
    $duplicado = '';

    //VALIDACIONES
    if (isset($_POST["dni"]) && !empty($_POST["dni"])) {
        $valor = $_POST["dni"];
        $campo = 'dni';
        $duplicado = existe($valor, $campo);
    }
    $camposObligatorios = array("nombre", "dni", "ap1", "ap2", "telefono", "email", "origen", "destino");
    $camposPendientes = array();
    $camposErroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ ]+$/", $_POST["nombre"])) {
        $camposErroneos[] = "nombre";
    }
    if (isset($_POST["ap1"]) && !empty($_POST["ap1"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ\u002D ]+$/", $_POST["ap1"])) {
        $camposErroneos[] = "ap1";
    }
    if (isset($_POST["ap2"]) && !empty($_POST["ap2"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ\u002D ]+$/", $_POST["ap2"])) {
        $camposErroneos[] = "ap2";
    }
    if (isset($_POST["dni"]) && !empty($_POST["dni"]) && !preg_match("/^[0-9]{7,8}[a-zA-Z]$/", $_POST["dni"])) {
        $camposErroneos[] = "dni";
    }
    if (isset($_POST["telefono"]) && !empty($_POST["telefono"]) && !preg_match("/^[9|6]\d{8}$/", $_POST["telefono"])) {
        $camposErroneos[] = "telefono";
    }
    if (isset($_POST["email"]) && !empty($_POST["email"]) && !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $_POST["email"])) {
        $camposErroneos[] = "email";
    }
    if (isset($_POST["origen"]) && !empty($_POST["origen"]) && !preg_match("/^\d{1,2}$/", $_POST["origen"])) {
        $camposErroneos[] = "origen";
    }
    if (isset($_POST["destino"]) && !empty($_POST["destino"]) && !preg_match("/^\d{1,2}$/", $_POST["destino"])) {
        $camposErroneos[] = "destino";
    }
    
    foreach ($camposErroneos as $value) {
        echo "Error en $value<br>";
    }
    foreach ($camposPendientes as $value) {
        echo "Pendiente: $value<br>";
    }

    //ACCIONES A TOMAR
    //Algo mal
    if ($camposPendientes or $camposErroneos or $duplicado) {
        displayForm($camposErroneos, $camposPendientes, $duplicado);
    }
    //Todo bien
    else {
        $valores_campos_persona['dni'] = $_POST['dni'];
        $valores_campos_persona['nombre'] = $_POST['nombre'];
        $valores_campos_persona['ap1'] = $_POST['ap1'];
        $valores_campos_persona['ap2'] = $_POST['ap2'];
        $valores_campos_persona['email'] = $_POST['email'];
        $valores_campos_persona['telf'] = $_POST['telf'];
        //Consulta si ya existe el viajero
        $persona = existePersona($valores_campos_persona, TABLA_PERSONAS);
        if (!$persona) {
            guardar($valores_campos_persona, TABLA_PERSONAS);
            $persona = existePersona($valores_campos_persona, TABLA_PERSONAS);
        }

        $valores_campos_referencia['persona'] = $persona['id'];
        $valores_campos_referencia['origen'] = $_POST['origen'];
        $valores_campos_referencia['destino'] = $_POST['destino'];
        $valores_campos_referencia['referencia'] = getReferencia();
        guardar($valores_campos_referencia, TABLA_REFERENCIAS);

        $enlace = " <a href='index.php'>Ir al formulario de introducción de datos</a>";
        visualizarDatos();
    }
}

function existePersona($valores_campos, $tabla) {
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addValue("?");
        addTipo($valor);
    }
    $sql_insertar = generar();
    $resultados = ejecutar($sql_insertar, $valores_campos, $tabla);
    if (count($resultados)==1){
        return $resultados;
    } else {
        return false;
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
