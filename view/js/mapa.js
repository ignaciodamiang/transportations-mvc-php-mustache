function loadMap() {

    /*var mapOptions = {
        center:new google.maps.LatLng(-34.6686986,-58.5614947),
        zoom:12,
        panControl: false,
        zoomControl: false,
        scaleControl: false,
        mapTypeControl:false,
        streetViewControl:true,
        overviewMapControl:true,
        rotateControl:true,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(-34.6686986,-58.5614947),
        map: map,
        animation:google.maps.Animation.BOUNCE,
        draggable: true
    });

    google.maps.event.addListener(map, "click", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        
        document.getElementById("latitudCombustible").value =lat;
        document.getElementById("longitudCombustible").value =lng;

        document.getElementById("latitudGastos").value =lat;
        document.getElementById("longitudGastos").value =lng;

        document.getElementById("latitudPocicionActual").value =lat;
        document.getElementById("longitudPocicionActual").value =lng;


    }); */

    var map;
    var mapOptions = {
        zoom:12,
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