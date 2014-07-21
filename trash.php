<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>gate</title>
  
 
 <script src="src/jquery-1.10.2.js"></script>
  <script src="src/jquery-ui.js"></script>
  <script src="src/respond.min.js"></script>
  
  
<script>
$(document).ready(function(){
 
   
  // rotateflights();
    function rotateflights(){
       $(".a").fadeOut(2000);
	    $(".b").delay(2000).fadeIn(2000,rotateflights);
      
      
    }
  });
 $(document).ready(function () {
function codeshare(){
		  $('#codeshare').fadeIn(800).delay(800).fadeOut(800);
        $('.cs1').fadeIn(800).delay(800).fadeOut(800);
        $('.cs2').delay(1600).fadeIn(800).delay(800).fadeOut(800, codeshare);
                                                                 //^callback function
}   
codeshare();
}); 

</script>
  
  
  
<style type="text/css">
.b {
	color: #060;
	display:none;
}
</style>
</head>

<body>

<?php
include('functions.php');
mysql_query("DELETE from temp");

function ts(){
	echo date('H:i:s');
	br();
}
ts();
comnet();





?>
</body>
</html>