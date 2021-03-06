<?php

/*
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 26-ene-2015
 * Licencia = gpl30 
 * Version = 1.0
 * Descripcion = 
 */

/*
 * Copyright (C) 2015 Diego Rodríguez Suárez-Bustillo
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
include './funciones.php';
include './constantes.php';
session_start();
if (isset($_POST['aPaso2'])) {
    displayPaso2();
} else if (isset($_POST['aPaso3'])) {
    displayPaso3();
} else if (isset($_POST['aPaso1'])) {
    displayPaso1();
} else if (isset($_POST['aFin'])) {
    fin();
} else {
    displayPaso1();
}