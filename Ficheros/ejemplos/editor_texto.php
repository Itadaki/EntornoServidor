<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
define("PATH_TO_FILES", ".");
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
    displayCabecera();
    if (!file_exists(PATH_TO_FILES))
        die("Directorio no encontrado");
    if (!($dir = opendir(PATH_TO_FILES)))
        die("No puede abrirse el directorio");
    ?>
    <?php if ($mensaje) echo '<p class="error">' . $mensaje . '</p>' ?>
    <h2>Selecciona un fichero para editar:</h2>
    <table cellspacing="0" border="0" style="width:40em;border:1px solid #666;">
        <tr>
            <th>Nombre Fichero</th>
            <th>Tamaño (bytes)</th>
            <th>Última modificación</th>
        </tr>
        <?php
        while ($nomFich = readdir($dir)) {
            $pathfich = PATH_TO_FILES . "/$nomFich";
            if ($nomFich != "." && $nomFich != ".." && !is_dir($pathfich) && strrchr($nomFich, ".") == ".txt") {
                echo '<tr><td><a href="editor_texto.php?nomFich=' . urlencode($nomFich) . '">' . $nomFich . '</a></td>';
                echo '<td>' . filesize($pathfich) . '</td>';
                echo '<td>' . date("M j, Y H:i:s", filemtime($pathfich)) . '</td></tr>';
            }
        }
        closedir($dir);
        ?>
    </table>
    <h2>...o crea un nuevo fichero:</h2>
    <form action="editor_texto.php" method="post">
        <div style="width: 20em;">
            <label for="nomFich">Nombre de Fichero</label>
            <div style="float: right; width: 7%; margin-top: 0.7em;">.txt</div>
            <input type="text" name="nomFich" id="nomFich" style="width: 50%;" value="" >
            <div style="clear: both;">
                <input type="submit" name="crearFich" value="Crear Fichero" >
            </div>
        </div>
    </form>
    </body>
    </html>
    <?php
}

function displayEditForm($nomFich = "") {
    if (!$nomFich)
        $nomFich = basename($_GET["nomFich"]);
    if (!$nomFich)
        die("Nombre de fichero inválido");
    $pathfich = PATH_TO_FILES . "/$nomFich";
    if (!file_exists($pathfich))
        die("Archivo no encontrado");
    displayCabecera();
    ?>
    <h2>Editando <?php echo $nomFich ?></h2>
    <form action="editor_texto.php" method="post">
        <div style="width: 40em;">
            <input type="hidden" name="nomFich" value="<?php echo htmlspecialchars($nomFich) ?>" />
            <textarea name="contenidosFich" id="contenidosFich" rows="20" cols="80" style="width: 100%;"><?php
            echo htmlspecialchars(file_get_contents($pathfich))
            ?></textarea>
            <div style="clear: both;">
                <input type="submit" name="salvarFich" value="Salvar Fichero" >
                <input type="submit" name="cancelar" value="cancelar" style="margin-right: 20px;" >
            </div>
        </div>
    </form>
    </body>
    </html>
    <?php
}

function salvarFich() {
    $nomFich = basename($_POST["nomFich"]);
    $pathfich = PATH_TO_FILES . "/$nomFich";
    if (file_exists($pathfich)) {
        if (file_put_contents($pathfich, $_POST["contenidosFich"]) === false)
            die("No puede salvarse el fichero");
        displayListaFich();
    } else {
        die("Fichero no encontrado");
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
        if (file_put_contents($pathfich, "") === false)
            die("No puede crearse el fichero");
        displayEditForm("$nomFich");
    }
}

function displayCabecera() {
    ?>
    <head>
        <title>Un sencillo editor de texto</title>
        <link rel="stylesheet" type="text/css" href="common.css" />
        <style type="text/css">
            .error {background: #d33; color: white; padding: 0.2em;}
            th {text-align: left; background-color: #999;}
            th, td {padding: 0.4em;}
        </style>
    </head>
    <body>
        <h1>Un sencillo editor de texto</h1>
    <?php
}
?>