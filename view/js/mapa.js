function loadMap() {

    var map;
    var mapOptions = {
        zoom:15,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);

    navigator.geolocation.getCurrentPosition(function(position){

        var geolocate= new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(position.coords.latitude,position.coords.longitude),
            map: map,
            animation:google.maps.Animation.BOUNCE,
            draggable: true  
        });



        google.maps.event.addListener(map, "click", function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            
            var latlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
            var geocoder = geocoder = new google.maps.Geocoder();
    
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                       document.getElementById("lugarActualCombustible").value=results[1].formatted_address;
                       document.getElementById("lugarActualGastos").value=results[1].formatted_address;
                       document.getElementById("lugarActual").value=results[1].formatted_address;
                    }
                }
            })


            document.getElementById("latitudCombustible").value =lat;
            document.getElementById("longitudCombustible").value =lng;
    
            document.getElementById("latitudGastos").value =lat;
            document.getElementById("longitudGastos").value =lng;
    
            document.getElementById("latitudPocicionActual").value =lat;
            document.getElementById("longitudPocicionActual").value =lng;
         
        });



        map.setCenter(geolocate);
    } )

}

/*window.onload = function () {
    var mapOptions = {
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var infoWindow = new google.maps.InfoWindow();
    var latlngbounds = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);

    google.maps.event.addListener(map, 'click', function (e) {

        var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
        var geocoder = geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    alert("Location: " + results[1].formatted_address + "\r\nLatitude: " + e.latLng.lat() + "\r\nLongitude: " + e.latLng.lng());
                }
            }
        });
    });
}*/