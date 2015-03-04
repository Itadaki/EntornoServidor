<?php

function ejecutar($sql, $tabla) {
    global $funcion;
    global $conexion;
    global $tipos;
    global $valores_campos;
    global $consulta;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql);
//la función mysqli_stmt_bind_param() necesita referencias cuando se utiliza con call_user_func_array()
        if ($tipos) {
            $ejecucion = array(&$consulta, &$tipos);
            foreach ($valores_campos as $key => $valor) {
                $ejecucion[] = &$valores_campos[$key]['valor'];
            }
//            print_r($ejecucion);
            call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        }
        return ejecutarConsulta($tabla);
//        cerrarConexion();
    }
}

function conexion() {
    global $mensajeAbrirConexion;
    $conexion = mysqli_connect(SERVIDOR, USUARIO, PASSWORD);
    $errno = mysqli_connect_errno();
    $error = mysqli_connect_error();
    if (!$errno == 0) {
        $mensajeAbrirConexion = "<h2>No se ha podido establecer la conexión con el servidor. Se ha producido un error nº $errno que corresponde a: $error</h2>";
    }
    return $conexion;
}

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (!mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function ejecutarConsulta($tabla) {
    global $conexion;
    global $funcion;
    global $mensaje;
    global $colSelect;
    global $consulta;
    $campos = array();
    if ($funcion == 'insert')
        $operacion = 'insertar';
    elseif ($funcion == 'select')
        $operacion = 'seleccionar';
    elseif ($funcion == 'update')
        $operacion = 'modificar';
    if (!mysqli_stmt_execute($consulta)) {
        $mensaje.= "<h2>Imposible $operacion los datos en $tabla. Error al $operacion los datos.</h2>";
        $errno = mysqli_errno($conexion);
        $error = mysqli_error($conexion);
        if ($errno == 1062) {
            $mensaje.= "<b>No ha podido añadirse el registro. Ya existe el registro</b>";
        } else {
            $mensaje.= "<b>Se ha producido un error nº $errno que corresponde a: $error  </b><br>";
        }
        return false;
    } else {
        if ($funcion == 'select') {
            $datos = array();
            $campos = array($consulta);
            $columnas = $colSelect;
            foreach ($columnas as $key => $valor) {
                $campos["$valor"] = &$columnas[$key];
            }
            call_user_func_array("mysqli_stmt_bind_result", $campos);
            while (mysqli_stmt_fetch($consulta)) {
                foreach ($colSelect as $key => $valor) {
                    $dato["$valor"] = $campos["$valor"];
                }
                $datos[] = $dato;
            }
            cerrarConsulta();
            return $datos;
        } elseif ($funcion == 'insert') {
            cerrarConsulta();
            return true;
        } elseif ($funcion == 'update') {
            cerrarConsulta();
            return true;
        }
    }
    cerrarConsulta();
}

function cerrarConsulta() {
    global $colWhere, $colSelect, $colFrom, $ejecutar, $colValue, $tipos, $consulta, $valores_campos;
    $colWhere = array();
    $colSelect = array();
    $colFrom = array();
    $ejecutar = array();
    $colValue = array();
    $valores_campos = array();
    $tipos = "";
    mysqli_stmt_close($consulta);
}
