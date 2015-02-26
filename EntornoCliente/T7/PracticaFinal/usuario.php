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
    if (isset($_POST["ap1"]) && !empty($_POST["ap1"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][-a-zA-ZáéíóúÁÉÍÓÚ ]+$/", $_POST["ap1"])) {
        $camposErroneos[] = "ap1";
    }
    if (isset($_POST["ap2"]) && !empty($_POST["ap2"]) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ][-a-zA-ZáéíóúÁÉÍÓÚ ]+$/", $_POST["ap2"])) {
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
        displayForm($camposErroneos, $camposPendientes);
    }
    //Todo bien
    else {
        //INSERTAR LA PERSONA
        $valores = "'{$_POST['dni']}','{$_POST['nombre']}','{$_POST['ap1']}','{$_POST['ap2']}','{$_POST['email']}','{$_POST['telefono']}'";
        $insert_query = 'insert into ' . TABLA_PERSONAS . " values ($valores)";
        //Si esta duplicado el DNI no dejara
        mysqli_query($conexion, $insert_query);
        $ref = generarReferencia();
        $valores = "'$ref','{$_POST['dni']}',{$_POST['origen']},{$_POST['destino']},null";
        $insert_query = 'insert into ' . TABLA_REFERENCIAS . " values ($valores)";
        mysqli_query($conexion, $insert_query);

        $enlace = " <a href='index.php'>Volver al formulario de introducción de datos</a>";
        visualizarDatos();
    }
}

function generarReferencia() {
    $micro = microtime();
    $arr = explode(' ', $micro);
    $ref = $arr[1] . explode('.', $arr[0])[1] . chr(rand(65, 90));
    return $ref;
}
