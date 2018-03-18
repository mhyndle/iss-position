function initMap() {
    var mapContainer = document.getElementById('map');
    var issPosition = {
        lat: parseFloat(mapContainer.dataset.latitude),
        lng: parseFloat(mapContainer.dataset.longitude)
    };
    var map = new google.maps.Map(mapContainer, {
        zoom: 2,
        center: issPosition
    });
    var marker = new google.maps.Marker({
        position: issPosition,
        map: map
    });
}