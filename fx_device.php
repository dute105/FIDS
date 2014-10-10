<?php
include('db.php');
function session_check()
	{
		
		if (session_id()=="") 
		//if (session_status() == PHP_SESSION_NONE) 
			{
				
				session_start();
			}
		else
			{
				
				name_check();
					
			}
	}
function name_check()
	{
		if(!isset($_SESSION['name']))
			{
					
					$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$hostname = strtoupper(str_replace(".tucsonairport.local","",$hostname));
					$_SESSION['name']=$hostname;
					$name=$_SESSION['name'];
					
					//position($name);
					
					
			}
		else
			{
				$name=$_SESSION['name'];
				
				
				
			}
			
		return $name;
		
	}
function assign_device($name)
	{
			$result = mysql_query("SELECT * from device where device='$name'");
				
			if(mysql_num_rows($result)==0)
				{
					//"Device is not registered<br>";
					
				}
		
		
			while($row = mysql_fetch_array($result))
				{
					//echo"Device is registered as $name<br>";
					$page=$row['display'];
					
					
					if($page=='GATE')
						{
							
							$param=$row['param'];
							$_SESSION['param']=$param;
							$param=$_SESSION['param'];
							$location="gate.php";
							header("Location: $location");	
						}
					if($page=='SPLIT')
						{
							screens();
						}
					if($page=='ARRIVALS')
						{
							$location="arrivals.php";
							header("Location: $location");	
						}
					if($page=='DEPARTURES')
						{
							$location="departures.php";
							header("Location: $location");	
						}	
							$_SESSION['display']=$page;
							
					
					
					
				}
	
		
		
	}
function screens()
{
if(isset($_SESSION['screen']))
	{
		
		
		$location="departures.php";	
		unset($_SESSION['screen']);
		
		//header('Location: '.$location);
		
	}
else
	{
		//echo"Session HAS not been set<br>";
		
		$_SESSION['screen']="ARRIVAL";
		$location="arrivals.php";	
		//header('Location: '.$location);
			
	}
	header('Location: '.$location);
	
}	

function wake($name, $time, $location)
	{
		
		$now=date('Y-m-d H:i:s');
		
		//$now="2014-10-11 03:00:00";
		if ($now>$time)
			{
				mysql_query("INSERT INTO sleep (name, state, date)VALUES ('$name', 'SLEEP', '$now')");
				$_SESSION['sleep']=$time;
				header("Location: sleep.php?l=".$location);
				
			}
		
		
		
		
		
		
	}
function asleep($name, $time, $location)
	{
		
		$now=date('Y-m-d H:i:s');
		//$now="2014-10-11 03:06:00";
		
		if ($now>$time)
			{
				mysql_query("INSERT INTO sleep (name, state, date)VALUES ('$name', 'WAKE', '$now')");
				$_SESSION['sleep']=$time;
				header("Location: $location");
				
			}
		
		
		
		
		
		
	}
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
function starttime($time)
	{
		$result=mysql_query("Select actual_time from current where actual_time>'$time' order by actual_time limit 1");
	
	
	while($row = mysql_fetch_array($result))
	
	  { 
		  $start=$row['actual_time'];
		  $start=strtotime($start);
			$start=strtotime("-2 hour", $start);
			$start=date("Y-m-d H:i:s",$start);
			
		  
		 return $start;
	  }
		
	}
	
?>