/* ----- Google Map ----- */
if ($("#map").length) {
    function initialize() {
        var myLatLng = {lat: 23.037376, lng: 72.513038}; 
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            styles: [
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#999999"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": -33
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#b1b1b1"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#d1d1d1"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#aaaaaa"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": -15
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#999999"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": -6
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#afe0ff"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                }
            ],
            center: myLatLng //please add your location here
        };

        var map = new google.maps.Map(document.getElementById('map'),
            mapOptions);
        var marker = new google.maps.Marker({
            position: {lat: 23.037376, lng: 72.513038},
            icon: 'img/location-pin.png', //if u want custom
            animation: google.maps.Animation.DROP,
            map: map,
            title:"ZooBiz"
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
}