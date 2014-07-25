<?php
include('db.php');
$adi=$_GET['adi'];
$display=$_GET['display'];


//
$result = mysql_query("SELECT * from updated  where  adi='$adi' order by actual_time limit 1");

	if(mysql_num_rows($result)==0)
		{
			$bltime=date('g:i A');
			
			echo json_encode( array("id"=>"date_time_bar", "time"=>"$bltime") );

			
		}
	
	while($row = mysql_fetch_array($result))
	
	  {
		  $FID=$row['fid'];
		   $pattern=array('/:/','/-/');
		  $replacement = '';
		  $FID=preg_replace($pattern, $replacement, $FID, -1 );
		    $status=$row['status'];
			  $actual_time=$row['actual_time'];
			   $scheduled_time=$row['scheduled_time'];
			  $city=$row['city'];
			   $scheduled_time=$row['scheduled_time'];
			   $id=$row['id'];
			   $actual_time=date("g:i A", strtotime("$actual_time"));
			$scheduled_time=date("g:i A", strtotime("$scheduled_time"));
			$claim=$row['claim'];
			$gate=$row['gate'];
		 
		 
		  $start_date = new DateTime($scheduled_time);
			$since_start = $start_date->diff(new DateTime($actual_time));

			$dif= $since_start->i;
			if($dif>4)
			{$time="Now $actual_time";}
			else
			{$time="$scheduled_time";}
			if($adi=='a')
				{
					$etc="claim";
					$etc_v=$claim;
				}
			elseif($adi=='d')
				{
					$etc="gate";
					$etc_v=$gate;
				}
			
		  
	  

		echo json_encode( array("id"=>"$FID", "fid"=>"$FID", "status"=>"$status", "$etc"=>"$etc_v","actual_time"=>"$time" ) );
		mysql_query("Delete from updated where id='$id'");
		
	  }


?>