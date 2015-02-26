/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 24-feb-2015
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

function pedirCiudades() {
    var origen = document.getElementById('origen');
    peticion_http = inicializa_xhr();
    if (peticion_http) {
        peticion_http.onreadystatechange = procesaRespuesta;
        peticion_http.open("POST", "./destinos2.php", true);
        var query = "origen=" + origen.value + "&nocache=" + Math.random();
        peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        peticion_http.send(query);
    }
}

/*
 Respuesta del servidor
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
            var documento_xml = peticion_http.responseXML;
            var root = documento_xml.getElementsByTagName("destinos")[0];
            var ciudades = root.getElementsByTagName("ciudad");
            if (ciudades.length > 0) {
                for (var i = 0; i < ciudades.length; i++) {
                    var ciudad = ciudades[i];
                    var option = document.createElement("option");
                    option.value = ciudad.firstChild.firstChild.nodeValue;
                    option.text = ciudad.lastChild.firstChild.nodeValue;
                    console.log(option);
                    destinos.options.add(option, 1);
                }
            }
        }
    }
}
function validar() {
    var nombre = document.getElementById('nombre').value;
    var ap1 = document.getElementById('ap1').value;
    var ap2 = document.getElementById('ap2').value;
    if (validarNombre(nombre)
            && validarNombre(ap1)
            && validarNombre(ap2)
            && validarDni()
            && validarTelefono()
            && validarMail()
            && document.getElementById('origen').value !== ''
            && document.getElementById('destino').value !== '') {
        return true;
    }
    console.log('algo mal');
    return false;
}

function validarNombre(nombre) {
    if (/^[a-zA-ZáéíóúÁÉÍÓÚ]+[- a-zA-ZáéíóúÁÉÍÓÚ]*$/.test(nombre)) {
        return true;
    }
    console.log(nombre + ' mal');
    return false;
}

function validarDni() {
    var valor = document.getElementById("dni").value.toUpperCase();
    var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F',
        'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V',
        'H', 'L', 'C', 'K', 'E', 'T'];
    if (!(/^\d{8}[A-Z]$/.test(valor))) {
        console.log('dni mal');
        return false;
    }
    if (valor.charAt(8) !== letras[(valor.substring(0, 8)) % 23])
    {
        console.log('dni mal');
        return false;
    }
    return true;
}

function validarTelefono() {
    var telefono = document.getElementById("telefono").value;
    if (!(/^[6,9]\d{8}$/.test(telefono))) {
        console.log('dni mal');
        return false;
    }
    return true;
}

function validarMail() {
    var valor = document.getElementById("email").value;
    var expresion = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (expresion.test(valor)) {
        return true;
    }
    console.log('dni mal');
    return false;
}

function habilitarEnvio() {
    var habilitado = true;
    var inputs = document.getElementsByTagName('input');
    if (!document.getElementById('origen').value || !document.getElementById('destino').value) {
        habilitado = false;
    }
    for (var i = 0; i < inputs.length && habilitado; i++) {
        if (!inputs[i].value) {
            habilitado = false;
        }
    }
    document.getElementById('enviar').disabled = !habilitado;
}