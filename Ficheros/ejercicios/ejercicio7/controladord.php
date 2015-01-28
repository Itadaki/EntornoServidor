<?php

include './funciones.php';
include './constantes.php';


if (isset($_GET['login'])) {
    if (isset($_POST['entrar'])) {
        if (!empty($_POST['nombre']) && !empty($_POST['password'])) {
            comprobarUsuario($_POST['nombre'], $_POST['password']);
        } else {
            login('Usuario o contraseña vacios');
        }
    } else {
        login();
    }
} else if (isset($_GET['registrar'])) {
    if (isset($_POST['nombre'])) {
        guardarDatos();
    } else {
        registrar();
    }
} else if(isset($_GET['add'])){
    añadirCita();
}else {
    bienvenida();
}

