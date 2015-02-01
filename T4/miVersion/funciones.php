<?php

function displayLoginForm($camposErroneos = array(), $camposPendientes = array(), $mensaje = "") {
    if (empty($mensaje)) {
        if ($camposErroneos) {
            $mensaje = '<p class="error">Hubo algunos problemas con el formulario que usted presentó. 
		 Por favor, introduzca valores adecuados en los campos.</p>';
        } else if ($camposPendientes) {
            $mensaje = '<p class="errorVacio">Por favor, complete los campos en negrita de abajo y haga clic en <b>Enviar</b>
		para volver a enviar el formulario.</p>';
        }
    }
    $visitas = visitas();
    $datos = array(
        "validacionUsuario" => validateField("usuario", $camposPendientes, $camposErroneos),
        "usuario" => setValue("usuario"),
        "mensaje" => $mensaje,
        "visitas" => $visitas
    );
    $plantilla = 'plantillas/formulario.html';
    $formulario = rellenar($datos, $plantilla);
    $enlace = "";
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "enlace" => $enlace,
        "formulario" => $formulario
    );
    $html = rellenar($datos, $plantilla);
    print($html);
}

function visitas() {
    // Generamos los valores que se van a especificar para la cookie
    global $nombreCookieVisitas;
    $t_expiracion = time() + 600;
    // Obtenemos el valor del contador (evitando warnings no deseados...)
//    if (!isset($_COOKIE[$nombre])) {
//        $visitas = 1;
//        // Ahora enviamos la cookie y después generamos el documento
////        setcookie($nombre, $visitas, time() + 60 * 60);
//    } else {
//        $visitas = $_COOKIE[$nombre] + 1;
//    }
    if (isset($_COOKIE[$nombreCookieVisitas])) {
        $visitas = $_COOKIE[$nombreCookieVisitas] + 1;
    } else {
        $visitas = 1;
    }
    setcookie($nombreCookieVisitas, $visitas, $t_expiracion);

    if ($visitas == 1) {   // Es la primera vez
        $mensaje = "<b>Esta es tu primera visita</b>";
    } else {
        $mensaje = "<b>Esta es tu visita número $visitas</b>";
    }
    return $mensaje;
}

function procesForm() {
    $camposObligatorios = array("usuario", "contraseña");
    $camposPendientes = array();
    $camposErroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) || empty($_POST[$campoObligatorio])) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
//    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !preg_match("/^[a-zA-Z0-9]+$/", $_POST["usuario"])) {
    if (isset($_POST["usuario"]) && !preg_match("/^[a-zA-Z0-9]+$/", $_POST["usuario"])) {
        $camposErroneos[] = "usuario";
    }
    if ($camposPendientes || $camposErroneos) {
        displayLoginForm($camposErroneos, $camposPendientes);
    } else {
        login();
    }
}

function login() {
    global $usuarios;
    if (isset($_POST["usuario"]) and isset($_POST["contraseña"])) {
        foreach ($usuarios as $usuario => $contraseña) {
            if ($_POST["usuario"] == $usuario && $_POST["contraseña"] == $contraseña) {
                $_SESSION["usuario"] = $usuario;
//                if (!isset($_SESSION["carro"])) {
//                    $_SESSION["carro"] = array();
//                }
                //Repasa este cambio
                $_SESSION["carro"] = array();
//                session_write_close();
                header("Location: controlador.php");
                break;
            }
        }
        if (!isset($_SESSION["usuario"])) {
            $mensaje = '<p class="error">El usuario o la contraseña no coinciden. Por favor inténtelo de nuevo.';
            displayLoginForm(array(), array(), $mensaje);
        }
    }
}

function displayLista() {
    global $productos;
    $productosLista = "";
    foreach ($productos as $producto) {
        $codProd = $producto["codProd"];
        $enlace = "<a href=\"?action=addItem&amp;codProd=$codProd\">Añadir fruta al carro</a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "precio" => number_format($producto["precio"], 2),
            "enlace" => $enlace
        );
        $plantilla = "plantillas/fruta.html";
        $producto = rellenar($datos, $plantilla);
        $productosLista .= $producto;
    }

    $publicidad = '';
    if (isset($_COOKIE["oferta"])) {
        $publicidad = "<b>Tenemos las/os mejores " . $_COOKIE["oferta"] . "s fuera de temporada</b>";
    }
//    $publicidad = publicidad();

    $datos = array(
        "lista" => $productosLista,
        "publicidad" => $publicidad
    );
    $plantilla = "plantillas/frutas.html";
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

//function publicidad() {
//    if (isset($_COOKIE["oferta"])) {
//        $publicidad = "<b>Tenemos las/os mejores " . $_COOKIE["oferta"] . "s fuera de temporada</b>";
//        return $publicidad;
//    }
//}

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

function logout() {
    global $nombreCookieVisitas;
    crearOferta();
    //Borramos todas las variables de la sesión
//    $_SESSION = array();    
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
    //Caducamos la cookie
    setcookie('PHPSESSID', '', time() - 3600);
    //destruimos los datos de la sesión en el script actual
    session_destroy();
//    $t_expiracion = time() + 600;
//    $veces = $_COOKIE[$nombreCookieVisitas] - 1; //???????????????
//    setcookie($nombreCookieVisitas, $veces, $t_expiracion);
    //redirigimos a la página de acreditación
    header('Location: controlador.php');
}

function crearOferta() {
    $t_expiracion = time() + 600;
    foreach ($_SESSION["carro"] as $producto) {
        $oferta = $producto["nomProd"];
        setcookie("oferta", $oferta, $t_expiracion);
    }
}

function displayCarro() {
    global $productos;
    $totalPrecio = 0;
    $productosCarro = "";
    foreach ($_SESSION["carro"] as $producto) {
        $codProd = $producto["codProd"];
        $total = $producto["precio"] * $producto["unidades"];
//        $totalPrecio += $fruta["precio"];
        $totalPrecio += $total;
        $enlace = "<a href=\"?action=removeItem&amp;codProd=$codProd\">Eliminar fruta del carro<img width=\"16\" alt=\"ELIMINAR FRUTA CARRO\" src=\"plantillas/shoppingcart_16x16.png\" height=\"16\"></a>";
        $datos = array(
            "nomProd" => $producto["nomProd"],
            "total" => $total,
            "precio" => number_format($producto["precio"], 2),
            "unidades" => $producto["unidades"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/fruta_carro.html";
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
    header("Location: controlador.php?action=carro");
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        if (is_numeric($_POST[$nombreCampo]))
            echo number_format($_POST[$nombreCampo]);
        else
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
