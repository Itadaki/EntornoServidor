<?php

//Establece si un campo esta pendiente o mal rellenado
function validateField($nombreCampo, $camposPendientes, $camposMal) {
    if (in_array($nombreCampo, $camposPendientes)) {
        return ' class="error"';
    }
    if (in_array($nombreCampo, $camposMal)) {
        return ' class="error_formato"';
    }
}

//Rellena las etiquetas
function respuesta($resultados, $plantilla) {
    $file = $plantilla;
    $html = file_get_contents($file);
    foreach ($resultados as $key1 => $valor1) {
        if (count($valor1) > 1) {
            foreach ($valor1 as $key2 => $valor2) {
                $cadena = "{" . $key1 . " " . $key2 . "}";
                $html = str_replace($cadena, $valor2, $html);
            }
        } else {
            $cadena = "{" . $key1 . "}";
            $html = str_replace($cadena, $valor1, $html);
        }
    }
    return $html;
}

//Comprueba la foto y la mueve - Devuelve un mensaje de error
function comprobarFoto($nombreFoto) {
    $mensaje='';
    if (isset($_FILES[$nombreFoto]) && $_FILES[$nombreFoto]["error"] == UPLOAD_ERR_OK && $_FILES[$nombreFoto]["type"] == "image/png") {
        move_uploaded_file($_FILES[$nombreFoto]["tmp_name"], "fotos/" . basename($_FILES[$nombreFoto]["name"]));
//        Si controlas el formato del archivo y no subes archivo, entra aqui
//    } else if ($_FILES[$nombreFoto]["type"] != "image/png") {
//        $mensaje = "Formato de archivo no soportado (solo PNG) en $nombreFoto";
    } else {
        switch ($_FILES[$nombreFoto]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                $mensaje = "La foto es más grande de lo que permite el servidor en $nombreFoto.<br>";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $mensaje = "La foto es más grande de lo que permite el formulario en $nombreFoto.<br>";
                break;
            case UPLOAD_ERR_NO_FILE:
                $mensaje = "No se ha subido ningún archivo en $nombreFoto.<br>";
                break;
            default:
                $mensaje = "Póngase en contacto con el administrador del servidor para obtener ayuda en $nombreFoto.<br>";
        }
    }
    return $mensaje;
}

//función que muestra el contenido de los campos de texto ya rellenados
function setValue($nombreCampo) {
    if (isset($_POST[$nombreCampo])) {
        return $_POST[$nombreCampo];
    }
}

// función que selecciona el contenido de los campos de lista
function setSelected($nombreCampo, $valorCampo) {
    if (isset($_POST[$nombreCampo])) {
        if ($_POST[$nombreCampo] == $valorCampo) {
            return ' selected="selected"';
        }
    }
}
