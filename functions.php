<?php
include('db.php');
///
$time=date('Y-m-d H:i:s');
////

function br(){
	echo"<br />";
}
/////////////// GET LIST OF CURRENT TAA AIRLINES
function taa_ac(){
	$taa_ac="";
	$result = mysql_query("SELECT * FROM ac");
		while($row = mysql_fetch_array($result))
		
			  {if(empty($taa_ac))
					{$del='';}
				else
					{$del=',';}
				$taa_ac=$taa_ac.$del.$row['AC'];}
		return $taa_ac;


	
}
/////////////// GET CURRENT FLIGHT DATA $adi=arr for arrivals $adi=dep for departures
function get_status($adi, $time){
		
			list($status_array)=status();
		list($claim_array)=claim();
		//list($gate_array)=gates();
		
		if($time=='now'){		
			$dt=date("Y-m-d H:i:s");
			$date=date('Ymd');
			$hour=date('Hi');
			}
		else{
				$time = date_create($time);		
				$date=date_format($time, 'Ymd');
				$hour=date_format($time, 'Hi');			
				
			}
		$ac=taa_ac();
	
	
	if($adi=="arr"){
		$url="http://xml.flightview.com/fvTUS4hrscons/fvxml.exe?arrap=tus&arrdate=$date&arrhr=$hour";		
		
	}
	else{		
		$url="http://xml.flightview.com/fvTUS4hrscons/fvxml.exe?depap=tus&depdate=$date&dephr=$hour";		
	}
	
		/*echo $adi;
		br();
		echo $url;
		br();
		$url="data.xml";*/
		$xml = simplexml_load_file($url) 
		   
		or die("Error: Cannot create object");
	   
		foreach($xml->Flight as $Flight){
				$FlightId=$Flight['FlightId'];
				$FlightNumber=$Flight->FlightId->FlightNumber;
				
				if(isset($Flight->FlightId->CodeShare->CommercialAirline->AirlineId->AirlineCode))
				{
					$AirlineCode=$Flight->FlightId->CommercialAirline->AirlineId->AirlineCode;
					$AirlineCode2=$Flight->FlightId->CodeShare->CommercialAirline->AirlineId->AirlineCode;
					$FlightNumber2=$Flight->FlightId->CodeShare->FlightNumber;
					settype($AirlineCode2, "string");
					
					
					}
				else
				{
					$AirlineCode2="NA";
					$AirlineCode=$Flight->FlightId->CommercialAirline->AirlineId->AirlineCode;
					$FlightNumber2="0";
				
				}		
				$Status=$Flight->FlightStatus->children();
				$Status=$Status->getName();
				$Status=$status_array[$Status];
				$Depart_AC=$Flight->Departure->Airport->AirportId->AirportCode;
				$Departure_AirportName=$Flight->Departure->Airport->AirportName;
				$Departure_City=$Flight->Departure->Airport->AirportLocation->CityName;
				$Depart_Date=$Flight->Departure->DateTime->Date;
				$Depart_Time=$Flight->Departure->DateTime->Time; //come back to this
				$Depart_Gate=$Flight->Departure->Airport->Gate;
				$Arrival_AC=$Flight->Arrival->Airport->AirportId->AirportCode;
				$Arrival_AirportName=$Flight->Arrival->Airport->AirportName;
				$Arrival_City=$Flight->Arrival->Airport->AirportLocation->CityName;
				$Arrival_Date=$Flight->Arrival->DateTime->Date;
				$Arrival_Time=$Flight->Arrival->DateTime->Time; //come back to this
				$Arrival_Gate=$Flight->Arrival->Airport->Gate;
				$ADT = date_create("$Arrival_Date $Arrival_Time");		
				$ADT=date_format($ADT, 'Y-m-d H:i:s');
				$DDT = date_create("$Depart_Date $Depart_Time");		
				$DDT=date_format($DDT, 'Y-m-d H:i:s');
				settype($AirlineCode, "string");
				settype($FlightId, "string");
				
				if($adi=="arr"){
					$AD="A";
					$Gate=$Arrival_Gate;
					$ACTUAL=$ADT;					
					$IATA=$Depart_AC;
					
					
					
					
				}
				else{
					$AD="D";
					$Gate=$Depart_Gate;
					$ACTUAL=$DDT;
					$IATA=$Arrival_AC;
					
					
				}
				
				
				
				$City=city($IATA);
				if (strpos($ac,$AirlineCode) !== false) {
					if(strpos($ac,$AirlineCode2) !== false) {
								
								
					if($Gate=='')
						{
							
							$Gate=gates2($FlightNumber, $AirlineCode);
							///nullgates($FlightNumber, $AirlineCode);
						}
					else
					{
						 gate_maker($FlightNumber,$AirlineCode, $Gate);
					}
					$CLAIM=claims($FlightNumber, $AirlineCode);
					
					
						mysql_query("INSERT INTO temp (FID, AC, AC2,FLIGHT_NUMBER, FLIGHT_NUMBER_2,ADI,GATE, CLAIM, SCHEDULED_TIME, ACTUAL_TIME, STATUS, IATA, CITY, DATE )
						VALUES ('$FlightId', '$AirlineCode', '$AirlineCode2','$FlightNumber', '$FlightNumber2', '$AD', '$Gate','$CLAIM','$ACTUAL','$ACTUAL', '$Status', '$IATA','$City', '$Depart_Date' )");
						///
						
						
							
					}
				}
						
			
		}
	
}

//// 
function temp_to_current_move($FID, $AC, $AC2, $FLIGHT, $FLIGHT2, $CS, $ADI, $GATE, $CLAIM, $STIME, $ATIME, $STATUS, $IATA, $CITY, $DATE){
	//check to see if Flight is already in current, if not, inserts it.
	$result = mysql_query("SELECT * from current where ac='$AC' and flight_number='$FLIGHT' and adi='$ADI' and iata='$IATA' and date='$DATE'");
	if(mysql_num_rows($result)==0)
		{
		
			mysql_query("Insert into current (fid, ac, ac2,flight_number, flight_number_2, cs,adi, gate, claim, scheduled_time, actual_time, status, iata, city, date)
			VALUES('$FID','$AC','$AC2','$FLIGHT','$FLIGHT2','$CS','$ADI','$GATE',$CLAIM, '$STIME','$ATIME','$STATUS','$IATA','$CITY','$DATE')");
	
			mysql_query("Delete from temp where FID='$FID'");
	
			
		}
	else
	{
		del_from_temp($FID);
	}
	
 
	
}


function check_temp() {
	//spooling through temp
	$result = mysql_query("SELECT * from temp");
	if(mysql_num_rows($result)==0)
		{
			echo"nada<br />";
		}
	else

	while($row = mysql_fetch_array($result))
	
	  {
		  	$FID=$row['FID'];
		  	$AC=$row['AC'];
			$AC2=$row['AC2'];
			$FLIGHT=$row['FLIGHT_NUMBER'];
			$FLIGHT2=$row['FLIGHT_NUMBER_2'];
			$CS=$row['CS'];
			$ADI=$row['ADI'];
			$GATE=$row['GATE'];
			$CLAIM=$row['CLAIM'];
			$STIME=$row['SCHEDULED_TIME'];
			$ATIME=$row['ACTUAL_TIME'];
			$STATUS=$row['STATUS'];
			$IATA=$row['IATA'];
			$CITY=$row['CITY'];
			$DATE=$row['DATE'];
	temp_to_current_move($FID, $AC, $AC2, $FLIGHT, $FLIGHT2,$CS,$ADI, $GATE, $CLAIM, $STIME, $ATIME, $STATUS, $IATA, $CITY, $DATE);
  	
  }
}
////////////////////////////
function del_from_temp($FID){
	$result = mysql_query("SELECT * from unchanged_temp where fid='$FID'");
	if(mysql_num_rows($result)==0)
		{
			$nada=0;
		}
	else
	
	mysql_query("Delete from temp where FID='$FID'");
}
////////////////////////////
function update_from_temp(){
	
	$result = mysql_query("SELECT * from temp");
	
	
	while($row = mysql_fetch_array($result))
	
		{
			$FID=$row['FID'];
		  	$AC=$row['AC'];
			$AC2=$row['AC2'];
			$FLIGHT=$row['FLIGHT_NUMBER'];
			$ADI=$row['ADI'];
			$GATE=$row['GATE'];
			$CLAIM=$row['CLAIM'];
			$STIME=$row['SCHEDULED_TIME'];
			$ATIME=$row['ACTUAL_TIME'];
			$STATUS=$row['STATUS'];
			$IATA=$row['IATA'];
			$CITY=$row['CITY'];
			$DATE=$row['DATE'];
		 	//mysql_query("update current set actual_time='$ATIME',status='$STATUS' where fid='$FID'");
			mysql_query("update current set actual_time='$ATIME',status='$STATUS' where flight_number=$FLIGHT and adi='$ADI' and date='$DATE'");
		
			mysql_query("Insert into updated (fid, ac, ac2, flight_number, adi, gate, claim, scheduled_time, actual_time, status, iata, city, date)
			VALUES('$FID','$AC','$AC2','$FLIGHT','$ADI','$GATE',$CLAIM, '$STIME','$ATIME','$STATUS','$IATA','$CITY','$DATE')");
		
		 	mysql_query("DELETE from temp where fid='$FID'");
			
		 
		
		}
	
}
////////////////////////////
function status(){
	
	$result = mysql_query("SELECT * from status");
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $status_array[$row['raw']]=$row['status'];
		
		  }
		 		  
		  return array ($status_array);
		 
		  
}
function claim(){
	
	$result = mysql_query("SELECT * from ac");
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $claim_array[$row['AC']]=$row['CLAIM'];
		
		  }
		 		  
		  return array ($claim_array);
		 
		  
}
function max_time($adi, $rows){
	$now=date('Y-m-d H:i', strtotime("-15 minute"));
	$day=date('Y-m-d');
	$result = mysql_query("SELECT actual_time from current where adi='$adi' and date='$day' and actual_time > '$now' order by actual_time limit $rows");
	
	
	while($row = mysql_fetch_array($result))
	
	  { $at=$row['actual_time'];}
	 return $at;
	
	
}
function next_status(){
	$date=date('Y-m-d');
	$time=date('Y-m-d H:i:s');
	$tomorrow=date('Y-m-d H:i:s',strtotime("+1 day"));
	$day="$date 22:00:00";
	$i=0;
	
	while($time<$day){
	$result = mysql_query("SELECT * from temp where DATE='$date' order by ACTUAL_TIME desc limit 1");
	if(mysql_num_rows($result)==0)
		{
			
			get_status("arr", $time);
			get_status("dep", $time);
			get_status("arr", $tomorrow);
			get_status("dep", $tomorrow);
			comnet();
		}
	
	while($row = mysql_fetch_array($result))
	
	  {
		 
		 	$time=$row['ACTUAL_TIME'];
			echo"$time<br />";
			get_status("arr", $time);
			get_status("dep", $time);
		 
		 $i++;
		 if($i>2)
		 {$time="$day 22:00:00";}
		
		  }
	}
}
	
function gates(){
	$result = mysql_query("SELECT * from ac");
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $gate_array[$row['AC']]=$row['GATE'];
		
		  }
		 		  
		  return array ($gate_array);
	
}
function gates2($flight, $ac){
	$result = mysql_query("SELECT * from gates where FLIGHT_NUMBER='$flight'");
	if(mysql_num_rows($result)==0)
				{
					
						$result = mysql_query("SELECT * from ac where AC='$ac'");	
					
				}
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $gate=$row['GATE'];
		
		  }
		 		  
		  return $gate;
	
}

function comnet()
{
$now=date('Y-m-d H:i:s',strtotime("-1 hour"));

		list($status_array)=status();
		list($claim_array)=claim();
		list($gate_array)=gates();
		
$xml = simplexml_load_file("http://tucsonairport.net/fids/eclipsx.xml") 
       or die("Error: Cannot create object");
  
foreach($xml->row as $Flight){
	//fid ac flight_number, adi, gate, claim, scheduled_time, actual_time, status, iata, city, date
	$ac=$Flight->linecode;
	$scheduled_time=$Flight['schedule'];
	$scheduled_time=strtotime($scheduled_time);
	$actual_time=$Flight['actual'];
	$actual_time=strtotime($actual_time);
	$scheduled_date=date('Y-m-d', $scheduled_time);
	$scheduled_hm=date('Hi', $scheduled_time);
	$scheduled_time=date('Y-m-d H:i:s', $scheduled_time);
	$actual_time=date('Y-m-d H:i:s', $actual_time);
	$flight_number=$Flight->number;
	$adi=$Flight['adi'];
	$gate=$Flight->gate;
	$claim=$Flight->claim;
	
	$status=$Flight->status;
	settype($status, "string");
	$status=$status_array[$status];
	$iata=$Flight->city['code'];
	$city=$Flight->city;
	$city=strtoupper($city);
	$date=date('Y-m-d');
	$fid="Comnet:".$ac.$flight_number.":".$iata.":".$scheduled_date.":".$scheduled_hm;
	settype($ac, "string");
	settype($gate, "string");
	if($gate=='')
		{
			$gate=gates2($flight_number, $ac);
		}
	elseif($gate=="TBA")
		{
			$gate=gates2($flight_number, $ac);
		}
	if($claim=='')
		{
			$claim=claims($flight_number, $ac);
		}
		
		$city=city($iata);
				
	
	if($actual_time>=$now)
		{
	
			
			$result = mysql_query("SELECT * from temp where AC='$ac' and FLIGHT_NUMBER='$flight_number' and ADI='$adi' and IATA='$iata' and date='$date'");
			if(mysql_num_rows($result)==0)
				{
					mysql_query("INSERT INTO temp (FID, AC, AC2,FLIGHT_NUMBER, CS,ADI,GATE, CLAIM, SCHEDULED_TIME, ACTUAL_TIME, STATUS, IATA, CITY, DATE )
								VALUES ('$fid', '$ac', 'NA','$flight_number','0','$adi', '$gate','$claim','$scheduled_time','$actual_time', '$status', '$iata','$city', '$date' )");
								
					
				}
		
	
			while($row = mysql_fetch_array($result))
			
				{
					$id=$row['id'];
					mysql_query("update temp set GATE='$gate', CLAIM='$claim', SCHEDULED_TIME='$scheduled_time', STATUS='$status' where id='$id'");
				  
				}
			
		}
	
	
}
}
function city($iata)
{
$result = mysql_query("SELECT * FROM iata where iata='$iata'");
		while($row = mysql_fetch_array($result))
		{$iata= $row['city'];}
		return $iata;
	
}
function thin_codeshare($AC, $FLIGHT, $fid, $ADI, $IATA){
	
	$result = mysql_query("SELECT * from temp where FLIGHT_NUMBER_2='$FLIGHT' and AC2='$AC' and ADI='$ADI' and IATA='$IATA'");
	if(mysql_num_rows($result)==0)
		{
			// Do Something
		}
	else

	while($row = mysql_fetch_array($result))
	
	  {
		  $FID=$row['FID'];
		  mysql_query("update TEMP set CS=0 where FID='$FID'");
	  }
	
	
	
}
function cs()
{
	$result = mysql_query("SELECT FID, count(FID) as COUNT, CS from temp where ADI='D' group by AC, FLIGHT_NUMBER, DATE");
	if(mysql_num_rows($result)==0)
		{
			//echo"nada<br />";
		}
	else

	while($row = mysql_fetch_array($result))
	
	  {
		  $count=$row['COUNT'];
		  $fid=$row['FID'];
		  $cs=$row['CS'];
		  //echo "$i $count $fid $cs<br />";
		  if($count==1)
		  	{mysql_query("update temp set CS=0 where FID='$fid'");}
		 
		  
		  
		  }
		  check_codeshare();
}

function check_codeshare(){
$result = mysql_query("SELECT * from temp where FLIGHT_NUMBER_2='NA'");
	if(mysql_num_rows($result)==0)
		{
			// Do Something
		}
	else

	while($row = mysql_fetch_array($result))
	
		{
			$AC=$row['AC'];
			$ADI=$row['ADI'];
			$FLIGHT=$row['FLIGHT_NUMBER'];
			$fid=$row['FID'];
			$IATA=$row['IATA'];
			thin_codeshare($AC,$FLIGHT, $fid, $ADI, $IATA);
			
		}

}
function gate_maker($flight,$ac, $gate){
	
	$result = mysql_query("SELECT * from gates where AC='$ac' and FLIGHT_NUMBER='$flight' ");
	if(mysql_num_rows($result)==0)
		{
			
			mysql_query("Insert into gates (AC, FLIGHT_NUMBER, GATE)
			VALUES('$ac','$flight','$gate')");
		}
	else

	while($row = mysql_fetch_array($result))
	
	  {
		 
		 	mysql_query("update gates set GATE='$gate' where FLIGHT_NUMBER='$flight' and AC='$ac'");
		
		  
		  
	  }
	
	
	
}
function nullgates($flight,$ac)
	{
		mysql_query("Insert into nullgates (AC, FLIGHT_NUMBER)VALUES('$ac','$flight')");
	}
function claims($flight, $ac){
	$result = mysql_query("SELECT * from claims where FLIGHT_NUMBER='$flight'");
	if(mysql_num_rows($result)==0)
				{
					
						$result = mysql_query("SELECT * from ac where AC='$ac'");	
					
				}
	
	
	while($row = mysql_fetch_array($result))
	
	  {
		 $claims=$row['CLAIM'];
		
		  }
		 		  
		  return $claims;
	
}
?>