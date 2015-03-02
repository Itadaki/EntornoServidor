/*
 Autor=HÃ©ctor Espinosa Torres
 Fecha=09-ene-2015
 Licencia=gpl30
 version=1.0
 Descripcion=En este javascript se realiza una peticion ajax con formato json en el envio y xml en la respuesta para rellenar un select de especialidades
 correspondiente a la titulacion seleccionada por el usuario.
 
 
 Copyright (C) 2015 HÃ©ctor Espinosa Torres
 
 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//Laura: ¿por qué elegidas es global?
var elegidas = new Array();
var contElegidas = 0;
var contSinRepetir = 0;
var sinRepetir = new Array();

var peticion_http = null;
//FunciÃ³n para obtener la instancia del objeto XMLHttpRequest


//Laura: no gestionas repetidos, el código mejor comentado
function crea_json() {
    /*Aqui creamos el objeto que le vamos a enviar al servidor*/
    var opciones = document.getElementById("titulacion").childNodes;
    for (var i = 0; i < opciones.length; i++) {
        if (opciones[i].selected) {
            //Laura: si usas un contador que vas incrementando globalmente, le mandas repetidas siempre
            elegidas[contElegidas] = opciones[i].value;
            contElegidas++;
        }
    }

    var JSONObject = new Object();
    JSONObject.titulaciones = elegidas;
    var objeto_json = JSON.stringify(JSONObject);
    return objeto_json;

}
function valida() {

    peticion_http = new XMLHttpRequest();
    if (peticion_http) {
        peticion_http.onreadystatechange = procesaRespuesta;
        peticion_http.open("POST", "servidor7.php", true);
        peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var parametros_json = "titulacion=" + crea_json();
        peticion_http.send(parametros_json);
    }
}

function procesaRespuesta() {
    /*En esta funcion gestionamos la respuesta que nos envia el servidor*/

    if (peticion_http.readyState == 4) {
        if (peticion_http.status == 200) {

            var respuesta = peticion_http.responseXML;

            var especialidades = respuesta.getElementsByTagName("especialidad");

            /*eliminarRepetidos(especialidades);*/

            for (var i = 0; i < especialidades.length; i++) {
                var especialidad = new Option(especialidades[i].firstChild.nodeValue, especialidades[i].firstChild.nodeValue);

                document.getElementById("especialidades").options[i] = especialidad;
            }
        }
    }
}

/*No e conseguido que funcione, me da un error de que no se puede leer la propiedad 0 de undefined.
 * Por lo tanto no la he usado.
 * La idea era pasarle el array propiedades y eliminar los duplicados*/
function eliminarRepetidos(element) {
    for (var i = 0; i < element.length; i++) {
        var elegida = element.childNodes[i].nodeValue;
        for (var j = 0; j < element.length; j++) {
            if (elegida == element[j].firstChild.nodeValue) {
                break;
            } else {
                sinRepetir[contSinRepetir] = elegida;
                contSinRepetir++;
            }
        }
    }

}


        