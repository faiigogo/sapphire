<html>
<head>
<title>Calendar</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../libary/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$jump = $_GET["jump"];
if($jump != ""){

	$df 			= explode("/", $jump);
	$today 		= $df[0];
	$dfMonth 	= $df[1];
	$dfYear 	= $df[2];
	
} 

include ("cost/function.php");

/* $diffHour และ $diffMinute คือตัวแปรที่ใช้เก็บจำนวนชั่วโมงและจำนวนนาทีที่ แตกต่างกันระหว่างเครื่องไคลเอนต์กับเครื่องเซิร์ฟเวอร์ ตามลำดับ เช่นถ้าเวลาของ
   เครื่องไคลเอ็นต์เร็วกว่าเวลาของเครื่องเซิร์ฟเวอร์ 11 ชั่วโมง 15 นาที ก็ให้กำหนด $diffHour เป็น 11 และกำหนด $diffMinute เป็น 15 ในที่นี้ผู้เขียนถือว่า
   เครื่องเซิร์ฟเวอร์กับเครื่องไคลเอ็นต์มีเวลาตรงกัน */
$diffHour 		= 0;
$diffMinute 	= 0;

if ($dfMonth == "") {

  $calTime = getdate(date(mktime(date("H") + $diffHour, date("i") + $diffMinute)));
  $today 	= $calTime["mday"];     //วันที่
  $month 	= $calTime["mon"];      //เดือน
  $year 		= $calTime["year"];      //ปี
  
} else {
  /* กรณีที่ระบุให้แสดงปฏิทินของเดือน/ปีหนึ่งๆนั้น จะมีการส่งตัวแปร $today,  $dfMonth และ $dfYear ผ่านมาทาง query string ด้วย */
  if ($dfMonth == 0) {
    /* ถ้าตัวแปร $dfMonth เป็น 0 เราจะแสดงปฏิทินของเดือนธันวาคมของปีที่น้อย กว่าปีที่กำลังแสดงอยู่ */
    $dfMonth 	= 12;
    $dfYear 	= $dfYear - 1;
  } elseif ($dfMonth == 13) {
    /* ถ้าตัวแปร $dfMonth เป็น 13 เราจะแสดงปฏิทินของเดือนมกราคมของปีที่มากกว่าปีที่กำลังแสดงอยู่ */
    $dfMonth 	= 1;
    $dfYear 	= $dfYear + 1;
  }
  //สร้างวัน/เวลาของเดือนและปีที่ผู้ใช้ระบุ เก็บไว้ในตัวแปร $calTime
  $calTime = getdate(date(mktime((date("H") + $diffHour), (date("i") + $diffMinute), 0, $dfMonth, $today, $dfYear)));
  $today 	= $calTime["mday"];     //วันที่
  $month 	= $calTime["mon"];      //เดือน
  $year 		= $calTime["year"];      //ปี
}

/* เรียกฟังก์ชั่น LastDay() ซึ่งเป็นฟังก์ชั่นที่เราสร้างขึ้นมาเอง เพื่อหา "จำนวนวัน" ของเดือนและปีที่จะแสดงปฏิทิน โดยเก็บไว้ในตัวแปร $Lday */
//เก็บ timestamp ของวันที่ 1 ของเดือนที่จะแสดงปฏิทิน ไว้ในตัวแปร $FTime
//เก็บ "วันในสัปดาห์" (จันทร์, อังคาร ฯลฯ) ของวันที่ 1 ของเดือนไว้ในตัวแปร $wday
$Lday 		= LastDay($month, $year);
$FTime 		= getdate(date(mktime(0, 0, 0, $month, 1, $year)));
$wday 		= $FTime["wday"];

//หาค่าของวันอาทิตย์เดือนก่อนหน้า
$lm			= explode("-", date("Y-m", mktime(0, 0, 0, $dfMonth, -1, $dfYear)));
$lmday		= (LastDay($lm[1], $lm[0]) - $wday);

//สร้างตัวแปรชนิดอาร์เรย์เก็บชื่อเดือนภาษาไทย
$thmonthname = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
$col				= array("#99CCFF", "#CCCCFF", "#FFCCFF", "#FFCC66", "#CCCC99", "#CCFF66","#66CC99","#CCCC33","#99FF66","#33CCCC");
$month_next	= date("m/Y", mktime(0, 0, 0, $month, +32, $year));
$month_prev	= date("m/Y", mktime(0, 0, 0, $month, -1, $year));
$jump_next	= $today."/".$month_next;
$jump_prev	= $today."/".$month_prev;

/*สร้างตัวแปรที่เอาไว้ตรวจสอบวันภายในเดือนที่แสดง ถ้ามีข้อมูลก็ให้ทำ link */

$sqDay			= add_zero($today); 
$sqMonth		= ($dfMonth != "") ? add_zero($dfMonth) : add_zero($month) ;
$sqYear			= ($dfYear != "") ? $dfYear : $year ;

/*Query ข้อมูลจาก Database*/
$result 	= mysql_query($csql)or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
$row 	= mysql_num_rows($result);
if($row != 0){
	while($rs 	= mysql_fetch_assoc($result)){
		$start	= explode("-", $rs[date_list]);
		$end	= explode("-", $rs[date_list]);

		$s1 = explode(" ", $start[2]);
		$e1	= explode("-", $end[2]);

		$s[]		= $s1[0];
		$e[]		= $e1[0];
	}
}

$xcol = array();
for($i=0;$i<count($s); $i++){
	for($x=$s[$i]; $x<=$e[$i]; $x++){		
		$arr_day[remove_zero($x)] 	= $i % count($col);  		
	}
	$xcol[] = $i % count($col); 
}
mysql_free_result($result);


$img_l 	= (file_exists("../images/left.gif")) ? "../images/left.gif" : "images/left.gif" ; 
$img_r 	= (file_exists("../images/right.gif")) ? "../images/right.gif" : "images/right.gif"; 
$img_c 	= (file_exists("../images/calendar.jpg")) ? "../images/calendar.jpg" : "images/calendar.jpg"; 
?>
<table width="176" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#404040">
<tr align="center" bgcolor="#A0A0A0">
    <td height="19" width="24"><a href="?jump=<?=$jump_prev.$cal_kwd?>&mode=<?=$mode?>&userid=<?=$_GET[userid]?>"><img src="<?=$img_l?>" width="12" height="12" border="0"></a></td>
	<td height="19" width="120" colspan="5" class="normal_blue">
	<?="<font class=brown>".$today."</font>&nbsp;".$thmonthname[$month - 1]."&nbsp;<font class=brown>".($year + 543)."</font>"?></td>
    <td height="19" width="24"><a href="?jump=<?=$jump_next.$cal_kwd?>&mode=<?=$mode?>&userid=<?=$_GET[userid]?>"><img src="<?=$img_r?>" width="12" height="12" border="0"></a></td>
</tr>
<tr align="center" bgcolor="#e3e3e3" class="normal_blue" style="font-weight:bold;">
	<td height="19" width="24" class="warn">อา</td>
	<td height="19" width="24">จ</td>
	<td height="19" width="24">อ</td>
	<td height="19" width="24">พ</td>
	<td height="19" width="24">พฤ</td>
	<td height="19" width="24">ศ</td>
	<td height="19" width="24">ส</td>
</tr>
<?
$iday = 1;
//แสดงแถวแรกของปฏิทิน
for ($i=0; $i<=6; $i++) {
if ($i < $wday) {  /*แสดงเซลล์ว่างก่อนวันที่ 1 ของเดือน*/
		//echo "<td width=\"24\" height=\"19\" bgcolor=\"#eeeeee\"><font color=\"#bbbbbb\">".($lmday=$lmday+1)."</font></td>\n";	
    if ($i == 0) { 	/*กรณีที่เป็นวันอาทิตย์*/	
		$class 	= "class=\"warn\""; 	
	} else { /*กรณีที่เป็นวันอื่นๆที่ไม่ใช่วันอาทิตย์*/ 
		$class 	= "class=\"normal\""; 
	}		
	echo "<td width=\"24\" height=\"19\" align=\"center\" $class bgcolor=\"#eeeeee\">&nbsp;</td>\n";
	
} else {             
	
//แสดงวันที่ในแถวแรกของปฏิทิน    
if(is_numeric($arr_day[$iday])) { 

//	$class 	= " bgcolor=\"".$col[$arr_day[$iday]]."\" style=\"font-weight:bold;\" "; 
//	$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd." class='link' style='text-decoration:none'>";
//	$show 	= $show."<font color=\"brown\">".$iday."</font></a> ";
	if($iday == $today){
		$class 	= " bgcolor=\"#0280D5\" style=\"font-weight:bold;\" "; 
		$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd."&id_type_cost=".$id_type_cost."&mode=".$_GET[mode]."&userid=".$_GET[userid]." class='link' >";
		$show 	= $show."<font color=\"white\">".$iday."</font></a> ";
	} else {
		$class 	= " bgcolor=\"#ffffff\" style=\"font-weight:bold;\" "; 
		$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd."&id_type_cost=".$id_type_cost."&mode=".$_GET[mode]."&userid=".$_GET[userid]." class='link' >";
		$show 	= $show."<font color=\"0280D5\">".$iday."</font></a> ";
	}	
	
	
} elseif($iday == $today) { 

	$class 	= " bgcolor=\"#0280D5\" style=\"font-weight:bold;\" "; 
	$show 	= "<font color=\"white\">".$iday."</font>";
	
} elseif($i == 0 && ($iday != $today)) { /*กรณีที่เป็นวันอาทิตย์ และไม่ใช่วันปัจจุบัน*/ 

	$class 	= " bgcolor=\"#ffffff\" style=\"font-color:red;\" "; 
	$show 	= "<font color=\"red\">".$iday."</font>";
	
} else { 
	
	$class 	= " bgcolor=\"#ffffff\" "; 
	$show 	= $iday ;
		
}	
	
    echo "<td width=\"24\" height=\"19\" align=\"center\" $class>".$show."</td>\n";
    $iday++;
	
}  
}
$link = "";

//แสดงแถวที่เหลือของปฏิทิน (หลังจากแสดงแถวแรกไปแล้ว จะเหลืออย่างมาก 5 แถว)
for ($j=0; $j<=4; $j++) {
  if ($iday <= $Lday) {
    echo "<tr>\n";
    for ($i=0; $i<=6; $i++) {
      if ($iday <= $Lday) {
	  
	    if(is_numeric($arr_day[$iday])) { 
		
//			$class 	= " bgcolor=\"".$col[$arr_day[$iday]]."\" style=\"font-weight:bold;\" "; 
//			$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd." class='link' style='text-decoration:none'>";
//			$show 	= $show."<font color=\"brown\">".$iday."</font></a> ";
	if($iday == $today){
		$class 	= " bgcolor=\"#0280D5\" style=\"font-weight:bold;\" "; 
		$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd."&id_type_cost=".$id_type_cost."&mode=".$_GET[mode]."&userid=".$_GET[userid]." class='link' >";
		$show 	= $show."<font color=\"white\">".$iday."</font></a> ";
	} else {
		$class 	= " bgcolor=\"#ffffff\" style=\"font-weight:bold;\" "; 
		$show 	= " <a href=?jump=".add_zero($iday)."/".$sqMonth."/".$sqYear.$cal_kwd."&id_type_cost=".$id_type_cost."&mode=".$_GET[mode]."&userid=".$_GET[userid]." class='link' >";
		$show 	= $show."<font color=\"0280D5\">".$iday."</font></a> ";
	}	
			
		} elseif($iday == $today) { 
		
			$class 	= " bgcolor=\"#0280D5\" style=\"font-weight:bold;\"";  
			$show 	= "<font color=\"ffffff\">".$iday."</font>";
			
		} elseif($i == 0 && ($iday != $today)) { 
		
			$class 	= " bgcolor=\"#ffffff\" style=\"font-color:red;\"  ";  
			$show 	= "<font color=\"red\">".$iday."</font>";
			
		} else {
		
			$class 	= " bgcolor=\"#ffffff\" ";   
			$show 	= $iday;
			
		}
		
        echo "<td width=\"24\" height=\"19\" align=\"center\" $class>".$show."</td>\n";
		 
      } else {
          echo "<td width=\"24\" height=\"19\" align=\"center\" class=\"normal\" bgcolor=\"#eeeeee\">&nbsp;</td>\n";
      }
	  
	  $iday++;
    }
    echo "</tr>\n";
  } else {
    break;
  }
}
?>
<tr bgcolor="#ffffff" align="center">
	<td height="25" colspan="7" class="normal_black">
	<div align="center" id="Add_event" style="height:20px; width: 150px; border: 1px solid black; background: #f8f8f8; padding: 1px 5px; cursor:hand;" 
	onClick="window.location.replace('<?=$PHP_SELF.$cdate_kwd?>')">
	<img src="<?=$img_c?>" width="16" height="16" align="absmiddle" border="0">&nbsp;วันที่ปัจจุบัน</div></td>
</tr>
</table>
</body>
</html>