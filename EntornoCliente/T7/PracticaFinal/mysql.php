<?php

function conexion() {
    global $mensajeAbrirConexion;
    $conexion = mysqli_connect(SERVIDOR, USUARIO, PASSWORD);
    $numerror = mysqli_connect_errno();
    $descrerror = mysqli_connect_error();
    if (!$numerror == 0) {
        $mensajeAbrirConexion = "<h2>No se ha podido establecer la conexión con el servidor. Se ha producido un error nº $numerror que corresponde a: $descrerror</h2>";
    }
    return $conexion;
}

function select($query) {
    global $conexion;
    $resultado = mysqli_query($conexion, $query);
    $errorNo = mysqli_errno($conexion);
    $errorMsg = mysqli_error($conexion);
    return $resultado;
}

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (!@mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}