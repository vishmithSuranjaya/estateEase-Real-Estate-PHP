<div id="map"></div>

<?php
//include './classes/dbConnector.php';

function get_all_locations(){
    //echo "<script>alert('yes1')</script>";
    
    $dbcon = new dbConnector();
    $con = $dbcon->getConnection();
    // update location with location_status if admin location_status.
    $query ="select longitude,latitude,price,title,category,contact_No from advertisement where category != 'hidden'";
    try{
        $pstmt = $con->prepare($query);
        $pstmt->execute();

        $rows = array();
    while($r = $pstmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $r;
        
    }

  $indexed = array_map('array_values', $rows);
  //  $array = array_filter($indexed);

    echo json_encode($indexed);
    
    if (!$rows) {
        return null;
    }
    }catch(PDOException $e){
        die("Connection failed".$e->getMessage());
      }

    
}


?>
<script>
     
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        var locations = <?php get_all_locations() ?>;
        //var myOptions = {
           // zoom: 7,
            //center: new google.maps.LatLng(7.8731, 80.7718),
            //mapTypeId: 'roadmap'
        //};
        
       // map = new google.maps.Map(document.getElementById('map'), myOptions);
        
        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId= function(lat, lng) {
            return lat + '_' + lng;
        };
       

        var map;
    var marker;
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations = <?php get_all_locations() ?>;

    function initMap() {
      
        var colombo = {lat: 7.8731, lng: 80.7718};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: colombo,
            zoom: 8
        });


        var i ;
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][0]),
                map: map,
                icon : red_icon,
                html: document.getElementById('form')
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    //confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                   // $("#confirmed").prop(confirmed,locations[i][4]);
                    $("#price").val(locations[i][2]);
                    $("#title").val(locations[i][3]);
                   $("#category").val(locations[i][4]);
                   $("#contact_No").val(locations[i][5]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

    
 
</script>





<script async defer
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw&callback=initMap">
</script>

<div style="display:none;" id="form">
    <table class="map1">
        <tr>
            <td>Title:</td>
            <td><input id="title" type="text" readonly=""</td>
        </tr>
        
        <tr>
            <td>Price:</td>
            <td><input id="price" type="text" readonly=""</td>
        </tr>
        
        <tr>
            <td>Category</td>
            <td><input id="category" type="text" readonly=""</td>
        </tr>
       
        <tr>
            <td>Contact No:</td>
            <td><input type="text" id="contact_No" readonly=""</td>
        </tr>
    </table>
</div>