<?php

function ejecutar($sql_insertar, $valores_campos) {
    global $funcion;
    global $conexion;
    global $tipos;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql_insertar);
//la función mysqli_stmt_bind_param() necesita referencias cuando se utiliza con call_user_func_array()
        $ejecucion = array(&$consulta, &$tipos);
        foreach ($valores_campos as $key => $valor) {
            $ejecucion[] = &$valores_campos[$key];
        }
        call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        /* El uso de esta función podría equivaler a: mysqli_stmt_bind_param($consulta, 'ssisss', $nombre, $sexo, $edad, $sistema, $aficiones, $futbol);
         */
        if ($funcion == "insert") {
            insertar($consulta, TABLA);
        }
        cerrarConexion();
    }
}

function conexion() {
    global $mensajeAbrirConexion;
    $conexion = @mysqli_connect(SERVIDOR, USUARIO, PASSWORD);
    $numerror = mysqli_connect_errno();
    $descrerror = mysqli_connect_error();
    if ($numerror == 0) {
        $mensajeAbrirConexion = "<h2>Conexión establecida con el servidor</h2>";
    } else {
        $mensajeAbrirConexion = "<h2>No se ha podido establecer la conexión con el servidor. Se ha producido un error nº $numerror que corresponde a: $descrerror</h2>";
    }
    return $conexion;
}

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (@mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> Conexión cerrada con exito</h2><br>";
    } else {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function insertar($consulta, $tabla) {
    global $conexion;
    global $mensajeInsertar;
    if (!@mysqli_stmt_execute($consulta)) {
        $mensajeInsertar.= "<h2>Imposible almacenar los datos en $tabla. Error al insertar los datos.</h2>";
        $numerror = mysqli_connect_errno();
        $descrerror = mysqli_connect_error();
        if ($numerror == 1062) {
            $mensajeInsertar.= "<b>No ha podido añadirse el registro. Ya existe el registro</b>";
        } else {
            $mensajeInsertar.= "<b>Se ha producido un error nº $numerror que corresponde a: $descrerror </b><br>";
        }
    } else {
        $mensajeInsertar.= "<h3>Datos almacenados en la base de datos satisfactoriamente.</h3>\n";
    }
}
