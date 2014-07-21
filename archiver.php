<?php
include('db.php');
$today=date('Y-m-d');


$result = mysql_query("SELECT * from current where date < '$today'");
	if(mysql_num_rows($result)==0)
		{
			echo"crap<br />";
			
		}
	
	while($row = mysql_fetch_array($result))
	
	  {
		 
		 $FID=$row['fid'];
		  	$AC=$row['ac'];
			$FLIGHT=$row['flight_number'];
			$ADI=$row['adi'];
			$GATE=$row['gate'];
			$CLAIM=$row['claim'];
			$STIME=$row['scheduled_time'];
			$ATIME=$row['actual_time'];
			$STATUS=$row['status'];
			$IATA=$row['iata'];
			$CITY=$row['city'];
			$DATE=$row['date'];
		 
		 mysql_query("Insert into archive (fid, ac, flight_number, adi, gate, claim, scheduled_time, actual_time, status, iata, city, date)
			VALUES('$FID','$AC','$FLIGHT','$ADI','$GATE',$CLAIM, '$STIME','$ATIME','$STATUS','$IATA','$CITY','$DATE')");
	
			mysql_query("Delete from current where FID='$FID'");
	  }


?>