<?php
include('db.php');

function endtime()
{
	$day=date('Y-m-d');
	$result=mysql_query("Select MAX(actual_time)as max from current where date='$day'");
	
	
	while($row = mysql_fetch_array($result))
	
	  { 
		  $max=$row['max'];
		  $max=strtotime($max);
			$max=strtotime("+1 hour", $max);
			$max=date("Y-m-d H:i:s",$max);
			
		  
		 return $max;
	  }
	
}



?>