<?php
include ('display_functions.php');
 session_check();

//$gate=strtoupper($_GET['id']);

$gate=$_SESSION['param'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="<?php refresh("GATE","$gate"); ?>">
<title>gate<?php echo " $gate "; refresh("GATE","$gate"); ?></title>
  
  <link href="src/gate.css" rel="stylesheet" type="text/css" />

 <script src="src/jquery-1.10.2.js"></script>
  <script src="src/jquery-ui.js"></script>
  <script src="src/respond.min.js"></script>
  <script>


 $(document).ready(function () {
function cs_ac1(){
		$('.1ac2').hide();
		 $('.1ac1').fadeIn(2000).delay(2000).fadeOut(2000).delay(2000).hide(500,cs_ac2);

		  
}   
function cs_ac2(){
		$('.1ac1').hide();
		 $('.1ac2').fadeIn(2000).delay(2000).fadeOut(2000).delay(2000).hide(500,cs_ac1);
}
function cs_flight1(){
		$('.1f2').hide();
		 $('.1f1').fadeIn(2000).delay(2000).fadeOut(2000).delay(2000).hide(500,cs_flight2);

		  
}   
function cs_flight2(){
		$('.1f1').hide();
		 $('.1f2').fadeIn(2000).delay(2000).fadeOut(2000).delay(2000).hide(500,cs_flight1);
}
// second set for 2 flights per screen


cs_ac1();
cs_flight1();

});


</script>
<script type="text/javascript">// <![CDATA[
$(document).ready(function() {
$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
setInterval(function() {
$('#display').load( "gate.php #display" );

}, 30000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
});
// ]]></script>
</head>

<body>
<div id="display">
<div id="template">
<?php
gate_display($gate);
?>







</div>

<?php
datetime();
?>

</div>
</body>
</html>