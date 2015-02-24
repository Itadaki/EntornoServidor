<?php

function ejecutar($sql, $valores_campos, $tabla) {
    global $funcion;
    global $conexion;
    global $tipos;
    if ($conexion = conexion()) {
        $consulta = mysqli_stmt_init($conexion);
        mysqli_stmt_prepare($consulta, $sql);
//la función mysqli_stmt_bind_param() necesita referencias cuando se utiliza con call_user_func_array()
        $ejecucion = array(&$consulta, &$tipos);
        foreach ($valores_campos as $key => $valor) {
            $ejecucion[] = &$valores_campos[$key];
        }
        ///
        $trace = debug_backtrace();
        $caller = $trace[1];
        echo "Called by {$caller['function']} <br>";
        if (isset($caller['class']))
            echo " in {$caller['class']}";

        echo "SQL: $sql<br>CAMPOS:<br>";
        foreach ($valores_campos as $key => $value) {
            echo "$key : $value<br>";
        }
        echo '<hr><dd>';
        ///
        call_user_func_array("mysqli_stmt_bind_param", $ejecucion);
        $resultados = ejecutarConsulta($consulta, $tabla);
//        return $resultados;
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
    if (!@mysqli_close($conexion)) {
        $mensajeCerrarConexion = "<h2> No se ha podido cerrar la conexión</h2>";
    }
}

function ejecutarConsulta($consulta, $tabla) {
    global $conexion;
    global $funcion;
    global $mensaje;
    global $id;
    $trace = debug_backtrace();
        $caller = $trace[1];
        echo "Called by {$caller['function']} <br>";
        if (isset($caller['class']))
            echo " in {$caller['class']}";

    echo "FUNCION:$funcion // MENSAJE:$mensaje  // TABLA:$tabla<br>";
    if ($funcion == 'insert')
        $operacion = 'insertar';
    elseif ($funcion == 'select')
        $operacion = 'seleccionar';
    if (!mysqli_stmt_execute($consulta)) {
        echo "<b>NO SE EJECUTA OPERACION $operacion</b></dd><br>";
        $mensaje.= "<h2>Imposible $operacion los datos en $tabla. Error al $operacion los datos.</h2>";
        $numerror = mysqli_stmt_errno($consulta);
        $descrerror = mysqli_stmt_error($consulta);
        if ($numerror == 1062) {
            $mensaje.= "<b>No ha podido añadirse el registro. Ya existe el registro</b>";
        } else {
            $mensaje.= "<b>Se ha producido un error nº $numerror que corresponde a: $descrerror </b><br>";
        }
    } else {
        if ($funcion == 'insert') {
            echo "<b>EJECUTADA OPERACION $operacion EN $tabla</b><br>";
            $mensaje.= "<h3>Datos almacenados en tabla $tabla satisfactoriamente.</h3>\n";
        } elseif ($funcion == 'select') {
            echo "<b>EJECUTADA OPERACION $operacion EN $tabla</b><br>";
            $resultados = array();
            mysqli_stmt_bind_result($consulta, $id2, $dni, $nombre, $ap1, $ap2,$email, $telf);
            while (mysqli_stmt_fetch($consulta)) {
                echo "$dni, $nombre, $ap1, $ap2, $email, $telf<br>";
                $id = $id2;
                $resultados['id'] = $id;
                $resultados['dni'] = $dni;
                $resultados['nombre'] = $nombre;
                $resultados['ap1'] = $ap1;
                $resultados['ap2'] = $ap2;
                $resultados['email'] = $email;
                $resultados['telf'] = $telf;
            }
            cerrarConsulta($consulta);
            echo "<h3>RESULTADOS</h3>";
            foreach ($resultados as $key => $value) {
                echo "$key -> $value<br>";
            }
            return $resultados;
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
