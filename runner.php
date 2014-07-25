<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>runner</title>
<meta http-equiv="refresh" content="120">
</head>

<body>
<?php
include ('functions.php');
mysql_query("Delete from updated");
function ts(){
	echo date('H:i:s');
	br();
}
ts();

next_status();
comnet();
cs();
check_temp();
update_from_temp();		  
ts();		 





?>
<hr />
</body>
</html>