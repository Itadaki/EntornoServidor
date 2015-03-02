/* 
 * Autor = Diego Rodríguez Suárez-Bustillo
 * Fecha = 27-feb-2015
 * Licencia = gpl30
 * Version = 1.0
 * Descripcion = Contiene funciones para gestionar peticiones AJAX 
 * e insertar la respuesta en el documento html
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

/**
 * @description Codigo para una peticion completa.
 * @constant
 * @type Number
 */
var READY_STATE_COMPLETE = 4;
/**
 * @description Codigo para el estado http OK.
 * @constant
 * @type Number
 */
var STATUS_OK = 200;
/**
 * @description Objeto para la peticion ajax.
 * @type ActiveXObject|XMLHttpRequest
 */
var peticion_http = null;
/**
 * @description Array con los indices ya enviados.
 * @type Array
 */
var titulosEnviados = new Array();
/**
 * @description Obtiene una instancia del objeto XMLHttpRequest.
 * @returns {ActiveXObject|XMLHttpRequest}
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
 * @description Envia la peticion ajax si se crea un query.
 */
function enviarPeticion() {
    //Si el objeto XMLHttpRequest esta correctamente inicializado
    if (peticion_http) {
        var query = crearQuery();
        //Si se ha podido crear la query (hay cosas para enviar):
        if (query) {
            peticion_http.onreadystatechange = procesaRespuesta;
            peticion_http.open("POST", "servidor7.php", true);
            peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            peticion_http.send(query);
        }
    }
}
/**
 * @description Crea la query para el envio AJAX.<br>
 * Si no hay titulos seleccionados o ya se han enviado devuelve una cadena vacia.
 * @returns {String}
 */
function crearQuery() {
    var json = new Object();
    json.titulaciones = getTitulos();
    //Si el array devuelto esta vacio devuelve el query
    if (json.titulaciones.length) {
        return 'titulacion=' + JSON.stringify(json);
    }
    return '';
}
/**
 * @description Crea un array con los titulos seleccionados y que no se hayan enviado.
 * @returns {Array}
 */
function getTitulos() {
    var opciones = document.getElementById('titulacion').options;
    var seleccionados = new Array();
    for (var i = 0; i < opciones.length; i++) {
        //Si hay titulos seleccionados y no estan en el array de ya enviados
        //los añado al array de seleccionados
        if (opciones[i].selected && titulosEnviados.indexOf(opciones[i].value) === -1) {
            seleccionados.push(opciones[i].value);
            titulosEnviados.push(opciones[i].value);
        }
    }
    return seleccionados;
}
/**
 * @description Gestiona el XML de respuesta e inserta las especialidades en su campo select.
 */
function procesaRespuesta() {
    if (peticion_http.readyState === READY_STATE_COMPLETE) {
        if (peticion_http.status === STATUS_OK) {
            var especialidades = document.getElementById('especialidades');
            var xml = peticion_http.responseXML;
            //Como no hay que diferenciar entre titulaciones
            //basta con obtener un array con todos los tag especialidad recibidos
            var arrEspecialidad = xml.getElementsByTagName('especialidad');
            for (var i = 0; i < arrEspecialidad.length; i++) {
                //Añadir cada especialidad como Option (texto, value)
                especialidades.add(new Option(arrEspecialidad[i].firstChild.nodeValue, i));
            }
        }
    }
}
/**
 * Inicializar y usar un solo objeto XMLHttpRequest para todas las peticiones
 */
window.onload = function () {
    peticion_http = inicializa_xhr();
};