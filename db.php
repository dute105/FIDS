<?php
$host = "localhost"; //database location
$user = "Super"; //database username
$pass = "User"; //database password
$db_name = "fids2"; //database name
//database connection
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db_name);
//sets encoding to utf8

?>