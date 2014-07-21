<?php
include('db.php');
include('display_functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="<?php refresh("","d"); ?>">
<title>Departures <?php refresh("","d"); ?></title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link href="src/boilerplate.css" rel="stylesheet" type="text/css">
<link href="src/style.css" rel="stylesheet" type="text/css">
<link href="src/parse.css" rel="stylesheet" type="text/css">
 <script src="src/jquery-1.10.2.js"></script>
  <script src="src/jquery-ui.js"></script>
  <script src="src/respond.min.js"></script>
  
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
 

<?php





display('d');
//arrivals();
?>

</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php
$bldate=date('l F j Y');
$bltime=date('g:i A');
echo"<tr id='date_time_bar'>";
echo"<td class='date'>$bldate</td>";
echo "<td class='time'>$bltime</td>";
?>
</table>
</div>
</div>

</body>
</html>