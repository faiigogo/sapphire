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
	
	$sql_userm = " SELECT trip.tripid, 
								trip.tripname, 
								trip_schedule.start_date, 
								trip_schedule.end_date
							FROM trip INNER JOIN trip_schedule ON trip.tripid = trip_schedule.trip_id
							WHERE 
							trip.userid='".$_GET['userid']."'
							".$where_date."
							GROUP BY trip.tripid
							ORDER BY trip.tripid ASC
						";
?>
<select name="<?=$_GET['name_list']?>" id="<?=$_GET['name_list']?>">
      <option value="">เลือกทิป</option>
      <?php
	
	$query_userm  = mysql_query($sql_userm);
	while ($row_userm = mysql_fetch_assoc($query_userm)){	
			echo '<option value="'.$row_userm['tripid'].'">'.$row_userm['tripid'].":".$row_userm['tripname'].'</option>';
	}
    ?>
</select>
