/*
 * Autor=Javier Salcedo
 * Fecha=27-feb-2015
 * Licencia=gpl30
 * Version=1.0
 * Descripcion=JavaScript que recibe un html es formato JSON y devulve un XML
 */


/* 
 * Copyright (C) 2015 Javier Salcedo
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


var peticion_http = null;

/**
 * @name valida
 * @description funcion siempre necesaria Laura: comenta correctamente las funciones
 */
function valida() {
    peticion_http = new XMLHttpRequest();
    if (peticion_http) {
        peticion_http.onreadystatechange = procesaRespuesta;
        peticion_http.open("POST", "servidor7.php", true);
        var parametros_json = "titulacion=" + crea_json();
        peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        peticion_http.send(parametros_json);
    }
}

/**
 * @name crea_json
 * @returns {objeto_json}
 * @description funcion que crea el JSON que se enviara al servidor
 */
function crea_json() {
    var JSONObject = new Object();
    var guardar = new Array();
    var titulacionOp = document.getElementById("titulacion");
    var cont = 0;
    for (var i = 0; i < titulacionOp.length; i++) {
        if (titulacionOp[i].selected > 0) {
            guardar[cont] = titulacionOp[i].value;
            cont++;
        }
    }
    JSONObject.titulaciones = guardar;
    var objeto_json = JSON.stringify(JSONObject);
    return objeto_json;
}

/**
 * @name procesaRespuesta
 * @description funcion que genera la respuesta del servidor en formato XML
 */
function procesaRespuesta() {
    if (peticion_http.readyState == 4) {
        if (peticion_http.status == 200) {
            var d = peticion_http.responseXML;
            var buleano = false;
            var titulacion = d.getElementsByTagName('titulacion');
            var esp = document.getElementById('especialidades');
            var valor;
            //Laura: se pueden obtener directamente los tags especialidad
            for (i = 0; i < titulacion.length; i++) { //para recorrer tag  <titulacion> y sacar tags <especialidad> del php
                var especialidad = titulacion[i].getElementsByTagName('especialidad');
                for (j = 0; j < especialidad.length; j++) { //recorrer tags <especialidad> y sacar los que estaba escrito dentro del tag <especialidad> del php
                    for (k = 0; k < esp.length; k++) { //recorrer select especialidades del html
                        valor = especialidad[j].firstChild.nodeValue; //valor que habia dentro del tag <especialidad> del php
                        //Laura: el control de repetidso es más eficiente hacerlo en el JSON para evitar ka petición AJAX
                        if (valor == esp[k].value) { //para saber si ya esta escrito dentro de el select especialidades del html
                            buleano = true;
                        }
                    }
                    if (buleano == false) { //si no estaba escrito lo rellena
                        var option = new Option(especialidad[j].firstChild.nodeValue, especialidad[j].firstChild.nodeValue);
                        document.getElementById('especialidades').appendChild(option);
                    }
                }
            }
        }
    }
}