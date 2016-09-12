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
$pageFilters = 'assets/page_elements/data_filter.php'
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
            <div style="width:100%;">
                <canvas id="canvas"></canvas>
            </div>
    
    
            
            
            
            
            
            
        </div>
    </div>
</div>

<?php 
if(!$data['data']['error']){
    //get all the earthquake times 
    $earthquakeTimeArray = array();
    foreach($data['data']['features'] as $earthquake){
        $formatTime = $earthquake['properties']['time']/1000;

        if($data['filter']['startDate'] == '24 hours'){
            $earthquakeTime = date('F j, Y, g:00 a',$formatTime);
        }else{
            $earthquakeTime = date('F j, Y',$formatTime);
        }
        array_push($earthquakeTimeArray,$earthquakeTime);
    }
    // this will give us a count of the earthquakes
    $earthquakeTimeCount = array_count_values($earthquakeTimeArray);
    // change order so you read timeline left to right
    $earthquakeTimeCount = array_reverse($earthquakeTimeCount);
}else{
    $earthquakeTimeCount = array();
}
?>




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
                fill: false,
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

