<div class="col-sm-3 sidenav padding-top1">
    <div class="navbar navbar-default " role="navigation">
        
        
        
        <h3>Earthquake Tracker</h3>
        <div class="navbar-header">
            
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php if($activePage == 'home') echo 'active';?>"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="<?php if($activePage == 'map') echo 'active';?>"><a href="map.php"><i class="fa fa-map"></i> Earthquake Map</a></li>
                <li class="<?php if($activePage == 'data') echo 'active';?>"><a href="data.php"><i class="fa fa-database"></i> Earthquake Data</a></li>
            </ul>
        </div>
    </div>
    
    <?php 
    if(isset($pageFilters)){
        echo '<div class="headerBar margin-top5"></div>';
        echo '<h4>Filter Data</h4>';
        require_once($pageFilters);
    }
    ?>
</div>
