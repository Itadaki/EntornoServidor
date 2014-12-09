<?php
/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 30-oct-2014
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = 
 */

/*
 * Copyright (C) 2014 Diego Rodríguez Suárez-Bustillo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function displayForm($campospendientes) {
    ?>
    <style type="text/css">
        .error { background: #d33; color: white; padding: 0.2em; }
    </style>
    <h1>Encuesta</h1>
    <?php if ($campospendientes) { ?>
        <p class="error">Hubo algunos problemas con el formulario que usted presentó.
            Por favor, complete correctamente los campos remarcados de abajo y haga clic en Enviar para volver a enviar el formulario.</p>
    <?php } else { ?>
        <p>por favor, rellene sus datos a continuación y haga clic en Enviar.
            Los campos marcados con un asterisco (*) son obligatorios.</p>
    <?php } ?>
    <form action = "" method = "post">
        <fieldset>
            <label for="nombreUsuario" <?php validateField("nombreUsuario", $campospendientes) ?>>Introduce tu nombre * </label>
            <input type = "text" name = "nombreUsuario" id="nombreUsuario" value="<?php setValue("nombreUsuario") ?>">
            <label for="apellidos" <?php validateField("apellidos", $campospendientes) ?>>y tus apellidos *</label>
            <input type = "text" name = "apellidos" id="apellidos" value="<?php setValue("apellidos") ?>" ><br><br>
            <label for="tipoMusica">¿Qué tipo de música te gusta escuchar?</label>
            <select name="tipoMusica[]" id="tipoMusica" size="4" multiple="multiple">
                <option value="Rock"<?php setSelected("tipoMusica", "Rock") ?>>Rock </option>
                <option value="Pop"<?php setSelected("tipoMusica", "Pop") ?>>Pop </option>
                <option value="Regee"<?php setSelected("tipoMusica", "Regee") ?>>Regee </option>
                <option value="Clásica"<?php setSelected("tipoMusica", "Clásica") ?>>Clásica </option>
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
?>