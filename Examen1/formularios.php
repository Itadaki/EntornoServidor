<?php
/**
* Autor = Diego Rodríguez Suárez-Bustillo
* Fecha = 27-oct-2014
* Licencia = gpl30 
* Version = 1.0
* Descripcion = Formularios
*/
function formularioDatos($nombre, $calle, $numero, $puerta, $localidad) {
    echo '<h4>Por favor, introduce tus datos:</h4>';
    echo '<form method="POST" action="">';
    echo '<b>Nombre:</b> <input type="text" name="nombre" value="' . $nombre . '" /><br>';
    echo '<b>Calle:</b> <input type="text" name="calle" value="' . $calle . '" /> ';
    echo '<b>Número:</b> <input type="text" name="numero" value="' . $numero . '" size="3" /> ';
    echo '<b>Puerta:</b> <input type="text" name="puerta" value="' . $puerta . '" size="1" />';
    echo '<b>Localidad:</b> <input type="text" name="localidad" value="' . $localidad . '" /> ';
    echo '<input type="submit" value="Enviar" name="enviar_datos" />';
    echo '</form>';
}

function formularioPizza() {
    $nombre = $_POST['nombre'];
    echo "<h3>Bienvenido, $nombre, elige el tamaño y los ingredientes de nuestro único tipo de pizza: LAMASCARA</h3>";
    echo '<form method="POST" action="">';
    echo 'Tamaño de la pizza<br>';
    echo '<input type="radio" name="tamaño" value="Pequeña" />Pequeña ';
    echo '<input type="radio" name="tamaño" value="Mediana" checked />Mediana ';
    echo '<input type="radio" name="tamaño" value="Grande" />Grande<br><br>';
    echo 'Indica los ingredientes:<br>';
    echo 'Champiñon <input type="checkbox" name="ingredientes[]" value="Champiñon" checked/><br>';
    echo 'Queso <input type="checkbox" name="ingredientes[]" value="Queso" checked/><br>';
    echo 'Jamón <input type="checkbox" name="ingredientes[]" value="Jamón" checked/><br>';
    echo 'Tomate <input type="checkbox" name="ingredientes[]" value="Tomate" /><br><br>';
    echo '<input type="submit" value="Pedir" name="enviar_pizza" />';
    echo '</form>';
    echo '<br><a href="pedido_pizzas.php">Volver</a>';
}
