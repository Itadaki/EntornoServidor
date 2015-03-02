/*
 Autor=Alvaro Camarero Barrio
 Fecha=27-feb-2015
 Licencia=Expression proyecto is undefined on line 4, column 12 in Templates/ClientSide/javascript.js.
 Version=Expression version is undefined on line 5, column 11 in Templates/ClientSide/javascript.js.
 Descripcion= Laura Falta
 */

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. Laura: ¡La plantilla!
 */


var xhr = null;
/**
 *@description Esta funcion sirve para obtener la instancia del objeto XMLHttpRequest
 * es valida para todos los navegadores incluso los antiguos.
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
 * @description creamos el objeto json para el envio al servidor.
 */
function crea_json() {
    var JSONObject = new Object();
    var formacion = new Array(); // creamos un arry para las titulaciones
    var seleccion = document.getElementById("titulacion").selectedOptions;
    var contador = 0;
//recorremos el array seleccion y vemos cual esta seleccionada para posteriormente meterla en el aaray titulacion
    for (var i = 0; i < seleccion.length; i++) {
        if (seleccion[i].selected == true) {
            formacion[contador] = seleccion[i].value;
            contador++;
        }
    }
    JSONObject.titulaciones = formacion;

    var objeto_json = JSON.stringify(JSONObject);
    return objeto_json;
}
/**
 * @description funcion validar es la que envia al servidor el onjeto json.
 */

function valida() {
    xhr = inicializa_xhr();
    if (xhr) {
        xhr.onreadystatechange = procesaRespuesta;
        xhr.open("POST", "servidor7.php", true);
        var parametros = crea_json();
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("titulacion=" + parametros);
    }
}
/**
 * @description funcion procesar la respuesta del servidor en xml
 */

function procesaRespuesta() {
    //Laura: se borra el select y no se mantienen las anteriores
    //Laura: no gestiona por tanto repetidas y no se vitan peticiones ajax innecesarias
    if (document.getElementById("especialidades").getElementsByTagName("option").length > 0) {// este if es para borrar la lista al volver a seleccionar otra cosa en la primera
        for (var i = document.getElementById("especialidades").getElementsByTagName("option").length - 1; i >= 0; i--) {
            if (i >= 0) {
                var tagOption = document.getElementById("especialidades").getElementsByTagName("option")[i];
                document.getElementById("especialidades").removeChild(tagOption);
            }
        }
    }
    //Laura: el código anterior no tiene sentido hacerlo fuera de estos if
    if (xhr.readyState == 4 && xhr.status == 200) {
        var xml = xhr.responseXML;
        var tagRespuesta = xml.getElementsByTagName("respuesta")[0];
        var tagTitulacion = tagRespuesta.getElementsByTagName("titulacion");

        var especialidadSeleccionado = document.getElementById('especialidades').selectedOptions;
        var hay = false;

        for (var i = 0; i < tagTitulacion.length; i++) {//Recorremos cada etiqueta de xml
            var especialidad = tagTitulacion[i].getElementsByTagName('especialidad');//Creamos la especialidad que se ha seleccionado
            for (var j = 0; j < especialidad.length; j++) {//otro for para recorrer las especialidades que hemos creado
                for (var k = 0; k < especialidadSeleccionado.length; k++) {//opciones que han sido seleccionadas
                    if (especialidad[j].outerHTML == especialidadSeleccionado[k].value) {//este es para que si ya hay cosas en la segunda lista no los vuelva a añadir y se dupliquen
                        hay = true;
                    }
                }
                if (hay == false) {// si no hay la añade
                    var opciones = new Option(especialidad[j].firstChild.nodeValue, especialidad[j].firstChild.nodeValue);
                    document.getElementById('especialidades').appendChild(opciones);
                }
            }
        }
    }
}


