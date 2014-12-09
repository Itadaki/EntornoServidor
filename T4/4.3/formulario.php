<?php

function displayForm() {
    ?>
    <style type="text/css">
        .error { background: #d33; color: white; padding: 0.2em; }
    </style>
    <h1>Encuesta</h1>
    <?php if (isset($_POST["nombreUsuario"]) && empty($_POST["nombreUsuario"]) or isset($_POST["nombreUsuario"]) && !preg_match("/^[a-zA-Z][a-zA-Z]+$/", $_POST["nombreUsuario"])) { ?>
        <p class="error">Hubo algunos problemas con el formulario que usted presentó.
            Por favor, rellene el campo <b>Nombre</b> correctamente.</p>
    <?php }
    if (isset($_POST["apellidos"]) && empty($_POST["apellidos"]) or isset($_POST["apellidos"]) && !preg_match("/^[a-zA-Z] [a-zA-Z]+$/", $_POST["apellidos"])) {
        ?>
        <p class="error">Hubo algunos problemas con el formulario que usted presentó.
            Por favor, rellene el campo <b>Apellidos</b> correctamente.</p>
    <?php }
    ?>
    <form action = "" method = "post">
        <fieldset>
            <label for="nombreUsuario">Introduce tu nombre * </label>
            <input type = "text" name = "nombreUsuario" id="nombreUsuario" value="<?php setValue("nombreUsuario") ?>">
            <label for="apellidos">y tus apellidos *</label>
            <input type = "text" name = "apellidos" id="apellidos" value="<?php setValue("apellidos") ?>" ><br><br>
            <label for="tipoMusica">¿Qué tipo de música te gusta escuchar?</label>
            <select name="tipoMusica[]" id="tipoMusica" size="4" multiple="multiple">
                <option value="Rock"<?php setSelected("tipoMusica", "Rock") ?>>Rock </option>
                <option value="Pop"<?php setSelected("tipoMusica", "Pop") ?>>Pop </option>
                <option <?php if (!isset($_POST['enviar'])) echo 'selected'; ?>value="Regee"<?php setSelected("tipoMusica", "Regee") ?>>Regee </option>
                <option <?php if(!isset($_POST['enviar'])) echo 'selected' ?>value="Clásica"<?php setSelected("tipoMusica", "Clásica") ?>>Clásica </option>
            </select><br><br>
            ¿Que tipo de libros lees? <br>
            <label for="novelaNegra">Novela Negra</label>
            <input type="checkbox" name="tipoLibros[]" id="novelaNegra"
                   value="Novela Negra"<?php setChecked("tipoLibros", "Novela Negra") ?>><br>
            <label for="cienciaFiccion">Ciencia Ficción</label>
            <input type="checkbox" name="tipoLibros[]" id="cienciaFiccion"
                   value="Ciencia Ficción" <?php setChecked("tipoLibros", "Ciencia Ficción") ?>><br>
            <label for="fantasia">Fantasía</label>
            <input type="checkbox" name="tipoLibros[]" id="fantasia" value="Fantasía" <?php setChecked("tipoLibros", "Fantasía") ?>><br><br>
            <input type = "submit" name="enviar" value="Enviar">
        </fieldset>
    </form>
    <?php
}
