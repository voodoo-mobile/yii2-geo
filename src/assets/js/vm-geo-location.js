$(document).ready(function() {
    locationInfo = $('.vm-geo-location');

    if(navigator.geolocation && locationInfo.data('is-located') != 1) {
        navigator.geolocation.getCurrentPosition(function (position){
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var url = locationInfo.data('url');

            $.post(url, { lat: latitude, lng: longitude })
                .done(function( data ) {
                    window.location.reload()
                });

        }, function (err) {
            console.warn('ERROR(' + err.code + '): ' + err.message);
        }, {
            timeout : 10000,
            enableHighAccuracy : true
        });
    }
});