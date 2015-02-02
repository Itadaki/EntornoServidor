<?php

//Muestra el formulario de Login
function displayLoginForm($camposErroneos = array(), $camposPendientes = array(), $mensaje = "") {
    //Mensaje de campos con errores
    if ($camposErroneos) {
        $mensaje .= '<p class="error">Por favor, introduzca valores <b>adecuados</b> en los campos.</p>';
    }
    //Mensaje de campos vacios
    if ($camposPendientes) {
        $mensaje .= '<p class="errorVacio">Por favor, complete los campos resaltados y haga clic en <b>Login</b> para intentarlo de nuevo.</p>';
    }
    //Generar la cookie y el mensaje de visita
    global $nombreCookieVisitas;
    global $t_expiracion;
    if (isset($_COOKIE[$nombreCookieVisitas]) && $_COOKIE[$nombreCookieVisitas] != 1) {
        $mensajeVisitas = "<b>Esta será tu visita numero " . $_COOKIE[$nombreCookieVisitas] . ".</b>";
    } else {
        $mensajeVisitas = "<b>Esta será tu primera visita</b>";
        setcookie($nombreCookieVisitas, 1, $t_expiracion);
    }
    //Sustituir los datos en la plantilla
    $datos = array(
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos),
        "validacionContraseña" => validateField("usuario", $camposPendientes, $camposErroneos),
        "usuario" => setValue("usuario"),
        "mensaje" => $mensaje,
        "visitas" => $mensajeVisitas
    );
    $plantilla = 'plantillas/login.html';
    $formulario = rellenar($datos, $plantilla);
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "enlace" => "",
        "formulario" => $formulario
    );
    $html = rellenar($datos, $plantilla);
    print($html);
}

//Procesa los datos del formulario de entrada 
function procesForm() {
    $camposObligatorios = array("usuario", "contraseña");
    $camposPendientes = array();
    $camposErroneos = array();
    //Revisar los campos obligatorios
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || empty($_POST[$campoObligatorio])) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    //Revisar los caracteres de usuario
    if (isset($_POST["usuario"]) && !preg_match("/^[a-zA-Z0-9]+$/", $_POST["usuario"])) {
        $camposErroneos[] = "usuario";
    }
    //Volver al formulario o ir a la tienda
    if ($camposPendientes || $camposErroneos) {
        displayLoginForm($camposErroneos, $camposPendientes);
    } else {
        login();
    }
}

//Comprueba si existe el usuario
function login() {
    global $usuarios;
    global $nombreCookieVisitas;
    global $t_expiracion;
    $coincide = false;
    if (isset($_POST["usuario"]) and isset($_POST["contraseña"])) {
        foreach ($usuarios as $usuario => $contraseña) {
            if ($_POST["usuario"] == $usuario && $_POST["contraseña"] == $contraseña) {
                $coincide = true;
                $_SESSION["usuario"] = $usuario;
                //Crear el carro
                $_SESSION["carro"] = array();
                //Inicio se sesion valido = visitas+1
                $visitas = $_COOKIE[$nombreCookieVisitas] + 1;
                setcookie($nombreCookieVisitas, $visitas, $t_expiracion);
                header("Location: controlador.php");
                break;
            }
        }
        if (!$coincide) {
            $mensaje = '<p class="errorExiste">El usuario o la contraseña no coinciden o no existen. Por favor inténtelo de nuevo.';
            displayLoginForm(array(), array(), $mensaje);
        }
    }
}

//Muestra la lista de productos
function displayLista() {
    global $productos;
    $productosLista = "";
    foreach ($productos as $producto) {
        $codProd = $producto["codProd"];
        $enlace = "<a href=\"?action=addItem&amp;codProd=$codProd\">Añadir al carro</a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => number_format($producto["precio"], 2),
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto.html";
        $producto = rellenar($datos, $plantilla);
        $productosLista .= $producto;
    }

    $publicidad = '';
    if (isset($_COOKIE["ultimoProducto"])) {
        $publicidad = "<b>Tenemos las/os mejores " . $_COOKIE["ultimoProducto"] . "s fuera de temporada</b>";
    }

    $datos = array(
        "lista" => $productosLista,
        "publicidad" => $publicidad
    );
    $plantilla = "plantillas/catalogo.html";
    $html = rellenar($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "mensaje" => "",
        "formulario" => $html,
    );
    $plantilla = "plantillas/plantilla.html";
    $html = rellenar($datos, $plantilla);
    print($html);
}

//Añade un producto al carro
function addItem() {
    global $productos;
    if (isset($_GET["codProd"]) and $_GET["codProd"] >= 1 and $_GET["codProd"] <= 5) {
        $codProd = (int) $_GET["codProd"];
        if (!isset($_SESSION["carro"][$codProd])) {
            $_SESSION["carro"][$codProd] = $productos[$codProd];
        } else {
            $_SESSION["carro"][$codProd]["unidades"] ++;
        }
    }
    session_write_close();
    header("Location: controlador.php");
}

//Muestra el importe y elimina sesion
function logout() {
    global $nombreCookieVisitas;
    global $t_expiracion;
    //Crear la cookie de oferta
    //Como las ID de productos empiezan por 1: length == ultimoID
    $idUltimoProducto = count($_SESSION['carro']);
    if ($idUltimoProducto != 0) {
        $ultimoProducto = $_SESSION['carro'][$idUltimoProducto]["nomProd"];
    }
    if (isset($ultimoProducto)) {
        setcookie("ultimoProducto", $ultimoProducto, $t_expiracion);
    }

    //Mostrar total importe al salir
    if (empty($_SESSION["carro"])) {
        $mensaje = 'No ha realizado ningun pedido.';
    } else {
        $totalPrecio = 0;
        foreach ($_SESSION["carro"] as $producto) {
            $total = $producto["precio"] * $producto["unidades"];
            $totalPrecio += $total;
        }
        $mensaje = "El importe de su pedido es de <b>" . number_format($totalPrecio, 2) . "€</b>";
    }

    //Borramos todas las variables de la sesion   
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }

    //Eliminar la cookie de sesion
    setcookie('PHPSESSID', '', -1);

    //Destruir archivos de sesion
    session_destroy();

    //Rellenar datos de salida
    $datos = array(
        "mensaje" => $mensaje,
    );
    $plantilla = "plantillas/logout.html";
    $html = rellenar($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "mensaje" => "",
        "formulario" => $html,
    );
    $plantilla = "plantillas/plantilla.html";
    $html = rellenar($datos, $plantilla);
    print($html);
}

//Muestra el carro de la compra
function displayCarro() {
    global $productos;
    $totalPrecio = 0;
    $productosCarro = "";
    foreach ($_SESSION["carro"] as $producto) {
        $codProd = $producto["codProd"];
        $total = $producto["precio"] * $producto["unidades"];
        $totalPrecio += $total;
        $enlace = "<a href=\"?action=removeItem&amp;codProd=$codProd\">Eliminar</a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "total" => $total,
            "precio" => number_format($producto["precio"], 2),
            "unidades" => $producto["unidades"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/producto_carro.html";
        $producto = rellenar($datos, $plantilla);
        $productosCarro.=$producto;
    }
    $datos = array(
        "carro" => $productosCarro,
        "totalprecio" => number_format($totalPrecio, 2)
    );
    $plantilla = "plantillas/carro.html";
    $html = rellenar($datos, $plantilla);
    $datos = array(
        "mensaje" => "",
        "formulario" => $html,
    );
    $plantilla = "plantillas/plantilla.html";
    $html = rellenar($datos, $plantilla);
    print($html);
}

//Elimina una unidad del carro de la compra
function removeItem() {
    global $productos;
    if (isset($_GET["codProd"]) and $_GET["codProd"] >= 1 and $_GET["codProd"] <= 5) {
        $codProd = (int) $_GET["codProd"];
        if (isset($_SESSION["carro"][$codProd])) {
            if ($_SESSION["carro"][$codProd]["unidades"] > 1) {
                $_SESSION["carro"][$codProd]["unidades"] --;
            } else {
                unset($_SESSION["carro"][$codProd]);
            }
        }
    }
    session_write_close();
    header("Location: controlador.php?action=verCarro");
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

function validateField($campo, $camposPendientes, $camposErroneos) {
    if (in_array($campo, $camposPendientes)) {
        return ' class="errorVacio"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error"';
    }
}

function rellenar($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}
