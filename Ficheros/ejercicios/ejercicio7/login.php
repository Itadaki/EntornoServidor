<?php

include './funciones.php';
include './constantes.php';


if (isset($_GET['login'])) {
    header('Location: agenda.php');
} else if (isset($_GET['registrar'])) {
    if (isset($_POST['nombre'])) {
        guardarDatos();
    } else {
        registrar();
    }
    añadirCita();
} else {
    bienvenida();
}

