<?php
include('db.php');
//include('display_functions.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Arrivals</title>
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
$('#display').load( "trash.php #display" );

}, 60000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
});
// ]]></script>


</head>

<body>
<div class="gridContainer clearfix">
<div id="LayoutDiv1">
<header>
  <img src="img/arrivals.gif" /><img src="img/flytucson.png" id="logo" />
  </header>
  
  <div class="clears"></div>
  <div id="display">
  <div id='arrivals'>
<?php include('display.php'); ?>

</div>
<?php
datetime();
?>
</div>
</div>
</div>

</body>
</html>