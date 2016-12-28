var map;
var address;
var query;
var urhere;

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

function codeAddress(query, e) 
{
    geocoder = new google.maps.Geocoder();
    
    var myOptions = {
     zoom: 15,
     mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var address = query;
    var event = e;
    
    geocoder.geocode({
     'address': address
    }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) 
   {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
       map: map,
       position: results[0].geometry.location
      });
      var infowindow = new google.maps.InfoWindow({
       // content:event+'\n'+address
       content:"活动地点"
      });
      // infowindow.open(map, marker);
   } 
    else 
   {
      $("#map-canvas").css("background", "url('../theme/images/map_background.jpg') no-repeat #fff");
      $("#map-canvas").css("background-size", "cover");
   }
    });
}

function getMyLocation() {
  if (navigator.geolocation) {
    geolocation = window.navigator.geolocation;
        geolocation.getCurrentPosition(
                        getPositionSuccess, getPositionError, {
                            timeout : 5000
                        });
  } else {
    alert("your broswer is no geolocation support"); 
  }
}

function getPositionError(error) { 
  switch (error.code) { 
    case error.PERMISSION_DENIED:
//      alert("location server is refused"); 
      break; 
    case error.POSITION_UNAVAILABLE:
//      alert("cannot get the location infomation"); 
      break; 
    case error.TIMEOUT:
//      alert("time out"); 
      break; 
    default: 
      alert("unknow error"); 
      break; 
  } 
}

function getPositionSuccess(position) 
{
  //The latitude and longitude values obtained from HTML 5 API.
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    //Creating a new object for using latitude and longitude values with Google map.
    var latLng = new google.maps.LatLng(latitude, longitude);
    start = latLng.lat() + ", " + latLng.lng();
    directionsDisplay = new google.maps.DirectionsRenderer();
    var styles = [
      {
        featureType: "all",
        stylers: [
          { saturation: -80 }
        ]
      },{
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
          { hue: "#00ffee" },
          { saturation: 50 }
        ]
      },{
        featureType: "poi.business",
        elementType: "labels",
        stylers: [
          { visibility: "off" }
        ]
      }
    ];
    
  var styledMap = new google.maps.StyledMapType(styles,
      {name: "Styled Map"});
    
    var mapOptions = {
      zoom:15,
      center: latLng,
      mapTypeIds: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    //map.mapTypes.set('map_style', styledMap);
    //map.setMapTypeId('map_style');
    directionsDisplay.setMap(map);
    createMarker(latLng); 
}

function createMarker(latLng, placeResult) 
{
    if (placeResult) 
    {
      var markerOptions = {
      position: latLng,
      map: map,
      animation: google.maps.Animation.DROP,
      clickable: true
    }
    //Setting up the marker object to mark the location on the map canvas.
    var marker = new google.maps.Marker(markerOptions);
      var content = placeResult.name+"<br/>"+placeResult.vicinity+"<br/>"+placeResult.types;
      addInfoWindow(marker, latLng, content);
    }
    else 
    {
        var markerMe = {
          position: latLng,
          map: map,
          title: "你现在的位置",
          streetViewControl:true,
          animation:google.maps.Animation.BOUNCE,
          clickable: true
        }
       
        //Setting up the marker object to mark the location on the map canvas.
        var marker1 = new google.maps.Marker(markerMe);

        urhere = latLng.lat() + ", " + latLng.lng();
        var content = "你在这里: " + urhere;
        addInfoWindow(marker1, latLng, content);
    }
}

function addInfoWindow(marker, latLng, content) 
{
    var infoWindowOptions = {
      content: content,
      position: latLng
    };
    var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
    google.maps.event.addDomListener(marker, "click", function() {
      infoWindow.open(map);
    });
}

function calcRoute(latLng) 
{
  getMyLocation();
  var end = document.getElementById('end').value; //æŠŠè¿™é‡Œçš„æ•°æ®æ¢æˆformä¸­çš„æ•°æ®å°±å¯ä»¥äº†
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}