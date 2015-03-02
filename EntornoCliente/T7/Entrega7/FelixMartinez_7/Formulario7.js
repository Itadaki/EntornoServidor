/*
 * Autor = Félix Martínez Álvaro
 * Fecha = 27-feb-2015
 * Licencia = gpl30
 * Version = 1.0
 * Descripcion = Js que contiene las funciones de Formulario7.html
 */
/* 
 * Copyright (C) 2014 Félix Martínez Álvaro
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

/**
 * @description array donde voy guardando las opciones seleccionadas para posteriormente enviar o no la peticion Ajax
 * @type Array
 */
var seleccionadas = [];

/**
 * @description funcion que crea un XMLHttpRequest
 * @returns {XMLHttpRequest|ActiveXObject}
 */
function inicializa_xhr() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

/**
 * @description funcion que crea un json con el numero de las titulaciones que se escogen (array)
 * @returns {String}
 */
function crea_json() {
    var index = new Array();
    var titulaciones = document.getElementById("titulacion").options;
    for (var i = 0; i < titulaciones.length; i++) {
        if (titulaciones[i].selected == true) {
            index.push(titulaciones[i].value);
            seleccionadas.push(titulaciones[i].value);
        }
    }
    var JSONObject = new Object();
    JSONObject.titulaciones = index;
    var objeto_json = JSON.stringify(JSONObject);
    return objeto_json;
}


/**
 * 
 * @description funcion que envia los datos al servidor
 */
function valida() {
    if (enviarPeticion()) {
        peticion_http = inicializa_xhr();
        if (peticion_http) {
            peticion_http.onreadystatechange = procesaRespuesta;
            peticion_http.open("POST", "servidor7.php", true);
            var parametros_json = "titulacion=" + crea_json();
            peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            peticion_http.send(parametros_json);

        }
    }
}

/**
 * @description funcion que retorna un booleano.
 * false = la option seleccionada ya ha sido enviada anteriormente. true = la option no ha sido enviada anteriormente
 * @returns {Boolean}
 */
function enviarPeticion() {
    var titulaciones = document.getElementById("titulacion").options;
    for (var i = 0; i < titulaciones.length; i++) {
        //Laura: es más eficiente hacer la comprobación al construir el JSON, te ahorra este bucle y la función repetido
        //Laura: Así están haciendo la misma comprobación en dos sitios diferentes
        if (titulaciones[i].selected == true) {
            for (var j = 0; j < seleccionadas.length; j++) {
                if (seleccionadas[j] === titulaciones[i].value) {
                    return false;
                }
            }
        }
    }
    return true;
}

/**
 * 
 * @returns funcion que recibe el XML del servidor y con DOM lo muestra en un select
 */
function procesaRespuesta() {

    if (peticion_http.readyState == READY_STATE_COMPLETE) {
        if (peticion_http.status == 200) {
            var xml = peticion_http.responseXML;

            var respuesta = xml.getElementsByTagName("respuesta")[0];

            var titulaciones = respuesta.getElementsByTagName("titulacion");

            for (var i = 0; i < titulaciones.length; i++) {

                var especialidades = titulaciones[i].getElementsByTagName("especialidad");

                for (var j = 0; j < especialidades.length; j++) {
                    if (repetido(especialidades[j].firstChild.nodeValue)) {
                        document.getElementById('especialidades').options[document.getElementById('especialidades').options.length] = new Option(especialidades[j].firstChild.nodeValue, especialidades[j].firstChild.nodeValue);
                    }
                }
            }

        }
    }
}

/**
 * @description funcion que recibe un parametro y retorna un booleano segun si el elemento esta o no en el select
 * @param {String} elem
 * @returns {Boolean}
 */
function repetido(elem) {
    var especialidades = document.getElementById("especialidades").options;

    for (var i = 0; i < especialidades.length; i++) {
        if (especialidades[i].value === elem) {

            return false;
        }

    }
    return true;
}


/**
 * 
 * @description instruccion que añade un atributo onclick al boton "b1"
 */
document.getElementById("b1").setAttribute("onclick", "valida()");