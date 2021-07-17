function loadMap2() {
    var map2;
    var mapOptions = {
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map2 = new google.maps.Map(document.getElementById("mapa2"), mapOptions);

    navigator.geolocation.getCurrentPosition(function (position) {

        var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        var marker2 = new google.maps.Marker({
            position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
            map: map2,
            animation: google.maps.Animation.BOUNCE,
            draggable: true
        });


        google.maps.event.addListener(map2, "click", function (event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();

            var latlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
            var geocoder = geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                'latLng': latlng
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        document.getElementById("lugarIncio").value = results[0].formatted_address;
                    }
                }
            })
            var marker2 = new google.maps.Marker({
                position: latlng,
                map: map2,
                animation: google.maps.Animation.BOUNCE,
                draggable: true
            });

            document.getElementById("latitud_inicio").value = lat;
            document.getElementById("longitud_inicio").value = lng;


        });

        map.setCenter(geolocate);
    })

}