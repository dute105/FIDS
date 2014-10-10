<?php

include('fx_device.php');

session_check();

$name=name_check();

$max=endtime();
$_SESSION['sleeper']=$_SERVER['PHP_SELF'];



wake($name, $max);


?>
