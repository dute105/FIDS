<?php
include('fx_device.php');
include('db.php');
//session_start(); session_destroy();
function br()
{echo"<br>";}

session_check();







echo "hello<br />";
echo $_SESSION['name'];
br();
echo $_SESSION['display'];
br();
echo $_SESSION['param'];
br();
echo"param?";
//screens();

?>
