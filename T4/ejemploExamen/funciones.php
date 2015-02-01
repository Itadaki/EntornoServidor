<?php

function validateField($campo, $camposNoRellenados, $camposErroneos) {
    if (in_array($campo, $camposNoRellenados)) {
        return ' class="error1"';
    } elseif (in_array($campo, $camposErroneos)) {
        return ' class="error2"';
    }
}

function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        if (is_numeric($_POST[$nombreCampo]))
            echo number_format($_POST[$nombreCampo]);
        else
            return $_POST[$nombreCampo];
    }
}

function contador() {
    // Generamos los valores que se van a especificar para la cookie
    $nombre = 'Contador';
    // Obtenemos el valor del contador (evitando warnings no deseados...)
    if (!isset($_COOKIE[$nombre])) {
        $veces = 1;
        // Ahora enviamos la cookie y después generamos el documento
        setcookie($nombre, $veces, time() + 60 * 60);
    } else {
        $veces = $_COOKIE[$nombre];
    }

    if ($veces == 1)   // Es la primera vez
        $contador = "Bienvenido por primera vez a nuestra página\n";
    else
        $contador = "<b>Has visitado nuestra página $veces veces \n</b>";
    return $contador;
}

function displayLoginForm($camposErroneos, $camposPendientes, $mensaje = "") {
    if ($camposErroneos) {
        $mensaje = '<p class="error1">Hubo algunos problemas con el formulario que usted presentó. 
		 Por favor, introduzca valores adecuados en los campos.</p>';
    } elseif ($camposPendientes) {
        $mensaje = '<p class="error2">Hubo algunos problemas con el formulario que usted presentó. 
		 Por favor, complete los campos en negrita de abajo y haga clic en <b>Enviar</b>
		para volver a enviar el formulario.</p>';
    }
    $contador = contador();
    $datos = array(
        "validacionusername" => validateField("username", $camposPendientes, $camposErroneos),
        "username" => setValue("username"),
        "mensaje" => $mensaje,
        "contador" => $contador
    );
    $plantilla = 'plantillas/formulario.html';
    $formulario = respuesta($datos, $plantilla);
    $enlace = "";
    $plantilla = "plantillas/plantilla.html";
    $datos = array(
        "enlace" => $enlace,
        "formulario" => $formulario
    );
    $html = respuesta($datos, $plantilla);
    print($html);
}

function procesForm() {
    $camposObligatorios = array("username", "password");
    $camposPendientes = array();
    $camposErroneos = array();
    foreach ($camposObligatorios as $campoObligatorio) {
        if (!isset($_POST[$campoObligatorio]) or ! $_POST[$campoObligatorio]) {
            $camposPendientes[] = $campoObligatorio;
        }
    }
    if (isset($_POST["username"]) && !empty($_POST["username"]) && !preg_match("/^[a-zA-Z0-9]+$/", $_POST["username"])) {
        $camposErroneos[] = "username";
    }
    if ($camposPendientes or $camposErroneos)
        displayLoginForm($camposErroneos, $camposPendientes);
    else
        login();
}

function displayCarro() {
    global $productos;
    $totalPrecio = 0;
    $carro = "";
    foreach ($_SESSION["carro"] as $fruta) {
        $cod = $fruta["cod"];
        $total = $fruta["precio"] * $fruta["unidades"];
        $totalPrecio += $fruta["precio"];
        $enlace = "<a href=\"index.php?action=removeItem&amp;cod=$cod\">Eliminar fruta del carro<img width=\"16\" alt=\"ELIMINAR FRUTA CARRO\" src=\"plantillas/shoppingcart_16x16.png\" height=\"16\"></a>";
        $datos = array(
            "nom" => $fruta["nom"],
            "total" => $total,
            "precio" => number_format($fruta["precio"], 2),
            "unidades" => $fruta["unidades"],
            "enlace" => $enlace
        );
        $plantilla = "plantillas/fruta_carro.html";
        $fruta = respuesta($datos, $plantilla);
        $carro.=$fruta;
    }

    $datos = array(
        "carro" => $carro,
        "totalprecio" => number_format($totalPrecio, 2)
    );
    $plantilla = "plantillas/carro.html";
    $html = respuesta($datos, $plantilla);
    $datos = array(
        "mensaje" => "",
        "formulario" => $html,
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function displayLista() {
    global $productos;
    $lista = "";
    foreach ($productos as $fruta) {
        $cod = $fruta["cod"];
        $enlace = "<a href=\"index.php?action=addItem&amp;cod=$cod\">Añadir fruta al carro</a>";
        $datos = array(
            "nom" => $fruta["nom"],
            "precio" => number_format($fruta["precio"], 2),
            "enlace" => $enlace
        );
        $plantilla = "plantillas/fruta.html";
        $fruta = respuesta($datos, $plantilla);
        $lista.=$fruta;
    }
    $publicidad = publicidad();
    $datos = array(
        "lista" => $lista,
        "publicidad" => $publicidad
    );
    $plantilla = "plantillas/frutas.html";
    $html = respuesta($datos, $plantilla);
    $datos = array(
        "titulo" => TITULO,
        "mensaje" => "",
        "formulario" => $html,
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function respuesta($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    $html = str_replace('{titulo}', TITULO, $html);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}

function logout() {
    crearOferta();
    //Borramos todas las variables de la sesión
    $_SESSION = array();
    //Caducamos la cookie
    setcookie('PHPSESSID', '', time() - 3600);
    //destruimos los datos de la sesión en el script actual
    session_destroy();
    $nombre = "Contador";
    $veces = $_COOKIE[$nombre] + 1;
    setcookie($nombre, $veces, time() + 60 * 60);
    //redirigimos a la página de acreditación
    header('Location: index.php');
}

function addItem() {
    global $productos;
    if (isset($_GET["cod"]) and $_GET["cod"] >= 1 and $_GET["cod"] <= 5) {
        $cod = (int) $_GET["cod"];
        if (!isset($_SESSION["carro"][$cod])) {
            $_SESSION["carro"][$cod] = $productos[$cod];
        } else {
            $_SESSION["carro"][$cod]["unidades"] ++;
        }
    }
    session_write_close();
    header("Location: index.php");
}

function removeItem() {
    global $productos;
    if (isset($_GET["cod"]) and $_GET["cod"] >= 1 and $_GET["cod"] <= 5) {
        $cod = (int) $_GET["cod"];
        if (isset($_SESSION["carro"][$cod]) and $_SESSION["carro"][$cod]["unidades"] == 1) {
            unset($_SESSION["carro"][$cod]);
        } elseif (isset($_SESSION["carro"][$cod]) and $_SESSION["carro"][$cod]["unidades"] > 1) {
            $_SESSION["carro"][$cod]["unidades"]-=1;
        }
    }
    session_write_close();
    header("Location: index.php?action=carro");
}

function login() {
    global $usuarios;
    if (isset($_POST["username"]) and isset($_POST["password"])) {
        foreach ($usuarios as $nombre => $password) {
            if ($_POST["username"] == $nombre and $_POST["password"] == $password) {
                $_SESSION["username"] = $nombre;
                if (!isset($_SESSION["carro"]))
                    $_SESSION["carro"] = array();
                session_write_close();
                header("Location: index.php");
                break;
            }
        }
        if (!isset($_SESSION["username"])) {
            $mensaje = '<p class="error3">' . " usuario/password no existe. Por favor inténtelo de nuevo.";
            displayLoginForm(array(), array(), $mensaje);
        }
    }
}

function crearOferta() {
    foreach ($_SESSION["carro"] as $fruta) {
        $frutaOferta = $fruta['nom'];
        setcookie("oferta", $frutaOferta, time() + 60 * 60);
    }
}

function publicidad() {
    if (isset($_COOKIE["oferta"])) {
        $publicidad = "<h1>Tenemos las/os mejores ${_COOKIE["oferta"]}s fuera de temporada</h1>";
        return $publicidad;
    }
}
