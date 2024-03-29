<?php
include('db.php');
include('display_functions.php');
include('fx_device.php');

session_check();

$name=name_check();

$max=endtime();
$_SESSION['sleeper']=$_SERVER['PHP_SELF'];
wake($name, $max, "departures.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Departures <?php //refresh("","d"); ?></title>
<meta http-equiv="refresh" content="300">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link href="src/boilerplate.css" rel="stylesheet" type="text/css">
<link href="src/style.css" rel="stylesheet" type="text/css">
<link href="src/parse.css" rel="stylesheet" type="text/css">
 <script src="src/jquery-1.10.2.js"></script>
  <script src="src/jquery-ui.js"></script>
  <script src="src/respond.min.js"></script>
  <script type="text/javascript">// <![CDATA[
$(document).ready(function() {
$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
setInterval(function() {
$('#display').load( "departures.php #display" );

}, 120000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
});
// ]]></script>
  
<script>
$(document).ready(function() {
//$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
setInterval(function() {
	
	
	
	
 $.ajax({
            type: 'GET',
            url: 'updater.php',
           // data: 'adi=d',
		    data: { display: "display", adi: "d" },
            dataType: 'json',
            cache: false,
            success: function(result) {
				var id=result['id'];
				
				$.each( result, function( key, value ) {
					//$( "#"+id+" "+"."+key ).replaceWith( "<td class='"+key+"'><span class='new'>"+value+"</span></td>" );
					$( "#"+id+" "+"."+key ).replaceWith( "<td class='"+key+"'><span class='new'>"+value+"</span></td>" );
				
});
				
           
			
           },
        });
}, 3000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
 
});
</script>


</head>

<body>
<div class="gridContainer clearfix">
<div id="LayoutDiv1">
<header>
  <img src="img/departures.gif" /><img src="img/flytucson.png" id="logo" />
  </header>
  
  <div class="clears"></div>
  <div id='departures'>
 <div id="display">

<?php





display('d');
//arrivals();
?>
</div>
</div>

<?php
datetime();
?>

</div>
</div>
</div>

</body>
</html>