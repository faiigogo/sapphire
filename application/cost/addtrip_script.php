<?php
set_time_limit(0);
include ("checklogin.php");

include ("config/phpconfig.php");

include ("cost/function.php");

		echo $str1 = "
			select trip.tripid,trip.tripname,trip.note  ,trip.trip_status
			from   trip LEFT JOIN list  ON  trip.tripid =  list.tripid  
			group by trip.tripid order by trip.tripid 
			";
			$result = mysql_query($str1);
		
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){		
		
			$i++;
			$no++;

				$trip = 0;
				$closed = $ended = $cleared = true;
				$maxdate = $mindate = "";
				$sqlcheck = "select * from list  where tripid='$rs[tripid]' ; ";
				$resultcheck = mysql_query($sqlcheck);
				$resultnum = mysql_num_rows($resultcheck);
				while ($rscheck=mysql_fetch_array($resultcheck,MYSQL_ASSOC)) {
					if ($rscheck["close"] != "y" && $rs["close"] != "y" )  $closed = false;
					if ($rscheck["endtrip"] != "y")  $ended = false;
					if ($rscheck["cleartrip"] != "y")  $cleared = false;
					$maxdate = $rscheck["date_list"] > $maxdate || $maxdate == "" ? $rscheck["date_list"] : $maxdate;
					$mindate  = $rscheck["date_list"] < $mindate || $mindate == ""  ? $rscheck["date_list"] : $mindate;
				}
				
				if ($resultnum == "0" && $rs["close"] != "y" ){
					//echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
					$status_trip = "1";
					$cleartrip_last = ""; $endtrip_last = "";  $closed_last = "";
				}else{
					if ($closed){
						//echo "<img src=\"images/promo_violet.png\" alt=\"สรุปค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					$status_trip = "4";
					$cleartrip_last = "y"; $endtrip_last = "y";  $closed_last = "y";
					}else if ($cleared){
						//echo "<img src=\"images/promo_green.png\" alt=\"ผ่านการตรวจรับเอกสารรอการอนุมัติ\" width=\"24\" height=\"24\">";
					$status_trip = "3";
					$cleartrip_last = "y"; $endtrip_last = "y";  $closed_last = "";
					}else if ($ended){
						//echo "<img src=\"images/promo_orange.png\" alt=\"บันทึกรายการค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					$status_trip = "2";
					$cleartrip_last = ""; $endtrip_last = "y";  $closed_last = "";
					}else{
						//echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
					$status_trip = "1";
					$cleartrip_last = ""; $endtrip_last = "";  $closed_last = "";
					}
				}

				$sql = "SELECT * FROM `trip_schedule` WHERE `schedule_id` = '$rs[tripid]' ";
				$result_schedule = mysql_query($strSQL);
				if(!@mysql_num_rows($result_schedule) && $rs[tripid] && $status_trip > 1){
					$sql = "INSERT INTO `trip_schedule` 
										(`schedule_id`,`trip_id`,`start_date`,`end_date`,`no_ref`,`comment`,`timestamp`) 
										VALUES 
										(NULL,'$rs[tripid]','$mindate','$maxdate','1','Runscript',NOW())
									  ";	
					$result_update  = mysql_query($sql);
				}

				$strSQL = " UPDATE `trip` SET `trip_status`='$status_trip' WHERE (`tripid`='$rs[tripid]')  ";
				$result_update = mysql_query($strSQL);
				
				$strSQL = " UPDATE `tripvalue` SET `close`='$closed_last' , `endtrip`='$endtrip_last' , `cleartrip`='$cleartrip_last' WHERE (`tripid`='$rs[tripid]')  ";
				$result_update = mysql_query($strSQL);
				
				echo "`trip '$rs[tripid] `='$status_trip' [ '$mindate','$maxdate' ] <br / >";
		}
	?>