<?php 
require('controllers/controller.php');
$indexPage = new controller();

$data = $indexPage->index();
//extra page vars
$metaTitle = 'Home';
$activePage = 'home';
$scripts = null;
$css = null;
?>


<?php require_once('assets/page_elements/header.php');?>
<div class="container-fluid main-content padding-left0 padding-right0">    
    <?php require_once('assets/page_elements/side_bar.php');?>
    <div class="col-sm-9">
        <div class="row content padding-left1 padding-right1">
            <h3>Coding Sample</h3>
            <p>This project is a code sample produced by Nate Branning. In this sample is a connection to a outside data feed, http://earthquake.usgs.gov/fdsnws/event/1/. From this feed, I have pulled in data about the number of earthquakes around the world. There are two simple data representations. One is made with Google Maps. I have pulled in the number of eathquakes in a give time frame and plotted them on the map giving the use a visual representation of the earthquakes location. The other is made with a visual representation of a line graph showing then number of earthquakes and the time peroid in which they took place. This data can be be altered by selecting different time periods to pull that data in.</p>
            <p>The languages uses in this project are PHP, JavaScript, HTML, and CSS. PHP is used with OOP and a few base PHP functions. Jquery is used as the main JavaScript framework. Twitter Bootstrap is used for the resposive layout and styling options. One JavaScript plugin was used to produce the datepickers, Bootstrap-datepicker. The line graph was produced using Chart.js The map was produced using Google Maps js api</p>
        </div>
    </div>
</div>
<?php require_once('assets/page_elements/footer.php');?>
