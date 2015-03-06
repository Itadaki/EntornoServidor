/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 24-feb-2015
 * Licencia = gpl30
 * Version = 1.0
 * Descripcion = Contiene funciones para la compra de billetes
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


var READY_STATE_COMPLETE = 4;
var peticion_http = null;
//Función para obtener la instancia del objeto XMLHttpRequest
function inicializa_xhr() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}
/**
 * @description Realiza la peticion ajax para rellenar el select destino
 */
function pedirCiudades() {
    var origen = document.getElementById('origen');
    peticion_http = inicializa_xhr();
    if (peticion_http) {
        peticion_http.onreadystatechange = procesaRespuesta;
        peticion_http.open("POST", "./destinos.php", true);
        var query = "origen=" + origen.value + "&nocache=" + Math.random();
        peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        peticion_http.send(query);
    }
}

/*
 * Respuesta del servidor
 * <destinos>
 *   <ciudad>
 *     <id>#</id>
 *     <nombre>""</nombre>
 *   </ciudad>
 *   <ciudad>
 *     <id>#</id>
 *     <nombre>""</nombre>
 *   </ciudad>
 * </destinos>
 */
/**
 * @description Procesa la respuesta AJAX e inserta en el select destino
 */
function procesaRespuesta() {
    if (peticion_http.readyState === READY_STATE_COMPLETE) {
        if (peticion_http.status === 200) {
            var destinos = document.getElementById('destino');
            while (destinos.options.length > 1) {
                destinos.remove(1);
            }
            if (document.getElementById('origen').value !== '') {
                destinos.disabled = false;
            } else {
                destinos.disabled = true;
            }
            var root = peticion_http.responseXML.getElementsByTagName("destinos")[0];
            var ciudades = root.getElementsByTagName("ciudad");
            if (ciudades.length > 0) {
                for (var i = 0; i < ciudades.length; i++) {
                    var ciudad = ciudades[i];
                    var option = document.createElement("option");
                    option.value = ciudad.firstChild.firstChild.nodeValue;
                    option.text = ciudad.lastChild.firstChild.nodeValue;
                    destinos.options.add(option, 1);
                }
            }
        }
    }
}

var error = '';
/**
 * @description Permite o no el envio del formulario
 * @returns {Boolean}
 */
function validar() {
    error = '';
    var nombre = document.getElementById('nombre').value;
    var ap1 = document.getElementById('ap1').value;
    var ap2 = document.getElementById('ap2').value;
    validarNombre(nombre + ap1 + ap2);
    validarDni();
    validarTelefono();
    validarMail();
    if (!error && document.getElementById('origen').value !== ''
            && document.getElementById('destino').value !== '') {
        return true;
    }
    document.getElementById('error').innerHTML = error;
    document.getElementById('error').className = 'open';
    return false;
}
/**
 * @description Valida un nombre
 * @param {type} nombre
 * @returns {Boolean}
 */
function validarNombre(nombre) {
    if (/^[a-zA-ZáéíóúÁÉÍÓÚ]+$/.test(nombre)) {
        return true;
    }
    error += '<li>El <span>nombre</span> o los <span>apellidos</span> que ha introducido es inválido</li>';
    return false;
}
/**
 * @description Valida tamaño y letra del DNI
 * @returns {Boolean}
 */
function validarDni() {
    var valor = document.getElementById("dni").value.toUpperCase();
    var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F',
        'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V',
        'H', 'L', 'C', 'K', 'E', 'T'];
    if (!(/^\d{8}[A-Z]$/.test(valor)) 
            ||valor.charAt(8) !== letras[(valor.substring(0, 8)) % 23]) {
        error += '<li>El <span>DNI</span> que ha introducido es inválido</li>';
        return false;
    }
    return true;
}
/**
 * @description Valida un telefono fijo o movil
 * @returns {Boolean}
 */
function validarTelefono() {
    var telefono = document.getElementById("telefono").value;
    if (!(/^[6,9]\d{8}$/.test(telefono))) {
        error += '<li>El <span>teléfono</span> que ha introducido es inválido</li>';
        return false;
    }
    return true;
}
/**
 * @description Valida la forma de un email
 * @returns {Boolean}
 */
function validarMail() {
    var valor = document.getElementById("email").value;
    var expresion = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (expresion.test(valor)) {
        return true;
    }
    error += '<li>El <span>email</span> que ha introducido es inválido</li>';
    return false;
}
/**
 * @description Habilita el boton de envio
 */
function habilitarEnvio() {
    var habilitado = true;
    var inputs = document.getElementsByTagName('input');
    if (!document.getElementById('origen').value || !document.getElementById('destino').value) {
        habilitado = false;
    }
    for (var i = 0; i < inputs.length && habilitado; i++) {
        if (!inputs[i].value) {
            habilitado = false;
            break;
        }
    }
    document.getElementById('enviar').disabled = !habilitado;
}