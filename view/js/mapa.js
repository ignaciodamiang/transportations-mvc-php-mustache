function loadMap() {

    var mapOptions = {
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
        animation:google.maps.Animation.BOUNCE
    });

    google.maps.event.addListener(map, "click", function(event) {
        var inputLatitud = document.getElementById("latitud");
        var inputLongitud = document.getElementById("longitud");
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        inputLatitud.value = lat;
        inputLongitud.value = lng;
    
    });

}