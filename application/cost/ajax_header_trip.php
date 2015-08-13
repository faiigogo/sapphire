<?php
	session_start();
    header("Content-Type: text/plain; charset=windows-874");
	include ("config/phpconfig.php");
	
	$begin_date = $_GET['begin_date']; 
	$end_date = $_GET['end_date'];
	$arr_begin_date = explode("/",$begin_date);
	$arr_end_date = explode("/",$end_date);
	$begin_date = ($arr_begin_date[2])."-".$arr_begin_date[1]."-".$arr_begin_date[0]; 
	$end_date = ($arr_end_date[2])."-".$arr_end_date[1]."-".$arr_end_date[0]; 
	$begin_datedown = strtotime("-15 day", strtotime($begin_date));
	$end_dateup = strtotime("+15 day", strtotime($end_date));

	if($begin_date!="" && $end_date!=""){
		$where_date = " AND trip_schedule.start_date BETWEEN '".date("Y-m-d",$begin_datedown)."' AND '".date("Y-m-d",$end_dateup)."' ";
	}else{
		$where_date = "";
	}
	
	$sql_userm = "SELECT cos_user.userid, 
							cos_user.name, 
							cos_user.surname,
							trip.tripid, 
							trip_schedule.start_date, 
							trip_schedule.end_date
							FROM cos_user 
							INNER JOIN trip ON cos_user.userid = trip.userid
							INNER JOIN trip_schedule ON trip.tripid = trip_schedule.trip_id
							WHERE password!='ออก'  
							".$where_date."
							AND trip.trip_status = '1'
							AND downline_status='1'
							GROUP BY cos_user.userid
							ORDER BY cos_user.name ASC
						";/*AND type_accrone.id_type_cost='5'
							AND cos_user.userid!='".$_SESSION['userid']."'*/
?>
<select name="downlineid" id="downlineid" onChange="user_trip('downline_trip','sl_downline_trip',this.value);">
      <option value="">เลือกลูกทีม</option>
      <?php
	
	$query_userm  = mysql_query($sql_userm);
	while ($row_userm = mysql_fetch_assoc($query_userm)){	
			echo '<option value="'.$row_userm['userid'].'">คุณ'.$row_userm['name']."  ".$row_userm['surname'].'</option>';
	}
    ?>
</select>
