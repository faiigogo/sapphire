<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

//$date_list = $getyear.'-'.$getmonth.'-'.$getday;<br>

$year	=	$year_r-543 > 0 ? $year_r-543 : "";

$year = $year ? $year : intval(date("Y"));


if ($action == "delete"){
	$xsql = mysql_query("select attach from `list` where runno = '$runno'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$xrs = mysql_fetch_assoc($xsql);
	if(file_exists($xrs[attach])){ unlink($xrs[attach]); }

	$sql = mysql_query("delete from list where runno = '$runno' ")or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
	$msg = "<b class='blue'>Complete</b><br>ลบข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=list.php'>" ;
	exit() ;
}
if ($_SERVER[REQUEST_METHOD] == "POST"){
		 if ($_POST[action]=="edit2")
		 {
				$sql = "update list set  date_list =  '$date_list' , no_ap = '$no_ap' , detail = '$detail' , cash = '$cash' , credit = '$credit' , id_type_credit = '$id_type_credit' , complete = '$complete' , id_type_cost = '$id_type_cost' , project = '$project' ,  note ='$note' , date = 'now()'  where runno = '$runno' ";
				@mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					header("Location: ?");
					exit;
				}
			}
			else
			{
				$sql = "INSERT INTO  list  (date_list,no_ap,detail,cash,credit,id_type_credit,complete,id_type_cost,project,note,date) VALUES  ('$date_list','$no_ap','$detail' , '$cash' , '$credit' , '$id_type_credit' , '$complete' , '$id_type_cost' , '$project' , '$note' , now() )";
				echo $sql;
				$result  = mysql_query($sql);
				if($result)
				{
				header("Location: ?");
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="center">
			<span class="style2">	ระบบได้ทำการบันทึกข้อมูลของท่านแล้ว และจะทำการติดต่อกลับเพื่อยืนยันโดยเจ้าหน้าที่รับลงทะเบียน ตามหมายเลข &nbsp; <?=$off_tel;?> และอีเมลล์ &nbsp; <?=$off_mail?>  </span>
				</tr>
				<tr align="center" >
				<input name="" type="button" value = "   ปิด  "onClick=window.close();> &nbsp;&nbsp;
				<input name="" type="reset"  value = "กลับหน้าหลัก"  onClick="location.href='index.php';">
				<tr>
				</table>
				<?
					exit;
				}
				else
				{	
					echo "ไม่สามารถบันทึกข้อมูลได้ ";
				}
			}
	} 
	$sql = "select * from  register   where  id='$id' ;";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "ไม่พบข้อมูลที่ต้องการ";
	}
	
if(isset($_GET['sort'])){
	if($_GET['sort']=="asc"){
			$sort = "desc";
	}else{
			$sort = "asc";
	}
}else{
	$sort = "asc";
}

$getstr .= "sort=".$sort."&";
?>

<SCRIPT language=JavaScript 

src="bimg/swap.js"></SCRIPT>

<html>

<head>

<title>รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</title>

<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="cost.css" type="text/css" rel="stylesheet">

<style type="text/css">

<!--

body {  margin: 0px  0px; padding: 0px  0px}

a:link { color: #005CA2; text-decoration: none}

a:visited { color: #005CA2; text-decoration: none}

a:active { color: #0099FF; text-decoration: underline}

a:hover { color: #0099FF; text-decoration: underline}
.style2 {
	color: #000000;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}

-->

</style>

<!-- check การระบุค่า  -->

<SCRIPT LANGUAGE="JavaScript">

<!--

 



	function ch1(){
		var f1=document.form1;
//		if (f1.refresh.value == "1"){
//			return true; //no checking for refreshing
	//	}
		if (!f1.name_office.value){
		alert("กรุณาระบุชื่อสถานประกอบการ");
			return false;
		}
		if (!f1.com_no.value){
			alert("กรุณาระบุเลขทะเบียนการค้า");
			return false;
		}
		if (!f1.off_no.value){
			alert("กรุณาระบุเลขที่สถานที่ตั้งสำนักงาน");
			return false;
		}
		if (!f1.off_province.value) {
			alert("กรุณาระบุจังหวัดสถานที่ตั้งสำนักงาน");
			return false;
		}
		if  (!f1.off_tel.value) {
			alert("กรุณาระบุเบอร์โทรศัพท์ที่ตั้งสำนักงาน ");
			return false;
		}
		if (!f1.agg.checked  &&  !f1.travel.checked  && !f1.produce.checked  && !f1.other.checked ){
			alert("กรุณาระบุประเภทธุรกิจ ");
			return false;
		}
		if (!f1.officer.value){
			alert("กรุณาระบุจำนวนพนักงานประจำ");
			return false;
		}
		if (!f1.officer_total.value){
			alert("กรุณาระบุพนักงานรวมทั้งหมด");
			return false;
		}
		if (!f1.name.value){
			alert("กรุณาระบุผู้มีอำนาจตัดสินใจ ");
			return false;
		}
		if (!f1.surname.value){
			alert("กรุณาระบุข้อมูลผู้มีอำนาจตัดสินใจ ");
			return false;
		}
		if (!f1.position.value){
			alert("กรุณาระบุตำแหน่งผู้มีอำนาจตัดสินใจ ");
			return false;
		}
		if (!f1.tel.value){
			alert("กรุณาระบุเบอร์โทรศัพท์ผู้มีอำนาจตัดสินใจ ");
			return false;
		}
		if (!f1.it_yes.checked  &&  !f1.it_no.checked   ){
			alert("กรุณาระบุเจ้าหน้าที่รับผิดชอบด้านระบบเทคโนโลยีสารสนเทศ (ไอที) ");
			return false;
		}
	}

//-->

</SCRIPT>

<!-- send id to menu flash -->

<script language=javascript>
<!--

//window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");

//	window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");
	function checkid(){  //รวบรวมสร้าง id 
		f1 = document.form1;
		f1.id.value = f1.id1.value + f1.id2.value + f1.id3.value + f1.id4.value + f1.id5.value;
	}
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
	var keyCode = (isNN) ? e.which : e.keyCode; 
	var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
	if(input.value.length >= len && !containsElement(filter,keyCode)) {
		input.value = input.value.slice(0, len);
		input.form[(getIndex(input)+1) % input.form.length].focus();
	}

	function containsElement(arr, ele) {
	var found = false, index = 0;
		while(!found && index < arr.length)
			if(arr[index] == ele)
				found = true;
			else
				index++;
		return found;
	}

	function getIndex(input) {
		var index = -1, i = 0, found = false;
		while (i < input.form.length && index == -1)
			if (input.form[i] == input)
				index = i;
			else 
				i++;
			return index;
	}

	// add to id
	checkid();
	return true;
}

var isMain = true;
//-->
</script>
</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom "><?
/*

if ($msg){

		echo "<h1>$msg</h1>";

		exit;

}

*/

?>
      <!-- main Table  -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="right" valign="top"><? If ($mode !='2')
						  {
						  ?>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
                            <tr>
                              <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width=""></td>
                                  </tr>
                                </table>
                                  <span class="style4">รายงานสรุปการเดินทางไปปฏิบัติหน้าที่ยังต่างจังหวัด ประจำปี พ.ศ. <?=$year > 2300 ? $year : intval(date(Y)+543); ?></span></td>
                            </tr>
                           <!-- <tr bgcolor="#CACACA">
                              <td width="862" bgcolor="#888888">&nbsp;</td>
                              <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
                                <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้าหลัก" onClick="location.href='addtrip.php';" >
                                &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
                            </tr>-->
                          </table>
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
                            </tr>
                          </table>
                          <br>
                          <div align="center">
                          <div style="background-color:#000;width:80%">
                            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2">
                              <tr>
                                <td width="40%" rowspan="2" bgcolor="#A3B2CC" >&nbsp;</td>
                                <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวน</strong></td>
                              </tr>
                              <tr>
                                <td width="20%" align="center" bgcolor="#A3B2CC"><strong>โครงการ</strong></td>
                                <td width="20%" align="center" bgcolor="#A3B2CC"><strong>ครั้งการเดินทาง</strong></td>
                                <td width="20%" align="center" bgcolor="#A3B2CC"><strong>จำนวนเงิน (บาท)</strong></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF"><strong>โครงการลงนามในสัญญาแล้ว (Project)</strong></td>
                                <td align="center" bgcolor="#FFFFFF">
							    <?
								  $sq1 = " 
									SELECT
									type_project.id_type_project,
									type_project.name_project
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									WHERE
									type_project.no_project !=  '' AND
									list.date_list LIKE  '%$year%'
									GROUP BY
									type_project.id_type_project
								  ";
								  $result1 = mysql_query($sq1);
								  $rs1a = mysql_num_rows($result1);
								  echo number_format($rs1a);
							    ?>
                                </td>
                                <td align="center" bgcolor="#FFFFFF"><?
								  $sq1 = " 
									SELECT
									trip.tripid,
									trip.tripname,
									trip.userid,
									cos_user.username
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									Inner Join trip ON list.tripid = trip.tripid
									Inner Join cos_user ON trip.userid = cos_user.userid
									WHERE
									type_project.no_project !=  '' AND
									list.date_list LIKE '%$year%'
									GROUP BY
									trip.tripid
								  ";
								  $result1 = mysql_query($sq1);
								  $rs1b = mysql_num_rows($result1);
								  echo number_format($rs1b);
							    ?></td>
                                <td align="center" bgcolor="#FFFFFF">
								<?
								  $sq1 = " 
									SELECT									
									sum(list.cash_total) as cash_total,
									sum(list.credit_total) as credit_total
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									Inner Join trip ON list.tripid = trip.tripid
									Inner Join cos_user ON trip.userid = cos_user.userid
									WHERE
									type_project.no_project !=  ''
									AND list.date_list LIKE '%$year%'
								  ";
								  /*
									GROUP by 
									trip.tripid,
									trip.tripname,
									trip.userid,
									cos_user.username
								  */
								  //echo "<pre>$sq1</pre>";
								  $result1 = mysql_query($sq1);
								  $rs1c = mysql_fetch_assoc($result1);
								  $rs1cA = $rs1c[cash_total]+$rs1c[credit_total];
								  echo number_format($rs1c[cash_total]+$rs1c[credit_total],2);
							    ?>
                                </td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF"><strong>โครงการอยู่ระหว่างการขาย (Presale)</strong></td>
                                <td align="center" bgcolor="#FFFFFF"><?
								  $sq1 = " 
									SELECT
									type_project.id_type_project,
									type_project.name_project
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									WHERE
									type_project.no_project =  '' AND
									list.date_list LIKE  '%$year%'
									GROUP BY
									type_project.id_type_project
								  ";
								  $result1 = mysql_query($sq1);
								  $rs2a = mysql_num_rows($result1);
								  echo number_format($rs2a);
							    ?></td>
                                <td align="center" bgcolor="#FFFFFF"><?
								  $sq1 = " 
									SELECT
									trip.tripid,
									trip.tripname,
									trip.userid,
									cos_user.username
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									Inner Join trip ON list.tripid = trip.tripid
									Inner Join cos_user ON trip.userid = cos_user.userid
									WHERE
									type_project.no_project =  '' AND
									list.date_list LIKE '%$year%'
									GROUP BY
									trip.tripid
								  ";
								  $result1 = mysql_query($sq1);
								  $rs2b = mysql_num_rows($result1);
								  echo number_format($rs2b);
							    ?></td>
                                <td align="center" bgcolor="#FFFFFF"><?
								  $sq1 = " 
									SELECT									
									sum(list.cash_total) as cash_total,
									sum(list.credit_total) as credit_total
									FROM
									type_project
									Inner Join list ON list.id_type_project = type_project.id_type_project
									Inner Join trip ON list.tripid = trip.tripid
									Inner Join cos_user ON trip.userid = cos_user.userid
									WHERE
									type_project.no_project =  ''
									AND list.date_list LIKE '%$year%'
								  ";
								  /* GROUP by trip.tripid,trip.tripname,trip.userid,cos_user.username */
								  //echo "<pre>$sq1</pre>";
								  $result1 = mysql_query($sq1);
								  $rs2c = mysql_fetch_assoc($result1);
								  $rs2cA = $rs2c[cash_total]+$rs2c[credit_total];
								  echo number_format($rs2c[cash_total]+$rs2c[credit_total],2);
							    ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#A3B2CC"><strong>รวม</strong></td>
                                <td align="center" bgcolor="#A3B2CC"><?=number_format($rs1a+$rs2a)?></td>
                                <td align="center" bgcolor="#A3B2CC"><?=number_format($rs1b+$rs2b)?></td>
                                <td align="center" bgcolor="#A3B2CC"><?=number_format($rs1cA+$rs2cA,2)?></td>
                              </tr>
                            </table>
                          </div>
                          </div>
                          <div align="left"><table width="90%" border="0" align="center">
  <tr>
    <td align="left">
				<?
					// หาปี 					

						$previous_url = " <div align=right> &nbsp;     ";   

						$next_url = " <div align=left>&nbsp;   ";						

						$sql_yy = "  select min(substring(tripid,1,4)) as minYY,max(substring(tripid,1,4)) as maxYY  from trip  " ; 

						$query_result = mysql_query($sql_yy);

						$result_yy = mysql_fetch_assoc($query_result) ;	

						

						$maxYY1 = $result_yy[maxYY]  ;   $minYY1 = $result_yy[minYY]  ;

						if ($year_r == "" ) {	$year_r =  $maxYY1 ;   }											

						if ($maxYY1 > $year_r ){

								$next_year =$year_r + 1 ;  		$previous_year = $year_r  - 1 ; 		

								$next_url = "<a href='?showall=y&year_r=".$next_year."'><img src=\"images/next.png\" border=\"0\"></a> ";  

						}

						if ($minYY1 < $year_r ){

								$previous_year = $year_r - 1 ; 		$next_year =$year_r + 1 ; 			

								$previous_url = "<a href='?showall=y&year_r=" . $previous_year ."&view=$view'><img src=\"images/back.png\" border=\"0\"></a> ";  

						}
						?>
    			<table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;<?=$previous_url?></td>
                    <td><strong>พ.ศ.<?=$year_r?></strong></td>
                    <td><?=$next_url?>&nbsp;</td>
                  </tr>
                </table>
                
                </td>
    <td align="right"><strong>ข้อมูล ณ. วันที่
        <?=daythai(date("Y-m-d"))?>
    </strong></td>
  </tr>
</table>
</div>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            <tr>
                              <td colspan="8" align="left" bgcolor="#A3B2CC"><strong>ค่าใช้จ่ายจำแนกรายTRIP</strong></td>
                            </tr>
							
                            <tr bgcolor="<?=$bg?>">
                              <td align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                              <td align="center" bgcolor="#A3B2CC"><strong>วันที่</strong></td>
                              <td align="center" bgcolor="#A3B2CC"><strong>ชื่อโครงการ</strong></td>
                              <td align="center" bgcolor="#A3B2CC"><strong>รหัสโครงการ</strong></td>
                              <td align="center" bgcolor="#A3B2CC" ><strong>รหัสการเดินทาง</strong></td>
                              <td align="center" bgcolor="#A3B2CC" ><strong>วัตถุประสงค์</strong></td>
                              <td align="center" bgcolor="#A3B2CC" ><strong>จำนวนเงิน (บาท)</strong></td>
                              <td width="9%" align="center" bgcolor="#A3B2CC" ><strong>สถานะ</strong></td>
                            </tr>
   <?
	$i=0;
	$no=0;
	$str = "
			SELECT
			  list.runno,
			  list.`date`,
			  type_project.code_project,
			  list.id_type_project,
			  type_project.name_project,
			  Sum(list.cash_total+list.credit_total) AS total,
			  trip.tripid,
			  trip.tripname,
			  trip.note,
			  trip.userid,
			  trip.close,
			  cos_user.name,
			  cos_user.surname
			FROM
			type_project
			Inner Join list ON list.id_type_project = type_project.id_type_project
			Inner Join trip ON list.tripid = trip.tripid
			Inner Join cos_user ON trip.userid = cos_user.userid
			WHERE
			list.date_list LIKE '%$year%'
			GROUP BY
			trip.tripid
	";
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		//print_r($rs); echo "<br>";
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}	
		$total += $rs[total];	
?>
                            <tr bgcolor="<?=$bg?>">
                              <td width="4%" align="left" bgcolor="<?=$bg?>"><?=$no?></td>
                              <td width="9%" align="left" bgcolor="<?=$bg?>"><?=daythai($rs[date])?></td>
                              <td width="22%" align="left" bgcolor="<?=$bg?>"><?=$rs[name_project]?></td>
                              <td width="9%" align="left" bgcolor="<?=$bg?>"><?=$rs[code_project]?></td>
                              <td width="14%" align="left" bgcolor="<?=$bg?>" ><?=$rs[runno]?>
							  <?=trim($rs[name]." ".$rs[surname]) ? "<br>".trim($rs[name]." ".$rs[surname]) : ""?></td>
                              <td width="21%" align="left" bgcolor="<?=$bg?>" ><?=$rs[tripname]?></td>
                              <td width="12%" align="right" bgcolor="<?=$bg?>" ><?=number_format($rs[total],2)?></td>
                              <td align="center" bgcolor="<?=$bg?>" >
				<?
				$trip = 0;
				$closed = $ended = $cleared = true;
				$sqlcheck = "select * from list  where tripid='$rs[tripid]' ; ";
				$resultcheck = mysql_query($sqlcheck);
				$resultnum = mysql_num_rows($resultcheck);
				while ($rscheck=mysql_fetch_array($resultcheck,MYSQL_ASSOC)) {
					if ($rscheck["close"] != "y")  $closed = false;
					if ($rscheck["endtrip"] != "y")  $ended = false;
					if ($rscheck["cleartrip"] != "y")  $cleared = false;
				}
				
				if ($resultnum == "0"){
					echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
				}else{
					if ($closed){
						echo "<img src=\"images/promo_violet.png\" alt=\"สรุปค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					}else if ($cleared){
						echo "<img src=\"images/promo_green.png\" alt=\"ผ่านการตรวจรับเอกสารรอการอนุมัติ\" width=\"24\" height=\"24\">";
					}else if ($ended){
						echo "<img src=\"images/promo_orange.png\" alt=\"บันทึกรายการค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					}else{
						echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
					}
				}



				
				?></td>
                            </tr>
<?
}
?>
         <tr bgcolor="<?=$bg?>">
           <td align="left" bgcolor="#A3B2CC">&nbsp;</td>
           <td align="left" bgcolor="#A3B2CC">&nbsp;</td>
                              <td align="left" bgcolor="#A3B2CC">&nbsp;</td>
                              <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                              <td align="right" bgcolor="#A3B2CC" >&nbsp;</td>
                              <td align="right" bgcolor="#A3B2CC" ><strong>รวม</strong></td>
                              <td align="right" bgcolor="#A3B2CC" ><?=number_format($total,2)?></td>
                              <td bgcolor="#A3B2CC" >บาท</td>
                            </tr>
                          </table>
                          <br>
						  <?
						  }
						  ?>
                          <p>&nbsp;</p>
                          <p><br>
                        </p></td>

                      </tr>

                  </table></td>

                </tr>

              </table>

</td>

        </tr>

      </table>

    </td>

  </tr>

</table>

</body>

</html>

