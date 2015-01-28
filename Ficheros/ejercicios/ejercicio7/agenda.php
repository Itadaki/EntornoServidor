<?php

include './funciones.php';
include './constantes.php';


if (isset($_POST['entrar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['password'])) {
        comprobarUsuario($_POST['nombre'], $_POST['password']);
    } else {
        login('Usuario o contraseña vacios');
    }
} else if (isset($_GET['add'])) {
    if (isset($_POST['añadirTarea'])) {
        añadirTarea('diego');
    } else {
        verAñadirCita();
    }
} else {
    login();
}


    