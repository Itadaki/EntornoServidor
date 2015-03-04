<?php

function ejecutar($sql, $valores_campos, $tabla) {
    global $funcion;
    global $conexion;
    global $tipos;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql);
//la función mysqli_stmt_bind_param() necesita referencias cuando se utiliza con call_user_func_array()
        if ($tipos) {
            $ejecucion = array(&$consulta, &$tipos);
            foreach ($valores_campos as $key => $valor) {
                $ejecucion[] = &$valores_campos[$key]['valor'];
            }
            call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        }
        return ejecutarConsulta($consulta, $tabla);
        cerrarConexion();
    }
}

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

function cerrarConexion() {
    global $conexion, $mensajeCerrarConexion;
    $operacion = true;
    if (!mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function ejecutarConsulta($consulta, $tabla) {
    global $conexion;
    global $funcion;
    global $mensaje;
    global $colSelect;
    $campos = array();
    if ($funcion == 'insert')
        $operacion = 'insertar';
    elseif ($funcion == 'select')
        $operacion = 'seleccionar';
    elseif ($funcion == 'update')
        $operacion = 'modificar';
    if (!mysqli_stmt_execute($consulta)) {
        $mensaje.= "<h2>Imposible $operacion los datos en $tabla. Error al $operacion los datos.</h2>";
        $numerror = mysqli_connect_errno();
        $descrerror = mysqli_connect_error();
        if ($numerror == 1062) {
            $mensaje.= "<b>No ha podido añadirse el registro. Ya existe el registro</b>";
        } else {
            $mensaje.= "<b>Se ha producido un error nº $numerror que corresponde a: $descrerror </b><br>";
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
            cerrarConsulta($consulta);
            return $datos;
        } elseif ($funcion == 'insert') {
            $mensaje = "<h3>Datos almacenados en tabla $tabla satisfactoriamente.</h3>\n";
            return true;
        }
    }
    cerrarConsulta($consulta);
}

function cerrarConsulta($consulta) {
    global $colWhere, $colSelect, $colFrom, $ejecutar, $colValue, $tipos;
    $colWhere = array();
    $colSelect = array();
    $colFrom = array();
    $ejecutar = array();
    $colValue = array();
    $tipos = "";
    mysqli_stmt_close($consulta);
}
