<?php

include ("checklogin.php");
include ("config/phpconfig.php");


if($action == "clear_value"){
$vnull = "";
	$strSQL = "UPDATE list SET close='$vnull', endtrip='$vnull' , cleartrip='$vnull'  WHERE tripid = '$tripid'";
	$Result = mysql_query($strSQL);
	
	$strSQL = "UPDATE tripvalue SET close='$vnull', endtrip='$vnull' , cleartrip='$vnull'  WHERE tripid = '$tripid'";
	$Result = mysql_query($strSQL);
	
	$sql = "UPDATE `trip` SET `trip_status`='1' WHERE (`tripid`='$tripid')   ";
	@mysql_query($sql);	
					
		if($Result){
		echo "
		<script language=\"javascript\">
		alert(\"ล้างข้อมูลเรียบร้อยแล้ว\");
		window.opener.location.reload();
		window.close();
		</script>
		";	

	}


}

