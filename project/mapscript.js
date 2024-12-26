/**
 * Create new map
 */
var infowindow;
var map;
var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';

var myOptions = {
    zoom: 10,
    center: new google.maps.LatLng(7.8731, 80.7718),
    mapTypeId: 'roadmap'
};
map = new google.maps.Map(document.getElementById('map'), myOptions);

/**
 * Global marker object that holds all markers.
 */
var markers = {};

/**
 * Generates a unique marker ID using lat and lng.
 */
var getMarkerUniqueId = function (lat, lng) {
    return lat + '_' + lng;
};

/**
 * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
 */
var getLatLng = function (lat, lng) {
    return new google.maps.LatLng(lat, lng);
};

/**
 * Binds click event to map and adds a new marker to clicked location.
 */
var addMarker = google.maps.event.addListener(map, 'click', function (e) {
    var lat = e.latLng.lat(); // lat of clicked point
    var lng = e.latLng.lng(); // lng of clicked point
    var markerId = getMarkerUniqueId(lat, lng); // an ID that will be used to cache this marker in markers object.
    var marker = new google.maps.Marker({
        position: getLatLng(lat, lng),
        map: map,
        animation: google.maps.Animation.DROP,
        id: 'marker_' + markerId,
        html: "    <div id='info_" + markerId + "'>\n" +
            "        <table class=\"map1\">\n" +
            "            <tr>\n" +
            "            <tr><td></td><td><input type='button' value='Save' onclick='saveData(" + lat + "," + lng + ",\"" + markerId + "\")'/></td></tr>\n" +
            "        </table>\n" +
            "    </div>"
    });
    markers[markerId] = marker; // cache marker in markers object
    bindMarkerinfo(marker); // bind infowindow with click event to marker
});

/**
 * Binds click event to given marker and shows the info window without removing the marker.
 */
var bindMarkerinfo = function (marker) {
    google.maps.event.addListener(marker, "click", function (point) {
        var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
        var marker = markers[markerId]; // find marker
        infowindow = new google.maps.InfoWindow();
        infowindow.setContent(marker.html);
        infowindow.open(map, marker);
    });
};

/**
 * Removes the marker after saving.
 * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
 * @param {!string} markerId Id of marker.
 */
var removeMarker = function (marker, markerId) {
    marker.setMap(null); // set markers setMap to null to remove it from map
    delete markers[markerId]; // delete marker instance from markers object
};

/**
 * Save marker data and remove the marker after saving.
 * @param lat  A latitude of marker.
 * @param lng A longitude of marker.
 * @param markerId The ID of the marker to remove.
 */
function saveData(lat, lng, markerId) {
    var lat1 = document.getElementById('lat');
    var lng1 = document.getElementById('lng');

    lat1.value = lat;
    lng1.value = lng;

    // Once saved, remove the marker and close the infowindow
    var marker = markers[markerId];
    if (marker) {
        removeMarker(marker, markerId); // Remove marker from map
    }

    if (infowindow) {
        infowindow.close(); // Close the info window
    }

    // Example of saving the data (e.g., sending it to the server)
    // var description = document.getElementById('manual_description').value;
    // var url = 'locations_model.php?add_location&description=' + description + '&lat=' + lat + '&lng=' + lng;
}
