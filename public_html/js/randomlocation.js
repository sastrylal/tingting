var distanceLimit = 2000; //in meters
var numberRandomPoints = 20;
var mapZoomLevel = 11;
var locationindex = 0;
var locations = [

    {'name': 'Hyderabad, India', 'latitude': 17.4659902, 'longitude': 78.42914259999999}

];

var markers = [];
var currentcircle;

//Create the default map
var mapcenter = new google.maps.LatLng(locations[locationindex].latitude, locations[locationindex].longitude);
var myOptions = {
    zoom: mapZoomLevel,
    scaleControl: true,
    center: mapcenter
};
var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

var centermarker,  mappoints;
$(document).ready(function(evt)
{
    if (navigator.geolocation)
        navigator.geolocation.getCurrentPosition(showPosition);

});

function showPosition(position) {

    $('#latitude').val( position.coords.latitude);
    $('#longitude').val(position.coords.longitude);

    locations = [

        {'name': 'Hyderabad, India', 'latitude':  position.coords.latitude, 'longitude':  position.coords.latitude}

    ];

    centermarker = addCenterMarker(mapcenter, locations[locationindex].name + '<br>' + locations[locationindex].latitude + ', ' + locations[locationindex].longitude);
    mappoints = generateMapPoints(locations[locationindex], distanceLimit, numberRandomPoints);
    drawRadiusCircle(map, centermarker, distanceLimit);
    createRandomMapMarkers(map, mappoints);
}

$('#createMarkers').on('click',function(evt)
{
    evt.preventDefault();
    //Draw default items

    clearMarkers();

    mapcenter = new google.maps.LatLng(locations[0].latitude, locations[0].longitude);
    map.panTo(mapcenter);
    centermarker = addCenterMarker(mapcenter, locations[0].name + '<br>' + locations[0].latitude + ', ' + locations[0].longitude);
    mappoints = generateMapPoints(locations[0], distanceLimit, numberRandomPoints);

    //Draw default items
    currentcircle.setMap(null);
    drawRadiusCircle(map, centermarker, distanceLimit);
    createRandomMapMarkers(map, mappoints);
    counter = 0;
    pushDataToTingTing();
});


//web.tingtingapp.com/api/create_post/
//{"auth_token": "72b32a1f754ba1c09b3695e0cb6cde7f", "content":"valuelabs",
//    "latitude":"17.449444", "longitude":"78.372506"


var counter =0
function pushDataToTingTing()
{
   console.log( mappoints[0].latitude , mappoints[0].longitude);
    var obj = {"auth_token": "72b32a1f754ba1c09b3695e0cb6cde7f", "content":"valuelabs", "latitude":mappoints[counter].latitude, "longitude":mappoints[counter].longitude};
    JSON.stringify(obj);
    $.ajax({
        url:'http://web.tingtingapp.com/api/create_post/',
        async: true,
        type:"POST",
        crossDomain : true,
        data:obj,        
        dataType: "json",        
        success:function(data){
            counter++;
            if (counter < 20) pushDataToTingTing();

        }
    });
}






//Draw default items
//var centermarker = addCenterMarker(mapcenter, locations[locationindex].name + '<br>' + locations[locationindex].latitude + ', ' + locations[locationindex].longitude);
//var mappoints = generateMapPoints(locations[locationindex], distanceLimit, numberRandomPoints);
//drawRadiusCircle(map, centermarker, distanceLimit);
//createRandomMapMarkers(map, mappoints);

//Create random lat/long coordinates in a specified radius around a center point
function randomGeo(center, radius) {
    var y0 = center.latitude;
    var x0 = center.longitude;
    var rd = radius / 111300; //about 111300 meters in one degree

    var u = Math.random();
    var v = Math.random();

    var w = rd * Math.sqrt(u);
    var t = 2 * Math.PI * v;
    var x = w * Math.cos(t);
    var y = w * Math.sin(t);

    //Adjust the x-coordinate for the shrinking of the east-west distances
    var xp = x / Math.cos(y0);

    var newlat = y + y0;
    var newlon = x + x0;
    var newlon2 = xp + x0;

    return {
        'latitude': newlat.toFixed(5),
        'longitude': newlon.toFixed(5),
        'longitude2': newlon2.toFixed(5),
        'distance': distance(center.latitude, center.longitude, newlat, newlon).toFixed(2),
        'distance2': distance(center.latitude, center.longitude, newlat, newlon2).toFixed(2),
    };
}

//Calc the distance between 2 coordinates as the crow flies
function distance(lat1, lon1, lat2, lon2) {
    var R = 6371000;
    var a = 0.5 - Math.cos((lat2 - lat1) * Math.PI / 180) / 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * (1 - Math.cos((lon2 - lon1) * Math.PI / 180)) / 2;
    return R * 2 * Math.asin(Math.sqrt(a));
}

//Generate a number of mappoints
function generateMapPoints(centerpoint, distance, amount) {
    var mappoints = [];
    for (var i=0; i<amount; i++) {
        mappoints.push(randomGeo(centerpoint, distance));
    }
    return mappoints;
}

//Add a unique center marker
function addCenterMarker(centerposition, title) {

    var infowindow = new google.maps.InfoWindow({
        content: title
    });

    var newmarker = new google.maps.Marker({
        icon: 'http://google.com/mapfiles/ms/micons/ylw-pushpin.png',
        position: mapcenter,
        map: map,
        title: title,
        zIndex: 3
    });

    google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
        infowindow.open(map,newmarker);
    });

    markers.push(newmarker);
    return newmarker;
}

//Draw a circle on the map
function drawRadiusCircle (map, marker, distance) {
    currentcircle = new google.maps.Circle({
        map: map,
        radius: distance
    });
    currentcircle.bindTo('center', marker, 'position');
}

//Create markers for the randomly generated points
function createRandomMapMarkers(map, mappoints) {
   // alert(mappoints.length);
    //return;
    for (var i = 0; i < mappoints.length; i++) {
        //Map points without the east/west adjustment
        var newmappoint = new google.maps.LatLng(mappoints[i].latitude, mappoints[i].longitude);
        var marker = new google.maps.Marker({
            position:newmappoint,
            map: map,
            title: mappoints[i].latitude + ', ' + mappoints[i].longitude + ' | ' + mappoints[i].distance + 'm',
            zIndex: 2
        });
        markers.push(marker);

        //Map points with the east/west adjustment
        var newmappoint = new google.maps.LatLng(mappoints[i].latitude, mappoints[i].longitude2);
        var marker = new google.maps.Marker({
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/pink.png',
            position:newmappoint,
            map: map,
            title: mappoints[i].latitude + ', ' + mappoints[i].longitude2 + ' | ' + mappoints[i].distance2 + 'm',
            zIndex: 1
        });
        markers.push(marker);
    }
}

//Destroy all markers
function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}

$('#location_switch').change(function() {
    var newlocation = $(this).val();

    clearMarkers();

    mapcenter = new google.maps.LatLng(locations[newlocation].latitude, locations[newlocation].longitude);
    map.panTo(mapcenter);
    centermarker = addCenterMarker(mapcenter, locations[newlocation].name + '<br>' + locations[newlocation].latitude + ', ' + locations[newlocation].longitude);
    mappoints = generateMapPoints(locations[newlocation], distanceLimit, numberRandomPoints);

    //Draw default items
    currentcircle.setMap(null);
    drawRadiusCircle(map, centermarker, distanceLimit);
    createRandomMapMarkers(map, mappoints);
});



