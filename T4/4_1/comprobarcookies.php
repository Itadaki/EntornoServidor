<?php

if (!isset($_COOKIE['Comprobar'])) {
    setcookie('Comprobar', 1, time() + 3600);
    header('Refresh: 5; url=http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    echo 'Comprobando si tiene activadas las cookies<br/>';
    echo 'Esta comprobación se repetirá cada 5 segundos';
} else {
    echo 'Gracias por activar las cookies';
}

