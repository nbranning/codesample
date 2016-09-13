<?php 
require('controllers/controller.php');
$page = new controller();

$data = $page->data();
//var_dump($data);
//extra page vars
$metaTitle = 'Earthquake Data Center';
$activePage = 'data';
$scripts = '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script><script src="/codetest/assets/js/bootstrap-datepicker.min.js"></script>';
$css = '<link rel="stylesheet" href="/codetest/assets/css/bootstrap-datepicker.min.css">';
$pageFilters = 'assets/page_elements/data_filter.php';

if(!$data['data']['error']){
    $earthquakeTimeArray = array();
    $magAvg = 0;
    $counter = 0;
    $lowMag = 1;//set to a higher number to get the real low mag. This number can be a negative
    $highMag = 0;
    $totalEnergyRelease = 0;
    foreach($data['data']['features'] as $earthquake){
        //get the energy released in the earthquake
        //http://www.jclahr.com/alaska/aeic/magnitude/energy_calc.html
        $magnitude = $earthquake['properties']['mag'];
        $energy = pow(10,4.8);
        $joules =pow(10,1.5*$magnitude)*$energy;
        $joules = $joules/4184000000;
        $totalEnergyRelease += $joules;

        //get data for magnitude display
        $counter++;
        $magAvg += $earthquake['properties']['mag'];
        if($earthquake['properties']['mag'] > $highMag) $highMag = $earthquake['properties']['mag'];
        if($earthquake['properties']['mag'] < $lowMag) $lowMag = $earthquake['properties']['mag'];
        //get data for the line graph
        $formatTime = $earthquake['properties']['time']/1000;
        if($data['filter']['startDate'] == '24 hours'){
            $earthquakeTime = date('F j, Y, g:00 a',$formatTime);
        }else{
            $earthquakeTime = date('F j, Y',$formatTime);
        }
        array_push($earthquakeTimeArray,$earthquakeTime);
    }
    //get the average magnitude
    $magAvg = $magAvg/$counter;
    // this will give us a count of the earthquakes
    $earthquakeTimeCount = array_count_values($earthquakeTimeArray);
    // change order so you read timeline left to right
    $earthquakeTimeCount = array_reverse($earthquakeTimeCount);

    //get the energy released number to display
    if($totalEnergyRelease > 1000){
        $totalEnergyRelease = $totalEnergyRelease/1000;
    }

    //set display for energy released
    $atomBombs = $totalEnergyRelease/15;//http://www.warbirdforum.com/hiroshim.htm
    $totalEnergyRelease = number_format($totalEnergyRelease, 4);
    $energyReleased = 'The total combined energy released in all the earthquakes in the timeframe equals '.$totalEnergyRelease.' kilotons of TNT explosives which is the equivalent of '.number_format($atomBombs, 2).' Hiroshima atomic bombs being detonated at the same time.';

}else{
    $earthquakeTimeCount = array();
}




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
            }else{
                if($data['filter']['startDate'] == '24 hours'){?>
                    <h3><?php echo $data['data']['metadata']['count']; ?> total earthquakes in the past 24 hours.</h3>
                <?php }else{ ?>
                    <h3><?php echo $data['data']['metadata']['count']; ?> total earthquakes between <?php echo $data['filter']['startDate']; ?> and <?php echo $data['filter']['endDate']; ?>.</h3>
                <?php } ?>


                <h4>Lowest magnitude: <?php echo $lowMag; ?></h4>
                <h4>Highest magnitude: <?php echo $highMag; ?></h4>
                <h4>Average magnitude: <?php echo round($magAvg,2); ?></h4>
                <p><?php echo $energyReleased;?></p>
                <div style="width:100%;">
                    <canvas id="canvas"></canvas>
                </div>
    
            
            <?php }?>
            
            
            
            
            
        </div>
    </div>
</div>






<?php require_once('assets/page_elements/footer.php');?>

<script>
    $(document).ready(function(){
        $('.input-daterange input').each(function() {
            $(this).datepicker();
        });
    })
   
    var config = {
        type: 'line',
        data: {
            labels: [<?php foreach($earthquakeTimeCount as $key => $value)echo '"'.$key.'",';?>],
            datasets: [{
                label: "Earthquakes Totals",
                data: [<?php foreach($earthquakeTimeCount as $count)echo $count.',';?>],
                fill: true,
            }]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'label',
            },
            hover: {
                mode: 'dataset'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Timeframe'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of Earthquakes'
                    },
                    
                }]
            }
        }
    };

    

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx, config);
    };


</script>

