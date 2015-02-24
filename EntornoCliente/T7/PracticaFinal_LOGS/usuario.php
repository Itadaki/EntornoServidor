<?php

function procesForm() {
    global $enlace, $conexion, $id, $ref;

    //VALIDACIONES
//    if (isset($_POST["dni"]) && !empty($_POST["dni"])) {
//        $valor = $_POST["dni"];
//        $campo = 'dni';
//        $duplicado = existe($valor, $campo);
//    }
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
    if (isset($_POST["ap1"]) && !empty($_POST["ap1"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ ]+$/", $_POST["ap1"])) {
        $camposErroneos[] = "ap1";
    }
    if (isset($_POST["ap2"]) && !empty($_POST["ap2"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ ]+$/", $_POST["ap2"])) {
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

    foreach ($camposPendientes as $value) {
        echo "Pendiente: $value<br>";
    }
    foreach ($camposErroneos as $value) {
        echo "Error en $value<br>";
    }
    //ACCIONES A TOMAR
    //Algo mal
    if ($camposPendientes or $camposErroneos) {
        displayForm($camposErroneos, $camposPendientes, $duplicado);
    }
    //Todo bien
    else {
        $valores_campos_persona['dni'] = $_POST['dni'];
        $valores_campos_persona['nombre'] = $_POST['nombre'];
        $valores_campos_persona['ap1'] = $_POST['ap1'];
        $valores_campos_persona['ap2'] = $_POST['ap2'];
        $valores_campos_persona['email'] = $_POST['email'];
        $valores_campos_persona['telf'] = $_POST['telefono'];
        //Consulta si ya existe el viajero
        $persona = existePersona($valores_campos_persona, TABLA_PERSONAS);
        echo $persona;
        if (!$persona) {
            echo "<h2>ha entrado en !persona</h2>";
            guardar($valores_campos_persona, TABLA_PERSONAS);
            $persona = existePersona($valores_campos_persona, TABLA_PERSONAS);
        }
    echo "<h1>ID{$persona['id']}</h1>";
    echo "<h1>ORIGEN{$persona['origen']}</h1>";
    $ref = generarReferencia();
        $valores_campos_referencia['referencia'] = $ref;
//        $valores_campos_referencia['persona'] = $persona['id'];
        $valores_campos_referencia['persona'] = $id;
        $valores_campos_referencia['origen'] = $_POST['origen'];
        $valores_campos_referencia['destino'] = $_POST['destino'];
        guardar($valores_campos_referencia, TABLA_REFERENCIAS);

        $enlace = " <a href='index.php'>Ir al formulario de introducción de datos</a>";
        visualizarDatos();
    }
}

function existePersona($valores_campos, $tabla) {
    $trace = debug_backtrace();
    $caller = $trace[1];
    echo "Called by {$caller['function']} <br>";
    if (isset($caller['class']))
        echo " in {$caller['class']}";


    addTable($tabla);
    setFuncion("select");
    echo "<dt>valores_campos de existePersona:<br>";
    addSelect('id');
    foreach ($valores_campos as $campo => $valor) {
        addSelect($campo);
        addWhere("$campo = ?");
        addTipo($valor);
        echo "$campo:$valor<br>";
    }
    $sql_select = generar();
    echo $sql_select . '<br><br><br>';
    $resultados = ejecutar($sql_select, $valores_campos, $tabla);
    if (count($resultados) == 1) {
        echo '<h1>HAY RESULTADOS</h1>';
        return $resultados;
    } else {
        echo '<h1>NO HAY RESULTADOS</h1>';
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

    $trace = debug_backtrace();
    $caller = $trace[1];
    echo "Called by {$caller['function']} <br>";
    if (isset($caller['class']))
        echo " in {$caller['class']}";


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
    $resultado = load($valores_campos, TABLA_PERSONAS);
    if ($resultado)
        $duplicado = 1;
//    $valores_campos=array();
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

function generarReferencia() {
    $micro = microtime();
    $arr = explode(' ', $micro);
    $ref = $arr[1] . explode('.', $arr[0])[1] . chr(rand(65, 90));
    return $ref;
}
