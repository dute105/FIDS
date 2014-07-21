<?php
include('db.php');

function arrivals(){
	$result = mysql_query("SELECT * from arrivals, ac where arrivals.ac=ac.AC order by city");
	if(mysql_num_rows($result)==0)
		{
			get_status("arr", $time);
			
		}
	echo"<table width='100%'>";
	echo"<tr>";
	echo"<th>Arriving From</th>";
	echo"<th></th>";
	echo"<th>Airline</th>";
	echo"<th>Flight</th>";
	echo"<th>Time</th>";
	echo"<th>Status</th>";
	echo"<th>Claim</th>";
	echo"</tr>";
	while($row = mysql_fetch_array($result))
	
	  {
		  $city=$row['city'];
		  $ac=$row['ac'];
		  $IMG=$row['IMG'];
		  $ac=$row['ac'];
		  $flight=$row['flight_number'];
		  $status=$row['status'];
		  $claim=$row['claim'];
		  $scheduled_time=$row['scheduled_time'];
		  echo"<tr>";
		  echo "<td>$city</td>";
		     ////// echo "<td><img src='img/$IMG' class='ac_logo' /></td>";
		
		    echo "<td></td>";
				    echo "<td>$ac</td>";
			 echo "<td>$flight</td>";
			  echo "<td>$status</td>";
			   echo "<td>$scheduled_time</td>";
			    echo "<td>$claim</td>";
		  echo"</tr>";
		  }	
	echo"</table>";
}




?>