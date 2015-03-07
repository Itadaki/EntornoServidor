<?php

function procesForm($operacion) {
    global $mensaje;
    global $enlace;
    $fotos = array('foto');
    $camposPendientes = array();
    $camposErroneos = array();
    $duplicado = '';
    $camposObligatorios = array();
    $message = 'correcto';
// Las líneas hasta el foreach sirven para comprobar si un modelo está duplicado tanto cuando se inserta como cuando se modifica
    if ($operacion == 'insercion' || $operacion == 'modificacion') {
        $camposObligatorios = array("marca", "modelo");
        if (!isset($_POST['id'])) {
            $valor_id = 0;
        } else {
            $valor_id = $_POST['id'];
        }
        $valores_campos['id']['valor'] = $valor_id;
        $valores_campos['id']['operador'] = '!=';
        $valores_campos['marca']['valor'] = $_POST['marca'];
        $valores_campos['marca']['operador'] = '=';
        $valores_campos['modelo']['valor'] = $_POST['modelo'];
        $valores_campos['modelo']['operador'] = '=';
        $duplicado = existe($valores_campos);
    }
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || ! $_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["marca"]) && !empty($_POST["marca"]) && !preg_match("/^[a-zA-Z0-9 ]+$/", $_POST["marca"])) {
        $camposErroneos[] = "marca";
    }
    if (isset($_POST["modelo"]) && !empty($_POST["modelo"]) && !preg_match("/^[a-zA-Z0-9 ]+$/", $_POST["modelo"])) {
        $camposErroneos[] = "modelo";
    }
    /* Las 4 líneas siguientes hacen obligatorio añadir una foto cuando se inserta evitando el control de errores porque. Puedes observar que no es obligatorio en el caso de la modificación. Pero si se añade una foto en ambos casos, entonces si se realiza el control de errores. Observa que utilizamos la espresión !$_FILES['foto']['name'] porque cuando se envía el formulario el elemento FILE se envía aunque no se añada fichero y no está vacío pues hay contenido en $_FILES['foto']['error'], por lo que no sirve la expresión empty($_FILES['foto']) porque siempre es true
     */
    if (isset($_FILES['foto']) && ! $_FILES['foto']['name'] && $operacion == "insercion") {
        $camposPendientes[] = "foto";
        $message = 'No has elegido ninguna foto';
    } elseif (isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
        foreach ($fotos as $valor) {
            if (isset($_FILES["$valor"]) && $_FILES["$valor"]["error"] == UPLOAD_ERR_OK) {
                if ($_FILES["$valor"]["type"] != "image/jpeg") {
                    $message.= $_FILES["$valor"]["name"] . ": JPEG fotos solamente, gracias!<br>";
                } elseif (!@move_uploaded_file($_FILES["$valor"]["tmp_name"], "fotos/" . basename($_FILES["$valor"]["name"]))) {
                    $message.=$_FILES["$valor"]["name"] . ": Lo sentimos, hubo un problema al subir esa foto. <br>";
                } else {
                    $message = "correcto";
                }
            } elseif (isset($_FILES["$valor"])) {
                switch ($_FILES["$valor"]["error"]) {
                    case UPLOAD_ERR_INI_SIZE:
                        $message .= $_FILES["$valor"]["name"] . ": La foto es más grande de lo que permite el servidor.<br>";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $message = $_FILES["$valor"]["name"] . ": La foto es más grande de lo que permite el formulario. <br>";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $message = $_FILES["$valor"]["name"] . ": No se ha subido ningún archivo. <br>";
                        break;
                    default:
                        $message = $_FILES["$valor"]["name"] . ": Ponte en contacto con el administrador del servidor para obtener ayuda. <br>";
                }
            }
        }
    }
    if (($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') && $operacion == "insercion") {
        displayFormInsertar($camposErroneos, $camposPendientes, $duplicado, $message);
    } elseif (($camposPendientes || $camposErroneos || $duplicado || $message != 'correcto') && $operacion == "modificacion") {
        displayFormEditar($camposErroneos, $camposPendientes, $duplicado, $message);
    } elseif ($camposErroneos && $operacion == "buscar") {
        displayFormBuscar($camposErroneos);
    } else {
        if ($operacion == "buscar") {
            $valores_campos = array();
            $valores_campos['id']['valor'] = NULL;
            $valores_campos['id']['operador'] = "";
// En el caso de buscar tenemos que controlar si ha introducido marca y modelo porque no es obligatorio
            if (!empty($_POST['marca'])) {
                $valores_campos['marca']['valor'] = $_POST['marca'];
                $valores_campos['marca']['operador'] = "=";
            } else {
                $valores_campos['marca']['valor'] = NULL;
                $valores_campos['marca']['operador'] = "";
            }
            if (!empty($_POST['modelo'])) {
                $valores_campos['modelo']['valor'] = $_POST['modelo'];
                $valores_campos['modelo']['operador'] = "=";
            } else {
                $valores_campos['modelo']['valor'] = NULL;
                $valores_campos['modelo']['operador'] = "";
            }
            $valores_campos['foto']['valor'] = NULL;
            $valores_campos['foto']['operador'] = "";
            $coches = obtener($valores_campos, TABLA);
            visualizarDatos($coches);
        } elseif ($operacion == "insercion") {
            $valores_campos = array();
            $valores_campos['marca']['valor'] = $_POST['marca'];
            $valores_campos['marca']['operador'] = "*";
            $valores_campos['modelo']['valor'] = $_POST['modelo'];
            $valores_campos['modelo']['operador'] = "*";
            $valores_campos['foto']['valor'] = $_FILES["foto"]["name"];
            $valores_campos['foto']['operador'] = "*";
            $registro = guardar($valores_campos, TABLA);
            if ($registro) {
                $mensaje = "La inserción se ha realizado satisfactoriamente en " . TABLA;
                $enlace = "<a href='index.php'>Volver al menú principal</a>";
            }
            visualizarResultado();
        } elseif ($operacion == "modificacion") {
            /* observa el orden de los campos en $valores_campos tiene que ser el mismo que el de los tipos y
              el de las variables cuyos valores van a sustituir a los signos ? cuando se ejecute la consulta. Es decir el orden de campos que se establece en las siguientes líneas debe ser el mismo que se establece en la función cambiar(): primero los campos de la opción SET (marca y modelo) y después el campo de la
              condición where (id).
             */
            $valores_campos = array();
            $valores_campos['marca']['valor'] = $_POST['marca'];
            $valores_campos['marca']['operador'] = "*";
            $valores_campos['modelo']['valor'] = $_POST['modelo'];
            $valores_campos['modelo']['operador'] = "*";
            if (isset($_FILES['foto']) && $_FILES['foto']['name']) {
                $valores_campos['foto']['valor'] = $_FILES['foto']['name'];
                $valores_campos['foto']['operador'] = "*";
            }
            $valores_campos['id']['valor'] = (int) $_POST['id'];
            $valores_campos['id']['operador'] = '=';
            $registro = modificar($valores_campos, TABLA);
            if ($registro) {
                $mensaje = "La modificación se ha realizado satisfactoriamente en " . TABLA;
                $enlace = "<a href='index.php'>Volver al menú principal</a>";
            }
            visualizarResultado();
        } elseif ($operacion == "eliminacion") {
            $valores_campos['id']['valor'] = $_POST['id'];
            $valores_campos['id']['operador'] = '=';
            $registro = eliminar($valores_campos, TABLA);
            if ($registro) {
                $mensaje = "La eliminación se ha realizado satisfactoriamente en " . TABLA;
                $enlace = "<a href='index.php'>Volver al menú principal</a>";
            }
            visualizarResultado();
        }
    }
}

function obtener($valores_campos, $tabla) {
    global $campos;
    global $mensaje;
    $resultado = load($valores_campos, TABLA);
//$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
    if (!$resultado && $mensaje) {
        visualizarError();
        exit();
    } else {
        return $resultado;
    }
}

function guardar($valores_campos, $tabla) {
    global $campos;
    global $mensaje;
    $resultado = insertar($valores_campos, TABLA);
//$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
    if (!$resultado && $mensaje) {
        visualizarError();
        exit();
    } else {
        return $resultado;
    }
}

function eliminar($valores_campos, $tabla) {
    global $campos;
    global $mensaje;
    $resultado = borrar($valores_campos, TABLA);
//$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
    if (!$resultado && $mensaje) {
        visualizarError();
        exit();
    } else {
        return $resultado;
    }
}

function modificar($valores_campos, $tabla) {
    global $campos;
    global $mensaje;
    $resultado = cambiar($valores_campos, TABLA);
//$resultado puede estar vacío porque la consulta no produce resultados, no por un error, así que hay que verificar si mensaje está lleno
    if (!$resultado && $mensaje) {
        visualizarError();
    } else {
        return $resultado;
    }
}

function cambiar($valores_campos, $tabla) {
    global $tipos;
    $tipos = '';
    addTable($tabla);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        if ($campo != 'id') {
            addUpdate($campo);
//cuidado aquí pues $valores_campos es un array bidimensional;
            addTipo($valor['valor']);
        }
    }
    foreach ($valores_campos as $campo => $valor) {
        if ($valor["operador"]and $valor["operador"] != '*') {
            $operador = $valor["operador"];
            $where = "$campo " . $operador . " ?";
            addWhere($where);
            addTipo($valor['valor']);
        }
    }
    $sql_modificar = generar();
    if (ejecutar($sql_modificar, $valores_campos, $tabla))
        return true;
}

function insertar($valores_campos, $tabla) {
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
    if (ejecutar($sql_insertar, $valores_campos, $tabla))
        return true;
}

function borrar($valores_campos, $tabla) {
    global $tipos;
    $tipos = '';
    addTable($tabla);
    setFuncion("delete");
    foreach ($valores_campos as $campo => $valor) {
        if ($valor["operador"]) {
            $operador = $valor["operador"];
            $where = "$campo " . $operador . " ?";
            addWhere($where);
            addTipo($valor['valor']);
        }
    }
    $sql_eliminar = generar();
    if (ejecutar($sql_eliminar, $valores_campos, $tabla))
        return true;
}

function load($valores_campos, $tabla) {
    global $tipos;
    $tipos = '';
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $key => $campo) {
        addSelect("$key");
    }
    foreach ($valores_campos as $campo => $valor) {
        if ($valor["operador"]) {
            $operador = $valor["operador"];
            $where = "$campo " . $operador . " ?";
            addWhere($where);
            addTipo($valor['valor']);
        }
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

function existe($valores_campos) {
    $duplicado = '';
    $resultado = load($valores_campos, TABLA);
    if ($resultado)
        $duplicado = 1;
    return $duplicado;
}
