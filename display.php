<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="src/boilerplate.css" rel="stylesheet" type="text/css">
<link href="src/style.css" rel="stylesheet" type="text/css">
<link href="src/parse.css" rel="stylesheet" type="text/css">
</head>

<body>


<?php
include('display_functions.php');
echo date('g:i A');

?>

 <script>
$(document).ready(function() {
//$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
setInterval(function() {
	
	
	
	
 $.ajax({
            type: 'GET',
            url: 'updater.php',
            data: { display: "display", adi: "a" },
            dataType: 'json',
            cache: false,
            success: function(result) {
				var id=result['id'];
				
				$.each( result, function( key, value ) {
					//$( "#"+id+" "+"."+key ).replaceWith( "<td class='"+key+"'><span class='new'>"+value+"</span></td>" );
					$( "#"+id+" "+"."+key ).replaceWith( "<td class='"+key+"'><span class='new'>"+value+"</span></td>" );
				
});
				
           
			
           },
        });
}, 3000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds. 
 
});
</script>

<?php





display('a');
//arrivals();
?>

</body>
</html>