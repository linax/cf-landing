
var inicio ="/ciudadfacil/";
var ext ="php";
var esFil = "getTableParkingData";
var barFil = "getTableBarrierData";
var lugFil = "getPlaceDataMap";


function estMapa(map, parkIcon, s)
{

      $.ajax({
            url: inicio+esFil+"."+ext,
            type: "GET",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            dataType: 'json',
            success: function(data){ //data es todo lo que devuelve el controlador
   

                for (var i=0; i<data.datos_estacionamientos.length; i++) {
                    var lon = data.datos_estacionamientos[i].longitud;
                    var lat = data.datos_estacionamientos[i].latitud;
                    var popupText = data.datos_estacionamientos[i].comentario;

                     var markerLocation = new L.LatLng(lat, lon);
                     //Se indica el tipo de icono que se desplegará
                     var marker = new L.Marker(markerLocation, {icon: parkIcon});
                     map.addLayer(marker);
                 
                     marker.bindPopup(popupText);
                 }                         
            },
            failure: function(){
                console.log("no se pudo conectar");
            }
        });

}

function barrMapa(map, barrIcon)
{

    //Agrega barreras

      $.ajax({
             url: inicio+barFil+"."+ext,
            type: "GET",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            dataType: 'json',
            success: function(data){ //data es todo lo que devuelve el controlador

                for (var i=0; i<data.datos_barreras.length; i++) {
                    var lon = data.datos_barreras[i].longitud;
                    var lat = data.datos_barreras[i].latitud;
                    var popupText = data.datos_barreras[i].tipo;
                    var descrip= data.datos_barreras[i].descripcion;
                    
                     var markerLocation = new L.LatLng(lat, lon);
                     var icono;
                     //Se indica el tipo de icono que se desplegará

                     var marker = new L.Marker(markerLocation, {icon: barrIcon});
                     map.addLayer(marker);
                 
                     marker.bindPopup(popupText);
                 }                         
            },
            failure: function(){
                console.log("no se pudo conectar");
            }
        });
}


function lugMapa(map, redIcon, greenIcon, yellowIcon)
{

        $.ajax({
            url: inicio+lugFil+"."+ext,
            type: "GET",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            dataType: 'json',
            success: function(data){ //data es todo lo que devuelve el controlador

                for (var i=0; i<data.datos_lugares.length; i++) {
           
                    var lon = data.datos_lugares[i].longitud;
                    var lat = data.datos_lugares[i].latitud;
                    var popupText = data.datos_lugares[i].titulo;
                    var acc_ext = data.datos_lugares[i].acc_ext;
                    var acc_int = data.datos_lugares[i].acc_int;      
                     var markerLocation = new L.LatLng(lat, lon);
                     var icono;

                     //Se indica el tipo de icono que se desplegará

                     if(acc_ext==0 && acc_int==0){
                        icono = greenIcon;
                     }
                     else {
                         if(acc_ext==2 && acc_int==2) { icono =redIcon;  }
                            else { icono = yellowIcon;}
                     }

                     var marker = new L.Marker(markerLocation, {icon: icono});
                     map.addLayer(marker);
                 
                     marker.bindPopup(popupText);
                     }                         
            },
            failure: function(){
                console.log("no se pudo conectar");
            }
        });

}