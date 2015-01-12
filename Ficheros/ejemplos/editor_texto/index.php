<?php

include ("constantes.php");
if (isset($_POST["salvarFich"])) {
    salvarFich();
} elseif (isset($_GET["nomFich"])) {
    displayEditForm();
} elseif (isset($_POST["crearFich"])) {
    crearFich();
} else {
    displayListaFich();
}

function displayListaFich($mensaje = "") {
    if (!file_exists(PATH_TO_FILES))
        $formulario = "Directorio no encontrado";
    elseif (!($dir = opendir(PATH_TO_FILES)))
        $formulario = "No puede abrirse el directorio";
    else {
        $listaFich = "";
        while ($nomFich = readdir($dir)) {
            $pathfich = PATH_TO_FILES . "/$nomFich";
            if ($nomFich != "." && $nomFich != ".." && !is_dir($pathfich) && strrchr($nomFich, ".") == ".txt") {
                $datos = array(
                    "nomFichEncode" => urlencode($nomFich),
                    "nomFich" => $nomFich,
                    "sizeFich" => filesize($pathfich),
                    "fechaUltModi" => date("M j, Y H:i:s") . ", " . filemtime($pathfich)
                );
                $plantilla = "plantillas/lineaFich.html";
                $listaFich.=respuesta($datos, $plantilla);
            }
        }
        closedir($dir);
        if ($mensaje)
            $mensaje = '<p class="error">' . $mensaje . '</p>';
        echo "---------------" . $mensaje . "--------------";
        $datos = array(
            "mensaje" => $mensaje,
            "listaFich" => $listaFich
        );
        $plantilla = "plantillas/form_listaFich.html";
        $formulario = respuesta($datos, $plantilla);
    }
    $datos = array(
        "formulario" => $formulario,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function displayEditForm($nomFich = "") {
    if (!$nomFich)
        $nomFich = basename($_GET["nomFich"]);
    if (!$nomFich) {
        $formulario = "Nombre de fichero inválido";
    } else {
        $pathfich = PATH_TO_FILES . "/$nomFich";
        if (!file_exists($pathfich))
            $formulario = "Archivo no encontrado";
        else {
            $datos = array(
                "nomFich" => $nomFich,
                "nomFichFiltrado" => htmlspecialchars($nomFich),
                "contenidoFich" => htmlspecialchars(file_get_contents($pathfich))
            );
            $plantilla = "plantillas/form_editFich.html";
            $formulario = respuesta($datos, $plantilla);
        }
    }
    $datos = array(
        "formulario" => $formulario,
        "titulo" => TITULO
    );
    $plantilla = "plantillas/plantilla.html";
    $html = respuesta($datos, $plantilla);
    print($html);
}

function salvarFich() {
    $formulario = "";
    $nomFich = basename($_POST["nomFich"]);
    $pathfich = PATH_TO_FILES . "/$nomFich";
    if (file_exists($pathfich)) {
        if (file_put_contents($pathfich, $_POST["contenidosFich"]) === false) {
            $formulario = "No puede salvarse el fichero";
        } else {
            displayListaFich();
        }
    } else {
        $formulario = "Fichero no encontrado";
    }
    if ($formulario) {
        $datos = array(
            "formulario" => $formulario,
            "titulo" => TITULO
        );
        $plantilla = "plantillas/plantilla.html";
        $html = respuesta($datos, $plantilla);
        print($html);
    }
}

function crearFich() {
    $nomFich = basename($_POST["nomFich"]);
    $nomFich = preg_replace("/[^A-Za-z0-9_\- ]/", "", $nomFich);
    if (!$nomFich) {
        displayListaFich("Nombre de fichero inválido - por favor, inténtelo de nuevo");
        return;
    }
    $nomFich .= ".txt";
    $pathfich = PATH_TO_FILES . "/$nomFich";
    if (file_exists($pathfich)) {
        displayListaFich("El fichero $nomFich ya existe!");
    } else {
        if (file_put_contents($pathfich, "") === false) {
            $formulario = "No puede crearse el fichero";
            $datos = array(
                "formulario" => $formulario,
                "titulo" => TITULO
            );
            $plantilla = "plantillas/plantilla.html";
            $html = respuesta($datos, $plantilla);
            print($html);
        } else {
            displayEditForm("$nomFich");
        }
    }
}

function respuesta($datos, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($datos as $key => $dato) {
        $cadena = '{' . $key . '}';
        $html = str_replace($cadena, $dato, $html);
    }
    return($html);
}
