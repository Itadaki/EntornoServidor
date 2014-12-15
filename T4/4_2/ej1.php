<!DOCTYPE>
</html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>
    <?php
    if (isset($_POST["enviar"])) {
        guardarInfo();
    } elseif (isset($_GET["accion"]) and $_GET["accion"] == "olvidar") {
        olvidarInfo();
    } else {
        visualizarPagina();
    }

    function guardarInfo() {
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $motor = $_POST['motor'];
        $cilindrada = $_POST['cilindrada'];
        $combustible = $_POST['combustible'];
        $expira = time() + (600);

        setcookie('coche["modelo"]', $modelo, $expira);
        setcookie('coche["marca"]', $marca, $expira);
        setcookie('coche["motor"]', $motor, $expira);
        setcookie('coche["cilindrada"]', $cilindrada, $expira);
        setcookie('coche["combustible"]', $combustible, $expira);

        echo "Información guardada:<br>"
        . "$modelo<br>"
        . "$marca<br>"
        . "$motor<br>"
        . "$cilindrada<br>"
        . "$combustible<br>"
        . "<a href='?accion=olvidar'>olvidar info</a>";
    }

    function olvidarInfo() {
        foreach ($_COOKIE['coche'] as $key => $value) {
            setcookie("coche[$key]", "", -1);
        }
        header('Location: ej1.php');
    }

    function visualizarPagina() {
        ?>
        <form method="POST" action="">
            Modelo <input type="text" name="modelo" value="" /><br>
            Marca <input type="text" name="marca" value="" /><br>
            Motor <input type="text" name="motor" value="" /> <br>
            Cilindrada <input type="text" name="cilindrada" value="" /><br>
            Combustible 
            <input type="radio" name="combustible" value="gasolina" checked />Gasolina 
            <input type="radio" name="combustible" value="diesel" />Diesel<br>
            <input type="submit" value="Enviar" name="enviar"/>
        </form>
        <?php
    }
    