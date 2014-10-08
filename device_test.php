<?php
include('display_functions.php');
include('db.php');
//session_start(); session_destroy();
function br()
{echo"<br>";}

session_check();






$gate="A8";
$now=date('Y-m-d H:i', strtotime("-5 minute"));
	$later=date('Y-m-d H:i:s',strtotime("+2 hours"));
	$rows=2;
	$result = mysql_query("SELECT * from current where adi='d' and actual_time between '$now' and '$later' and gate='$gate' and cs=0 group by flight_number order by actual_time limit $rows");
	$d=1;
	$i=mysql_num_rows($result);
	echo $i;
		if(mysql_num_rows($result)==0)
			{
				
				echo"<div id='noflight'><img src='http://localhost/fids2/img/LG_Tucson_International_Airport_logo.png' /></div>";	
			}
			
	
		while($row = mysql_fetch_array($result))
		
		  {
			  echo"<hr/>";
			$ac1=$row['ac'];
			$ac2=$row['ac2'];
			$flight=$row['flight_number'];
			$flight2=$row['flight_number_2'];
			if($i==2)
				{
						if(!empty($ac2)&&$ac2!="NA")
						  {				  
							 $airline="$ac1 | $ac2";
							 $flight="$flight | $flight2";						
						  }
						else
							{
								list($airline, $logo)=ac($ac1);
								
							}
				}
			else
				{
						
					list($airline, $logo)=ac($ac1);
					$airline1=$airline;
					
					if(!empty($ac2))
					  {
						  if($ac2!="NA")
							{
							  list($airline, $logo)=ac($ac2);
							  $airline2=$airline;
							  $airline="<div class='".$d."ac1'>$airline1</div><div class='".$d."ac2'>$airline2</div>";
							  $flight="<div class='".$d."f1'>$flight</div><div class='".$d."f2'>$flight2</div>";
							}
						  
					  }
					 else
						{
							$airline=$airline1;
						}
				}
			
			$iata=$row['iata'];
			$city=city_display($iata);
		
			if(!empty($flight2))
			  {
				
				  
				  
			  }
			 
			$actual_time=$row['actual_time'];
			$scheduled_time=$row['scheduled_time'];	
			$status=$row['status'];
			$actual_time=date("g:i A", strtotime("$actual_time"));
			$str_at=strtotime($actual_time);
			$boarding=strtotime("-30 minute",$str_at);
			$rnow=strtotime('now');
			$scheduled_time=date("g:i A", strtotime("$scheduled_time"));
			 
			 
			  $start_date = new DateTime($scheduled_time);
				$since_start = $start_date->diff(new DateTime($actual_time));
	
				$dif= $since_start->i;
				if($dif>4)
					{
					if($status=="On Time")
						{
							
							$status="Now $actual_time";
						}
					elseif($status=="Delayed")
						{
							$status="<span class='Delayed'>Delayed: $actual_time</span>";	
						}
					
					}
				else
					{		
				
						$status="<span class='$status'>$status</span>";
					}
				if($rnow>$boarding)
				{
					$status="<span class='Boarding'>Boarding</span>";	
				}
			
			
			echo"<div class='gate-wrapper$i'>	
				<div class='ac left'>
				<div class='label'>AIRLINE</div>
				<div class='data'>$airline</div>
				</div>
				
				<div class='gate right'>
				<div class='label'>Gate</div>
				<div class='data'>$gate</div>
				</div>
				
				<div class='clears'></div>
				
				<div class='message$i'>
				<div class='innerlabel'>MESSAGE</div>
				<div class='data'></div>
				</div>
				
				<div class='details$i'>
				
				<div class='full_details'>
				<div class='innerlabel'>DESTINATION</div>
				<div class='innerdata'>$city</div>
				</div>
				
				<div class='clears'></div>
				
				<div class='half_details left'>
				<div class='innerlabel'>Flight</div>
				<div class='innerdata'>$flight</div>
				</div>
				
				<div class='half_details right'>
				<div class='innerlabel'>Flight Time</div>
				<div class='innerdata'>$scheduled_time</div>
				</div>
				
				<div class='clears'></div>
				
				<div class='full_details'>
				<div class='innerlabel'>STATUS</div>
				<div class='innerdata'>$status</div>
				</div>
				
				
				
				
				</div>
				
				</div>";
						
					$d++;
						  
						  }

?>
