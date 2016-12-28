document.write("<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></script>");

$("#map-canvas").ready(function() {
	var mapOptions = {
        center: new google.maps.LatLng(40.722354, -73.994305),
        zoom: 13,
        zoomControl: true,
        styles: [
            {
                featureType: "all",
                elementType: "labels",
                stylers: [
                    { visibility: "on" }
                ]
            }
        ]
    };
    
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var marker = new google.maps.Marker({
    	position: new google.maps.LatLng(40.722354, -73.994305),
    	map: map,
    	title: "Event Location",
    	draggable: true
    });

    google.maps.event.addDomListener(map, "click", function(event){
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        marker.setPosition(new google.maps.LatLng(lat, lng));
    });
});