<?php
include('db.php');
function max_time($adi, $rows){
	$now=date('Y-m-d H:i', strtotime("-15 minute"));
	$day=date('Y-m-d');
	$result = mysql_query("SELECT actual_time from current where adi='$adi' and date='$day' and actual_time > '$now' order by actual_time limit $rows");
	
	
	while($row = mysql_fetch_array($result))
	
	  { $at=$row['actual_time'];}
	 return $at;
	
	
}

function display($adi){
	$time="now";
	$rows=37;
	if($adi=='a')
		{
			$table="current";
			$get_status="arr";
			$from="Arriving From";
			$gate_claim="Claim";
			$gc_class="claim";
			
		}
	elseif($adi='d')
		{
			$table="current";
			$get_status="dep";
			$from="Departing To";
			$gate_claim="Gate";
			$gc_class="gate";
		}

	$at=max_time($adi,$rows);
	$now=date('Y-m-d H:i', strtotime("-15 minute"));
	
	$result = mysql_query("SELECT * from $table, ac where $table.ac=ac.AC and adi='$adi' and $table.actual_time between '$now' and '$at' order by city asc, ac.ac asc, scheduled_time asc limit $rows");
	if(mysql_num_rows($result)==0)
		{
			get_status($get_status, $time);
			
		}
		
	echo"<table width='100%'>";
	echo"<tr>";
	echo"<th>$from</th>";
	
	echo"<th>Airline</th>";
	echo"<th>Flight</th>";
	echo"<th>Time</th>";
	echo"<th>Status</th>";
	echo"<th>$gate_claim</th>";
	echo"</tr>";
	while($row = mysql_fetch_array($result))
	
	  {
		  $FID=$row['fid'];
		  $city=strtoupper($row['city']);
		  $ac=$row['ac'];
		   $ac2=$row['ac2'];
		  $IMG=$row['IMG'];
		  $ac=$row['ac'];
		  $flight=$row['flight_number'];
		  $status=$row['status'];
		 
		   $gate=$row['gate'];
		  $claim=$row['claim'];
		  $scheduled_time=$row['scheduled_time'];
		   $actual_time=$row['actual_time'];
		   $str_at=strtotime($actual_time);
		   $boarding=strtotime("-30 minute",$str_at);
		   $rnow=strtotime('now');
		  
		  $pattern=array('/:/','/-/');
		  $replacement = '';
		  $FID=preg_replace($pattern, $replacement, $FID, -1 );
		  
		  
		   
			$actual_time=date("g:i A", strtotime("$actual_time"));
			$scheduled_time=date("g:i A", strtotime("$scheduled_time"));
			
		 
		 
		  $start_date = new DateTime($scheduled_time);
			$since_start = $start_date->diff(new DateTime($actual_time));

			$dif= $since_start->i;
			if($dif>4)
				{
				if($status=="On Time")
					{
						
						$status="<span>Now $actual_time</span>";
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
				if($adi=='a')
		{
			$GC=$claim;
			$gc_class="claim";
			
		}
	elseif($adi='d')
		{
			$GC=$gate;
			$gc_class="gate";
			if($status!='Cancelled')
			{
				if($rnow>$boarding)
				{
					$status="<span class='Boarding'>Boarding</span>";	
				}
			}
		}
		  
		  
		  echo"<tr id='$FID'>";
		  echo "<td class='city'>$city</td>";
		    
		
		  
				    echo "<td class='ac'><img src='img/$IMG' class='ac_logo' /><span class='actext'>$ac</span></td>";
			 echo "<td class='flight'>$flight</td>";
			  echo "<td class='scheduled_time'>$scheduled_time</td>";
			 
			 
			   echo "<td class='status'>$status</td>";
			    echo "<td class='$gc_class'>$GC</td>";
		  echo"</tr>";
		  }	
	echo"</table>";
	
}





function refresh($display,$adi)
{
	if($display=='GATE')
	{
		$now=date('Y-m-d H:i', strtotime("-5 minute"));
		$i=1;
		$later=date('Y-m-d H:i:s',strtotime("+2 hours"));		
		$result = mysql_query("SELECT * from current where adi='d' and actual_time > '$now' and gate='$adi' order by actual_time limit 2");
		
		if(mysql_num_rows($result)==0)
			{
				
				$refresh=600;
			}
		
		while($row = mysql_fetch_array($result))
	
	  		{
				
				$actual_time=$row['actual_time'];
				$scheduled_time=$row['scheduled_time'];
				$now=date('Y-m-d H:i:s');
				  if($actual_time>$scheduled_time)
					{$bigger=$actual_time;}
				  else
					{
						$bigger=$scheduled_time;
						
					}
						
					
			
				$refresh=abs(strtotime($now)-strtotime($bigger));			
				
				if($i==1)
					{$r1=$refresh;}
				elseif($i==2)
					{
						$refresh=abs(strtotime($later)-strtotime($bigger));
						$r2=$refresh;
					}
				
				if(!empty($r2))
				{ 
					$refresh=min($r1,$r2);
				}
				
				
				
				$i++;
			}	
			if($refresh<600)
				{
						echo "$refresh"; 
				}
			else
				{
					echo"600";
				}
		
		
	}
	else{
	if($adi=='a')
		{	
			$table="arrivals";
		}
	elseif($adi=='d')
		{	
			$table="departs";
		}
$result = mysql_query("SELECT * from $table order by actual_time limit 1");
while($row = mysql_fetch_array($result))
	
	  {
		 
		 
		  $actual_time=$row['actual_time'];
		  $scheduled_time=$row['scheduled_time'];
		  $now=date('Y-m-d H:i:s');
		  if($actual_time>$scheduled_time)
		  	{$bigger=$actual_time;}
		  else
		  	{$bigger=$scheduled_time;}
			$refresh=abs(strtotime($now)-strtotime($bigger));
			if($refresh<600)
				{
						echo "$refresh"; 
				}
			else
				{
					echo"600";
				}
	
	  }
	}
}

function city_display($iata){
	
	
	$result = mysql_query("SELECT * from iata where iata='$iata'");
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $city=$row['city'];
		
		
		  }
		 		return $city;  
		 
		 
		  
}
function ac($ac){
	$result = mysql_query("SELECT * FROM ac where AC='$ac'");
		while($row = mysql_fetch_array($result))
		
		{
			$airline=$row['AIRLINE'];
			$logo=$row['IMG'];
			}
			return array($airline, $logo);
	
	
}
function gate_display($gate){
	
	$now=date('Y-m-d H:i', strtotime("-5 minute"));
	$later=date('Y-m-d H:i:s',strtotime("+2 hours"));
	$rows=2;
	$result = mysql_query("SELECT * from current where adi='d' and actual_time between '$now' and '$later' and gate='$gate' and cs=0 group by flight_number order by actual_time limit $rows");
	$d=1;
	$i=mysql_num_rows($result);
		if(mysql_num_rows($result)==0)
			{
				
				echo"<div id='noflight'><img src='http://localhost/fids2/img/LG_Tucson_International_Airport_logo.png' /></div>";	
			}
			
	
		while($row = mysql_fetch_array($result))
		
		  {
			  
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
	
}

?>