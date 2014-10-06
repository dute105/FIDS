<?php

function session_check()
	{
		if (session_status() == PHP_SESSION_NONE) 
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
	
?>