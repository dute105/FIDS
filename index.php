<?php
include('fx_device.php');
include('db.php');
//session_start(); session_destroy();
function br()
{echo"<br>";}

session_check();







$name=name_check();


assign_device($name);

//screens();

?>
