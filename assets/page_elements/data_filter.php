<form action="data.php" method="post" class="form form-vertical ">
    <p>Select a date range.</p>
    
    <div class="input-group input-daterange">
        <input type="text" name="startDate" data-date-end-date="0d" class="form-control" value="<?php echo @$data['filter']['startDate']; ?>">
        <span class="input-group-addon">to</span>
        <input type="text" name="endDate" data-date-end-date="0d" class="form-control" value="<?php echo @$data['filter']['endDate']; ?>">
    </div>
    
    <div class="clear margin-top2"></div>
    <div class="col-md-12 text-right"><input type="submit" class="btn btn-primary" value="Submit"></div>
    
</form>


