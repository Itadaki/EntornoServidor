<?php
$s = '';
if (isset($_GET['eliminar'])) {
    setcookie('contador', '1', -1);
    $s.= "Contador de accesos eliminado";
} else if (isset($_COOKIE['contador'])) {

    if ($_COOKIE['contador'] == 1) {
        $s.= 'Esta es tu primera visita';
        setcookie('contador', '2');
    } else {
        $v = $_COOKIE['contador'];
        $s.="Esta es tu visita número " . $v;
        setcookie('contador', $v + 1);
    }
} else {
    setcookie('contador', '1');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Trabajando con cookies</h1>
        <b>Contador de accesos</b>
        <p>
            <?php echo "$s"; ?></p>
        <a href="?" >Actualizar</a>
        <a href="?eliminar=true" >Eliminar</a>
    </body>
</html>
