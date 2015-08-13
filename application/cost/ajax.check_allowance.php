<?php
	header("Content-Type: text/html; charset=TIS-620",true);
	session_start();
	//$non_session = "ON";
	include ("config/phpconfig.php");
	
//	include ("libary/function.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
	
	$condition = $runno ?  " AND list.runno <> '$runno' " : "" ;
	$arr_day  = explode("/", $getday);
	$getday2 = $arr_day[2]."-".$arr_day[1]."-".$arr_day[0];
	//$condition .= ($_GET['tripid']!="")?" AND list.tripid='".$_GET['tripid']."' ":"";

	$strSQL="
	SELECT * FROM `list`
	WHERE
	list.id_type_cost in ('5','31') 
	AND list.date_list =  '$getday2'
	AND list.userid =  '$userid'
	$condition
	";
	//echo "$strSQL";
	//list.tripid =  '$tripid' 
	$result=mysql_db_query($db_name,$strSQL);
	$xnum = @mysql_num_rows($result);
	
	if(@$xnum>0){
		$row=mysql_fetch_assoc($result);
		//print_r($row);		
		$title = " (".$row['date_list'].")".$row[detail];
		echo "false#".$title;
	}else{
		echo "true#";
	}
?>