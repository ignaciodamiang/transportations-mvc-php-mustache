function loadMap() {

    
    var latitud=document.getElementById("latitudBuscada").value;
    var longitud=document.getElementById("longitudBuscada").value;

    var mapOptions = {
        center:new google.maps.LatLng(latitud,longitud),
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

    var map = new google.maps.Map(document.getElementById("mapa2"),mapOptions);



    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitud,longitud),
        draggable: true,
        map: map
    });

    marker.addEventListener("dragend",function(event) {
        document.getElementById("latitudBuscada").value=this.getPosition().lat();
        document.getElementById("longitudBuscada").value=this.getPosition().lng();
    })


}