<?php
include('db.php');
include('fx_device.php');
session_check();
$name=name_check();
$sleep=$_SESSION['sleep'];
$start=starttime($sleep);
//$location=$_SESSION['sleeper'];
$location=$_GET['l'];
asleep($name, $start, $location);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="60">

<title>sleep <?php echo "$location $start"; ?></title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link href="src/boilerplate.css" rel="stylesheet" type="text/css">
<link href="src/style.css" rel="stylesheet" type="text/css">
<link href="src/sleep.css" rel="stylesheet" type="text/css">
 <script src="src/jquery-1.10.2.js"></script>
  <script src="src/jquery-ui.js"></script>
  <script src="src/respond.min.js"></script>
  <script type="text/javascript">// <![CDATA[
$(document).ready(function() {
$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
setInterval(function() {
$('#display').load( "sleep.php #display" );

}, 120000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
});
// ]]></script>
  



</head>

<body>
<div class="gridContainer clearfix">
<div id="LayoutDiv1">
<header>
 
  </header>
  

 <div id="display">
 <div id="sleep" >
   <img src="img/sleep_logo.png" /> </div>

</div>
</div>



</div>
</div>
</div>

</body>
</html>