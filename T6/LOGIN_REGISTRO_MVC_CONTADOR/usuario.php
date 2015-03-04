<?php

function procesFormLogin() {
    global $mensaje;
    global $enlace;
    global $valores_campos;
    $camposObligatorios = array("usuario", "clave");
    $campospendientes = array();
    $camposerroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || !$_POST[$campoObligatorio]) {
            $campospendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ0-9]{5,15}$/", $_POST["usuario"])) {
        $camposerroneos[] = "usuario";
    }
    if (isset($_POST["clave"]) && !empty($_POST["clave"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ0-9]{5,15}$/", $_POST["clave"])) {
        $camposerroneos[] = "clave";
    }
    if ($campospendientes || $camposerroneos) {
        displayFormLogin($camposerroneos, $campospendientes);
    } else {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $valores_campos['clave']['valor'] = $_POST['clave'];
        $valores_campos['clave']['operador'] = "=";
        $existe = load(TABLA_LOGIN);
        if ($existe) {
            $visitas = contador();
            $mensaje = "Validación realizada positivamente. Eres la visita nº $visitas";
            $enlace = "<a href='index.php'>Volver al login</a>";
        } else {
            $mensaje = "Usuario incorrecto.";
            $enlace = "<a href='index.php'>Volver a intentarlo</a><br><a href='index.php?accion=registro'>Registrarse</a>";
        }
        displaySalida();
    }
}

function procesFormRegistro() {
    global $mensaje;
    global $enlace;
    global $valores_campos;
    $duplicado = false;
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"])) {
        $valores_campos['usuario']['valor'] = $_POST['usuario'];
        $valores_campos['usuario']['operador'] = "=";
        $duplicado = existe();
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
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ ]+$/", $_POST["nombre"])) {
        $camposErroneos[] = "nombre";
    }
    if (isset($_POST["apellidos"]) && !empty($_POST["apellidos"]) && !preg_match("/^[a-zA-ZáéíúóÁÉÍÓÚÑñ ]+$/", $_POST["apellidos"])) {
        $camposErroneos[] = "apellidos";
    }
    /* if (isset ($_POST["email"]) && !empty($_POST["email"]) && !preg_match("/^[A-Za-z0-9_.\-]+@[A-Za-z0-9_.\-]+\.[A-Za-z]{2,3}$/",$_POST["email"])) {
      $camposErroneos[]="email";
      }
     */
    /* if (isset ($_POST["email"]) && !empty($_POST["email"]) && !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/",$_POST["email"])) {
      $camposErroneos[]="email";
      }
     */
    if (isset($_POST["email"]) && $_POST["email"]) {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $camposErroneos[] = "email";
        }
    }

    if ($camposPendientes || $camposErroneos || $duplicado) {
        displayFormRegistro($camposErroneos, $camposPendientes, $duplicado);
    } else {
        foreach ($camposObligatorios as $campo) {
            $valor = $_POST[$campo];
            $valores_campos[$campo]["valor"] = $valor;
        }
//        $registro = guardar(TABLA_LOGIN);
        if (guardar(TABLA_LOGIN)) {
            $mensaje = "Usuario registrado";
            $enlace = "<a href='index.php'>Volver al login</a>";
        }
        displaySalida();
    }
}

function verUsuario($usuario = '%') {
    addTable(TABLA_LOGIN);
    setFuncion("select");
//    addSelect("usuario");
//    addSelect("nombre");
//    addSelect("apellidos");
//    addSelect("email");
//    addSelect("clave");
    global $valores_campos;
    $valores_campos['usuario']['valor'] = $usuario;
    $valores_campos['usuario']['operador'] = "like";

    $valores_campos['nombre']['valor'] = '%';
    $valores_campos['nombre']['operador'] = "like";

    $valores_campos['apellidos']['valor'] = '%';
    $valores_campos['apellidos']['operador'] = "like";

    $valores_campos['email']['valor'] = '%';
    $valores_campos['email']['operador'] = "like";

//    $valores_campos['clave']['valor'] = '';
//    $valores_campos['clave']['operador'] = "!=";
    foreach ($valores_campos as $key => $campo) {
        addSelect("$key");
    }
    foreach ($valores_campos as $key1 => $valor1) {
        $campo = $key1;
        $operador = $valor1["operador"];
        $where = "$campo " . $operador . " ?";
        addWhere($where);
        addTipo($valor1['valor']);
    }

    $sql_select = generar();
    echo "$sql_select<hr>";
    $resultados = ejecutar($sql_select, TABLA_LOGIN);
//    print_r($resultados);
    $tabla = '<table border=1><tr><th>USUARIO</th><th>NOMBRE</th><th>APELLIDOS</th><th>EMAIL</th></tr>';
    foreach ($resultados as $fila) {
        $tabla.="<tr>";
        foreach ($fila as $campo => $valor) {
            $tabla.="<td>$valor</td>";
        }
        $tabla.="<tr>";
    }
    $tabla.='</table>';
    $datos = array(
        "titulo" => TITULO,
        "formulario" => $tabla . "<a href='index.php'>Volver al inicio</a>"
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print ($html);
}

//cambiar a getVisitas
function contador() {
    global $valores_campos;
//    $fila = obtenerContador(); // Obtener primera (y única) fila.
    $filas = getAll(TABLA_VISITAS);
//    print_r($fila); //imprime array
    if ($filas) {
        print_r($filas[0]);
        echo'<hr>';
        $visitas = $filas[0]['*']; // OJO LO CAMBIE DE visitas A *
        $visitas = $visitas + 1;
        $valores_campos['visitas']['valor'] = $visitas;
        print_r($valores_campos);
        if (aumentarContador()) {
            return $visitas;
        }
    }
    return 0;
}

function getAll($tabla) {
    addTable($tabla);
    setFuncion("select");
    addSelect("*");
    $sql_select = generar();
    echo "$sql_select<hr>";
    return ejecutar($sql_select, $tabla);
}

//Cambiar a modificar contador
function aumentarContador() {
    global $valores_campos;
    addTable(TABLA_VISITAS);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        addSelect("$campo=?");
        addValue("?");
        addTipo($valor['valor']);
    }
    $sql_update = generar();
    print_r($valores_campos);
    echo "<br>$sql_update<hr>";
    return ejecutar($sql_update, $valores_campos, TABLA_VISITAS);
}

///FUNCION ORIGINAL
function aumentarContadorOLD() {
    global $valores_campos;
    addTable(TABLA_VISITAS);
    setFuncion("update");
    foreach ($valores_campos as $campo => $valor) {
        $valor = $valor['valor'];
        addSelect("$campo=?");
        addValue("?");
        addTipo($valor);
    }
    $sql_update = generar();
    print_r($valores_campos);
    echo "<br>$sql_update<hr>";
    if (!ejecutar($sql_update, TABLA_VISITAS)) {
        displayError();
    }
//    if (!modificarContador(TABLA_VISITAS)) {
//        displayError();
//    }
}

//function obtenerContador() {
//    $resultado = getAll(TABLA_VISITAS);
//    if (!$resultado) {
//        displayError();
//    } else {
//        return $resultado;
//    }
//}
//function modificarContador($tabla) {
//    global $valores_campos;
//    addTable($tabla);
//    setFuncion("update");
//    foreach ($valores_campos as $campo => $valor) {
//        $valor = $valor['valor'];
//        addSelect("$campo=?");
//        addValue("?");
//        addTipo($valor);
//    }
//    $sql_update = generar();
//    echo $sql_update;
//    return ejecutar($sql_update, $tabla);
//}

function guardar($tabla) {
    global $tipos;
    global $valores_campos;
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
    print_r($valores_campos);
    echo "<br>$sql_insertar<hr>";
//    if (ejecutar($sql_insertar, $valores_campos, $tabla))
//        return true;
    return ejecutar($sql_insertar, $valores_campos, $tabla);
//        return true;
}

function existe() {
//    $resultado = load(TABLA_LOGIN);
    if (load(TABLA_LOGIN)) {
        return true;
    }
    return false;
}

function load($tabla) {
    global $tipos;
    global $valores_campos;
    $tipos = '';
    addTable($tabla);
    setFuncion("select");
    foreach ($valores_campos as $key => $campo) {
        addSelect("$key");
    }
    foreach ($valores_campos as $key1 => $valor1) {
        $campo = $key1;
        $operador = $valor1["operador"];
        $where = "$campo " . $operador . " ?";
        addWhere($where);
        addTipo($valor1['valor']);
    }

    $sql_select = generar();
    print_r($valores_campos);
    echo "<br>$sql_select<hr>";
    return ejecutar($sql_select, $tabla);
}
