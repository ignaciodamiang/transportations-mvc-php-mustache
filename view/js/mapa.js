function loadMap() {

    var map;


    var mapOptions = {
        zoom:15,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var mapOptions2 = {
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
        })


        google.maps.event.addListener(map, "click", function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            
            var latlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
            var geocoder = geocoder = new google.maps.Geocoder();
    
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {                        
                       document.getElementById("lugarActualCombustible").value=results[0].formatted_address;
                       document.getElementById("lugarActualGastos").value=results[0].formatted_address;
                       document.getElementById("lugarActual").value=results[0].formatted_address;
                    }
                }
            })
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                animation:google.maps.Animation.BOUNCE,
                draggable: true  
            });

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



