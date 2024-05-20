var latitude = -39.813300;
var longitude = -73.248536;



var map;


   function showLocation(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        map.setView([latitude, longitude], 
    16);
    //  console.log("Latitude : " + latitude + " Longitude: " + longitude);
    }

    function errorHandler(err) {
        if(err.code == 1) {
            
            console.log("Error: Access is denied!");
            
        }else if( err.code == 2) {
            console.log("Error: Position is unavailable!");
        }
    }
      
    function getLocation(){

        if(navigator.geolocation){
            // timeout at 60000 milliseconds (60 seconds)
            var options = {timeout:60000};
            navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
        }else{
            console.log("Sorry, browser does not support geolocation!");
        }
        }

var data;

getLocation();
 map = L.map('map').
setView([latitude, longitude], 
16);
 
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Ciudad Fácil &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
    maxZoom: 18
}).addTo(map);

L.control.scale().addTo(map);
//L.marker([latitude, longitude], {draggable: false}).addTo(map);

var imgIcons = [['images/icons/alta.png', 'Lugar Accesible'],['images/icons/media.png','Lugar accesibilidad media'],['images/icons/baja.png', 'Lugar No accesible'], ['images/icons/estac.png', 'Estacionamiento reservado'],['images/icons/barrera.png', 'Barrera en acera']];
var shadow = 'images/icons/shadow.png'

var greenIcon = L.icon({
    iconUrl: 'images/icons/alta.png',
    shadowUrl: shadow,

    iconSize:     [50, 50], // size of the icon
    shadowSize:   [50, 30], // size of the shadow
    iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
    shadowAnchor: [10,2],  // the same for the shadow
    popupAnchor:  [0, -5] // point from which the popup should open relative to the iconAnchor
});


var yellowIcon = L.icon({
    iconUrl: 'images/icons/media.png',
    shadowUrl: shadow,
    iconSize:     [50, 50], // size of the icon
    shadowSize:   [50, 30], // size of the shadow
    iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
    shadowAnchor: [10,2],  // the same for the shadow
    popupAnchor:  [0, -5] // point from which the popup should open relative to the iconAnchor
});

var redIcon = L.icon({
    iconUrl: 'images/icons/baja.png',
    shadowUrl: shadow,
    iconSize:     [50, 50], // size of the icon
    shadowSize:   [50, 30], // size of the shadow
    iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
     shadowAnchor: [10,2],  // the same for the shadow
    popupAnchor:  [0, -5] // point from which the popup should open relative to the iconAnchor
});

var parkIcon = L.icon({
    iconUrl: 'images/icons/estac.png',
    shadowUrl: shadow,
    iconSize:     [50, 50], // size of the icon
    shadowSize:   [50, 30], // size of the shadow
    iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
    shadowAnchor: [10,2],  // the same for the shadow
    popupAnchor:  [0, -5] // point from which the popup should open relative to the iconAnchor
});

var barrIcon = L.icon({
    iconUrl: 'images/icons/barrera.png',
    shadowUrl: shadow,
    iconSize:     [50, 50], // size of the icon
    shadowSize:   [50, 30], // size of the shadow
    iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
    shadowAnchor: [10,2],  // the same for the shadow
    popupAnchor:  [0, -5] // point from which the popup should open relative to the iconAnchor
});


//Agrega Lugares
lugMapa(map, redIcon, greenIcon, yellowIcon);
//Agrega barreras
//barrMapa(map, barrIcon);
//Agrega Estacionamientos
//estMapa(map, parkIcon);

//Leyenda

var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'info legend');

  for (var i=0; i<imgIcons.length; i++){
       div.innerHTML +=
      '<img src='+ imgIcons[i][0]+' alt="legend" width="30" height="30" >'+"  "+imgIcons[i][1]+'<br>';
  }
      return div;
};

legend.addTo(map);




