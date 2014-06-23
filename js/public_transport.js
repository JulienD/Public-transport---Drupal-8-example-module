(function ($, Drupal, drupalSettings) {
    "use strict";
    /**
     *
     */
    Drupal.behaviors.jsTestBlackWeight = {
        attach: function(context, settings) {
            if (navigator.geolocation) {
                var timeoutVal = 10 * 1000 * 1000;
                navigator.geolocation.getCurrentPosition(
                    displayPosition,
                    displayError,
                    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
                );
            }
            else {
                document.getElementById('map-canvas').innerHTML = 'No Geolocation Support.';
            }

            function displayPosition(position) {
                var mapOptions = {
                    zoom: 17,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                };

                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var userGeolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                var userPosition = new google.maps.Marker({
                    map: map,
                    position: userGeolocate,
                    title: "User"
                });


                // @See https://drupal.org/node/2138117 for ajax bug

                var path = "http://drupal8.local/public-transport/ajax/velib?lat=" + position.coords.latitude + '&lng=' + position.coords.longitude + '&limit=5';

                var jsonData;

                var markers = [];

                $.ajax({
                    url: path,
                    dataType: 'html', // Defined as html and not json fixed the problem.
                    type: "GET",
                    success: function(response) {
                        jsonData = response;
                        console.log(jsonData);

                        var stations = JSON.parse(jsonData);

                        var infowindow = new google.maps.InfoWindow({maxWidth: 200});

                        for (var id in stations) {
                            var station = stations[id];

                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(station.position.lat, station.position.lng),
                                map: map,
                                title: station.name,
                                icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
                            });

                            var contentString = '<div id="content">'+
                                '<h4 id="firstHeading" class="firstHeading">' + station.name + '</h4>'+
                                '<div id="bodyContent">'+
                                '<p>Address: ' + station.address + '</p>'+
                                '<p>Available bikes: ' + station.available_bikes + '</p>'+
                                '<p>Available bike stands: ' + station.available_bike_stands + '</p>'+
                                '</div>';

                            makeInfoWindowEvent(map, infowindow, contentString, marker);

                            markers.push(marker);

                        }
                    }
                })
                .fail(function() {
                    alert( "error" );
                });


                map.setCenter(userGeolocate);

            }

            function makeInfoWindowEvent(map, infowindow, contentString, marker) {
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                });
            }

            function displayError(error) {
                var errors = {
                    1: 'Permission denied',
                    2: 'Position unavailable',
                    3: 'Request timeout'
                };
                alert("Error: " + errors[error.code]);
            }

            google.maps.event.addDomListener(window, 'load');

        }
    };
})(jQuery, Drupal, drupalSettings);
