<div class="clear"></div>
<footer class="container-fluid">
    <p>&copy; Nate Branning, <?php echo date('Y');?>. This is a coding sample. All the code contained within this project is an example of my coding style.</p>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php echo $scripts;?>



<script>
    //set the footer to the bottom of the window. 
    $(window).load(function() {
        var height = $(window).height();
        height = height-70;
        if($('.main-content').height() < height){
            $('.main-content').css({'height':height});
        } else {                
            $('.main-content').css({'height': ''});
        }

    });
</script>
</body>
</html>