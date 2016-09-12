<?php 
require('controllers/controller.php');
//get page data
$page = new controller();
$data = $page->map();
//extra page vars
$metaTitle = 'Earthquake Map';
$activePage = 'map';
$scripts = null;
$css = null;
?>


<?php require_once('assets/page_elements/header.php');?>
<div class="container-fluid main-content padding-left0 padding-right0">
    <?php require_once('assets/page_elements/side_bar.php');?>
    <div class="col-sm-9">
        <div class="row content margin1">
            <?php 
            //check for errors
            if($data['data']['error']){
                echo '<h2>'.$data['data']['errorMessage'].'</h2>';
            }elseif($data['filter']['startDate'] == '24 hours'){?>
                <h3><?php echo $data['data']['metadata']['count']; ?> total earthquakes in the past 24 hours.</h3>
            <?php }else{ ?>
                <h3><?php echo $data['data']['metadata']['count']; ?> total earthquakes between <?php echo $data['filter']['startDate']; ?> and <?php echo $data['filter']['endDate']; ?>.</h3>
            <?php } ?>
            <div id='map_canvas'></div>
        </div>
    </div>
</div>

<script>
    function initMap() {
        //our new map
        var map;
        var bounds = new google.maps.LatLngBounds();
        map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: {lat: 42.877742, lng: -97.380979},
            zoom: 4
        });
        //set all the markers for the earth quakes
        var markers = [
            <?php 
            foreach($data['data']['features'] as $earthquake){
                echo '["'.$earthquake['properties']['place'].'",'.$earthquake['geometry']['coordinates'][1].','.$earthquake['geometry']['coordinates'][0].'],';
            }
            ?>
        ];
        //add content to the bubbles
        var infoWindowContent = [
            <?php 
            foreach($data['data']['features'] as $earthquake){
                //convert given time of milliseconds to seconds to convert to datetime
                $formatTime = $earthquake['properties']['time']/1000;
                echo '["<h3>'.$earthquake['properties']['title'].'</h3><ul><li>Date: '.date('F j, Y, g:i a',$formatTime).'</li><li>Magnatude: '.$earthquake['properties']['mag'].'</li></ul>"],';
            }
            ?>
        ];
        
        //add the conntent to the map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0]
            });   
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            map.fitBounds(bounds);
        }
        //center the map to where the most pins are
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(2);
            google.maps.event.removeListener(boundsListener);
        });
    }
    
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAABmap-L1P5yGifOgkxPplORlBMMfvRes&callback=initMap" async defer></script>

<?php require_once('assets/page_elements/footer.php');?>









       
