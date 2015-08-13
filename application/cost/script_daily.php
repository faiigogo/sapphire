<?php
set_time_limit(0);

$non_session = "ON";
$Report_Now = "ON";  // OFF = ส่งเมล์ได้  ON = เรียกดูรายงานเฉยๆ
$Fix_Hour = "ON";		  // OFF = ไม่สนใจเวลา  ON = สนใจเวลา
$Debug_Mode = "OFF";  // OFF = ปิดตอนแก้โปรแกรม  ON = เปิดตอนแก้โปรแกรม

$Mail_Online = "ON";
$TEL_Online = "ON";

$debug_Mail = "pudis@sapphire.co.th" ;
$debug_Tel = "0861860538" ;

#กำหนดเวลา
$crontab = "9" ;
$time_diff = 3 ; //เดือน

//include ("checklogin.php");
include ("config/phpconfig.php");
include ("alert_function.php");
include ("sms_function.php");


	if(!function_exists('getmicrotime')){
		function getmicrotime(){
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
		}
	}

	echo "".date("Y-M-d H:i:s")."  [Crantab Time : $crontab  ]<br>";



### อ่านทริปแดง

	$nowdate = date("Y-m-d");
	$strSQL=" 
		SELECT tripid , MIN(start_date) as start_date , MAX(end_date) as end_date
		FROM trip 
		Inner Join trip_schedule ON trip.tripid = trip_schedule.trip_id
		WHERE 
			`trip_status` LIKE '1'
		AND start_date != '0000-00-00'
		AND end_date  != '0000-00-00'
		/*AND end_date < '$nowdate'*/
		AND `updatetime` > DATE_SUB(NOW(),INTERVAL $time_diff MONTH)
		GROUP by trip.tripid
	";
	if( $debug == "ON" ){ echo "<pre>$strSQL</pre>"; }
	$Result = mysql_query($strSQL);
	
	
		while($Row_trip = mysql_fetch_assoc($Result)){
			//echo "<pre>";	print_r($Row_trip);	echo "</pre>";		
			$strSQL=" 
				SELECT trip_id , MIN(start_date) as start_date , MAX(end_date) as end_date
				FROM trip_schedule 
				WHERE 
					   start_date != '0000-00-00'
				AND end_date  != '0000-00-00'
				AND trip_id = '$Row_trip[tripid]'
				GROUP BY  trip_schedule.trip_id
			";
			//echo "<pre>$strSQL</pre>";
			$Result_schedule = mysql_query($strSQL);
			if(@mysql_num_rows($Result_schedule)>0){
				$mindate = $maxdate = "";
				while($Row_schedule = mysql_fetch_assoc($Result_schedule)){
					$mindate  = $Row_schedule[date_start] < $mindate ? $Row_schedule[date_start] : $mindate;
					$maxdate = $Row_schedule[end_date]  > $maxdate ? $Row_schedule[end_date]  : $maxdate;
				}
				
				
				### คำนวณทริปช้า
				if(trip_diffdate($maxdate,$nowdate)>0 && $maxdate<$nowdate){
					//echo $Row_trip[tripid]." :: ".$maxdate."-".$nowdate."=".trip_diffdate($maxdate,$nowdate)."<br>";
					$Array_MaxTrip[$Row_trip[tripid]] 	= $maxdate;		
					$Array_LateTrip[$Row_trip[tripid]] = trip_diffdate($maxdate,$nowdate);					
					$Array_AlertMail[$Row_trip[tripid]] = trip_diffdate($maxdate,$nowdate);
					
					if(trip_diffdate($maxdate,$nowdate)>2){
						$Array_AlertSMS[$Row_trip[tripid]] = trip_diffdate($maxdate,$nowdate);
					}
				}
			}
		}
		echo "<pre>"; echo " เตือนด้วย E-mail <br>"; print_r($Array_AlertMail); echo " เตือนด้วย  SMS<br>";print_r($Array_AlertSMS);  echo "</pre>";
		
		echo "<br><h3> รายการที่ส่ง MAIL แจ้ง </h3>";
		
		### ส่งเมล์	
		if(@count($Array_AlertMail)>0 && $Mail_Online != "OFF"){
			foreach( $Array_AlertMail as $key => $val ){				
				$Array_Nfo[$key]=call_owner_trip($key);
				//echo "<pre>"; print_r($Array_Nfo[$key]); echo "</pre>";				
				$user_name = $Array_Nfo[$key][name] . " ".$Array_Nfo[$key][surname] ;
				$user_shortname = $Array_Nfo[$key][name] ;
				$tripname = $Array_Nfo[$key][tripname];
				$UserEmail = "";
				$UserTel = "";
				
				if($Array_Nfo[$key][epm_id]>0){
					$strSQL = " select * from epm.epm_staff where staffid = '".$Array_Nfo[$key][epm_id]."' limit 1";	
					$Result_epm = mysql_query($strSQL);
					$Row_epm = mysql_fetch_assoc($Result_epm);
					$UserEmail = $Row_epm['email'];
				}
				
				###############################################
				echo $Array_Nfo[$key][epm_id].". ".$Array_Nfo[$key][name]." [".$UserEmail."] ปิดทริปช้า [".$key."] : ". $Array_LateTrip[$key] ." วัน<br>";
				if( $debug == "ON" ){ echo "<pre>";  echo "</pre>";}
				if($UserEmail){
					
					$strSQL = " SELECT max(no_alert) as no_alert FROM `alert_list` WHERE `trip_id` = '$key' AND alert_way = 'mail' group by trip_id ";
					$Result_no = mysql_query($strSQL);
					if(@mysql_num_rows($Result_no)>0){
						$arr_no = mysql_fetch_assoc($Result_no);
						$no = $arr_no['no_alert']+1 ;
					}else{
						$no = 1 ; 	
					}
					
					###############################################
					$msgtext	= "";
					$msgtext	.= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					$msgtext	.= "<tr><td> <strong>จดหมายอิเล็กทรอนิกส์ จากระบบบันทึกค่าใช้จ่ายออกพิ้นที่ [$key]</strong></td></tr>";
					$msgtext	.= "<tr><td> <strong>เรื่อง</strong> ติดตามให้ปิดการบันทึกค่าใช้จ่ายออกพิ้นที่ อ้างอิง ทริป $tripname ครั้งที่ $no</td></tr>  ";
					$msgtext	.= "<tr><td> <strong>เรียน</strong> คุณ ".trim($user_name)." </td></tr>    ";
					$msgtext	.= "<tr><td> &nbsp;</td></tr>    ";
					$msgtext	.= "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ระบบบันทึกค่าใช้จ่ายออกพิ้นที่ พบว่า ในวัน ".str_replace("&nbsp;"," ",trim(daythai($Array_MaxTrip[$key])))." ซึ่งเป็นวันสุดท้ายค่าใช้จ่ายออกพิ้นที่ตามที่คุณแจ้ง ไม่ได้ืำทำปิดทริปเพื่อเคลียร์ค่าใช้จ่าย โดยล่าช้ามาแล้ว ".$Array_LateTrip[$key]." วันทำการ<br />";
					$msgtext	.= "โดย สามารถเข้าระบบเพื่อบันทึกรายงานประจำวันได้ ที่ <br /><br /></td></tr>";

					$msgtext	.= "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><a href=\"http://202.129.35.106/sapphire/application/cost/login.php\" target=\"_blank\">http://202.129.35.106/sapphire/application/cost/login.php</a></strong><br /></td></tr>";
					
					$msgtext	.= "<tr><td> &nbsp;</td></tr>    ";
					$msgtext	.= "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ซึ่งหากคุณปิดทริปล่าช้ามากกว่า 2 วันทำการ อาจเสียซึ่งกำลังทรัพย์(ค่าsms) และอาจจะได้รับเงินเดือนล่าช้า(ตามนโยบาย)จึงเตือนมาเพื่อทราบ!<br />";
					$msgtext	.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากคุณอยู่นอกบริษัท หรือ ออกปฏิบัติงานนอกพื้นที่ สามารถ vpn เข้ามาในระบบได้ โดย user ที่ได้จาก ทีม NETWORK<br />";
					$msgtext	.= "<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากมีปัญหาในการใช้งาน ระบบบันทึกค่าใช้จ่ายออกพิ้นที่ ติดต่อ ได้ที่ คุณไพโรจน์ ทีม R&amp;D<br />";
					$msgtext	.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากมีปัญหาเกี่ยวกับกฏกติกาและมารยาทในการใช้ระบบบันทึกค่าใช้จ่ายออกพิ้นที่ ติดต่อ ได้ที่ <Strong>คุณกุลธิดา ฝ่ายบัญชี (089-7552229,082-6950392)</Strong><br />";
					$msgtext	.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากมีปัญหาในการ VPN ระบบบันทึกค่าใช้จ่ายออกพิ้นที่ ติดต่อ ได้ที่ คุณศิวะนันท์ ทีม NETWORK <br /><br /><br />";
					$msgtext	.= "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; BEST REGARD<br />";
					$msgtext	.= "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; SAPPHIRE R &amp; D </td>";
					$msgtext	.= "</tr>";
					$msgtext	.= "<tr><td>ลงวันที่ ".str_replace("&nbsp;"," ",trim(daythai(date("Y-m-d"))))."</td></tr>";						
					$msgtext	.= "<tr><td>&nbsp;</td></tr>";
					$msgtext	.= "</table>";
					$workname="แจ้ง : ".trim($user_shortname)."เพื่อเคลียร์ค่าใช้จ่ายออกพิ้นที่[".trim($key)."]ครั้งที่$no" ;
					$email_sys = "system@sapphire.co.th";
					
					//echo "<br/>$workname<hr/><pre>$msgtext</pre>";	//echo "-----".$UserEmail ."-----<br>";
					if( ($UserEmail && $Report_Now != "ON" ) ){ 
						if( (intval(date(H)) >= $crontab && intval(date(H)) < intval($crontab+1)) || $Fix_Hour == "OFF" ){
							$mail_sender[$UserEmail]="send";
							$UserEmail = $Debug_Mode != "ON" ? $UserEmail : $debug_Mail ;
							//echo $UserEmail ."-----<br>"; // ส่ง เมล์
							$result_mail = mail_daily_request($workname, $UserEmail , $email_sys ,$msgtext,$id);	
							echo "Mail Sending ..to $UserEmail <br>";
							$sending_number++;
							
							$strSQL= "
							INSERT INTO `alert_list` 
										(`trip_id`,`alert_way`,`status_alert`,`condition_alert`,`no_alert`) 
							VALUES ('$key','mail','$result_mail','".$Array_LateTrip[$key]."','$no') ";
							@mysql_query($strSQL);
						}
					}
					###############################################					
				}				
			}
		}	

		echo "<br><hr><br><h3> รายการที่ส่ง SMS แจ้ง</h3>";

		### ส่ง sms
		if(@count($Array_AlertSMS)>0  && $TEL_Online != "OFF"){
			foreach( $Array_AlertSMS as $key => $val ){				
				$Array_SMSNfo[$key]=call_owner_trip($key);
				//echo "<pre>"; print_r($Array_Nfo[$key]); echo "</pre>";				
				$user_name = $Array_SMSNfo[$key][name] . " ".$Array_SMSNfo[$key][surname] ;
				$user_shortname = $Array_Nfo[$key][name] ;
				$tripname = $Array_Nfo[$key][tripname];
				$UserEmail = "";
				$UserTel = "";

				if($Array_SMSNfo[$key][epm_id]>0){
					$strSQL = " select * from epm.epm_staff where staffid = '".$Array_SMSNfo[$key][epm_id]."' limit 1";	
					$Result_epm = mysql_query($strSQL);
					$Row_epm = mysql_fetch_assoc($Result_epm);
					$UserTel = trim(str_replace("-","",str_replace(" ","",$Row_epm['telno'])));
				}
				
				###############################################
				echo $Array_SMSNfo[$key][epm_id].". ".$Array_Nfo[$key][name]." [".$UserTel."] ปิดทริปช้ามาก [".$key."] : ". $Array_LateTrip[$key] ." วัน<br>";
				if($UserTel){
					$Arr_Msn = "";
					
					$strSQL = " SELECT max(no_alert) as no_alert FROM `alert_list` WHERE `trip_id` = '$key' AND alert_way = 'sms' group by trip_id ";
					$Result_no = mysql_query($strSQL);
					if(@mysql_num_rows($Result_no)>0){
						$arr_no = mysql_fetch_assoc($Result_no);
						$no = $arr_no['no_alert']+1 ;
					}else{
						$no = 1 ; 	
					}

					$Msg = " กรุณาดำเนินการปิดทริป".$key."โดยล่าช้า". $Array_LateTrip[$key] ."วันทำการแล้ว(เตือนครั้งที่".$no.")";	  // ข้อความที่ส่ง	
	
					$Arr_Msn[] = $Debug_Mode != "ON" ? $UserTel : $debug_Tel ;
					//$Arr_Msn[] = "0861860538";				// เบอร์พาก
					$Msn = implode(",",$Arr_Msn);		
					if( ($UserTel && $Report_Now != "ON" )){ 
						if( (intval(date(H)) >= $crontab && intval(date(H)) < intval($crontab+1)) || $Fix_Hour == "OFF" ){
							SendSMS2db($Msn,$Msg);
							echo "SMS Sending ..to $UserTel <br>";
									
							$strSQL= "
							INSERT INTO `alert_list` 
										(`trip_id`,`alert_way`,`status_alert`,`condition_alert`,`no_alert`) 
							VALUES ('$key','sms','$result_mail','".$Array_LateTrip[$key]."','$no') ";
							@mysql_query($strSQL);
							
						}
					}
				}
			}
		}
### ส่งเมล์แจ้ง ผู้บริหาร


### CornTab
$strSQL=" INSERT INTO `corntab_time` set `time` = NOW() ";
@mysql_query($strSQL);

?>