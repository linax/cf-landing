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
                    var popupText = "Cantidad reservados " + data.datos_estacionamientos[i].cant_est_reservados;

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
            url: "https://nestapi-nine.vercel.app/building",
            type: "GET",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            dataType: 'json',
            success: function(data){ //data es todo lo que devuelve el controlador

                for (var i=0; i<data.length; i++) {
                    var evaluationPin = data[i].evaluationPin

                   if(evaluationPin.evaluationPinType.id == 2){

                        var popupText = evaluationPin.title+ " "+ evaluationPin.latitude + " " + evaluationPin.longitude ;
                        var acc = evaluationPin.weighted_evaluation;  
                        var markerLocation = new L.LatLng(evaluationPin.latitude, evaluationPin.longitude);
                        var icono;

                        //Se indica el tipo de icono que se desplegará

                        if(acc==1){
                            icono = greenIcon;
                        }
                        else {
                            if(acc==3) { icono =redIcon;  }
                                else { icono = yellowIcon;}
                        }


                     // L.marker(markerLocation, {icon: icono}).addTo(map).bindPopup(popupText)

                     var marker = new L.Marker(markerLocation, {icon: icono});
                     map.addLayer(marker);
                 
                     marker.bindPopup(popupText);
                   }
                }                         
            },
            failure: function(){
                console.log("no se pudo conectar");
            }
        });

}