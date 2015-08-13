<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

//$date_list = $getyear.'-'.$getmonth.'-'.$getday;
if ($action == "delete"){
	$xsql = mysql_query("select attach from `list` where runno = '$runno'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$xrs = mysql_fetch_assoc($xsql);
	if(file_exists($xrs[attach])){ unlink($xrs[attach]); }

	$sql = mysql_query("delete from list where runno = '$runno' ")or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
	$msg = "<b class='blue'>Complete</b><br>ลบข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=list.php'>" ;
	exit() ;
}elseif ($action =="endtrip")
{
	$sql = "update list set  endtrip = 'y' where tripid = '$tripid' ";
				@mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					header("Location: ?tripid=$tripid");
					exit;
				}
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
					header("Location: ?tripid=$tripid");
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

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<link href="cost.css" type="text/css" rel="stylesheet">

<style type="text/css">

<!--

body {  margin: 0px  0px; padding: 0px  0px}

a:link { color: #005CA2; text-decoration: none}

a:visited { color: #005CA2; text-decoration: none}

a:active { color: #0099FF; text-decoration: underline}

a:hover { color: #0099FF; text-decoration: underline}

-->

</style>

<!-- check การระบุค่า  -->

<SCRIPT LANGUAGE="JavaScript">

<!--
<? if($sendmail2staff==1){ ?>
window.open('http://202.69.143.75/master/application/epm/_sendmailbycost.php','_blank','addres=no,toolbar=no,width=600,height=150');
<? } ?>
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
<!--			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>
				  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
	
					<tr bgcolor="#CACACA">			
					  <td width="862" bgcolor="#888888">&nbsp;</td>			
					  <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
					</tr>
				  </table>-->
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top">
							  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
								  <td align="center"> <? include("header_cost.php"); // หัวโปรแกรม ?></td>
								</tr>
							  </table>				</td>
			  </tr>
			                      <tr>
			                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="80%" bgcolor="#D3D3D3" class="caption"><span class="style5">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</span></td>
                                        <td width="0" align="right" valign="middle" bgcolor="#D3D3D3" class="caption"><!--<input name="Button25"  title="กลับหน้าหลัก" type="button"  style="width: 90;height:28px;cursor:pointer;" class="bluebotton" value="กลับหน้าหลัก" onClick="location.href='addtrip.php';" >-->
                                        </font></td>
                                      </tr>
                                    </table></td>
		                        </tr>
		                        <tr>
				<td>
				<table width="98%" border="0" align="center" cellpadding="1" cellspacing="2">
										<tr>
										  <td>
										  
										  
										  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">                                            
                                            <tr>
                                              <td align="left" valign="top"><nobr><strong>รหัสการเดินทาง</strong></td>
                                              <td align="left" valign="top"><span class="style2">
                                                <?
							$sqls = "select * from trip where tripid = '$tripid' ";
							$res = mysql_query($sqls);
							$rss = mysql_fetch_assoc($res);
							echo "$rss[tripid] ";
							?>
                                              </span></td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="top"><nobr><strong>กิจกรรม</strong></td>
                                              <td align="left" valign="top"><strong>
                                                <?=$rss[tripname]?>
                                              </strong></td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="top"><nobr><strong>ชื่อ-นามสกุล</strong></td>
                                              <td align="left" valign="top"><strong>
                                                <?
										  $tt = $rss[tripid];
										  ?>
                                                <?=GetTripOwner($rss[tripid])?>
                                              </strong></td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="top"><nobr><strong>ช่วงเวลาออกปฏิบัติงาน</strong></td>
                                              <td align="left" valign="top"><strong>
                                                <?
										  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '$tripid' ";
										  $resultd = mysql_query($sqld);
										  $rsd = mysql_fetch_assoc($resultd);
										  if (is_null($rsd[maxdate]))
										  {
										  echo "-";
										  }else{
												   echo daythai($rsd[mindate]);
												   echo "&nbsp; - &nbsp;";
												   echo daythai($rsd[maxdate]);		  			  
										  }
										  $str_date=strtotime($rsd[mindate]) - strtotime($rsd[maxdate]);
										  echo ($str_date)?" จำนวน ".str_replace( "-","",intval(($str_date)/(60*60*24)) )." วัน	" : "";
										  ?>
                                              </strong></td>
                                            </tr>
                                            <tr>
                                              <td width="5%" align="left" valign="top"><nobr><strong>โครงการ</strong></td>
                                              <td width="85%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <?
											$i=0;
											$no=0;
											If ($sortfield == "")
												{
													$str = " 
													select  
														sum(t1.cash_total+t1.credit_total) as total,
														t2.code_project,
														t2.name_project,											
														t1.id_type_project
													from 
														list t1 
														left join type_project t2 on t1.id_type_project = t2.id_type_project  
													where (t1.tripid = '$tripid')   
													group by  t1.id_type_project   
													order by date_list   ; ";
												}
												else
												{ 
													$str = " 
													select  
														sum(t1.cash_total+t1.credit_total) as total,
														t2.code_project,
														t2.name_project,											
														t1.id_type_project 
													from 
														list t1 
														left join type_project t2 on t1.id_type_project = t2.id_type_project  
													where (t1.tripid = '$tripid')    
													group by  t1.id_type_project    
													order by $sortfield  $sort ; ";
												}
											$result = mysql_query($str);
											while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
											?>
                                                  <tr>
                                                    <td width="80"><NOBR><strong> <a href="trip_project_detail.php?tripid=<?=$tripid?>&id_type_project=<?=$rs[id_type_project]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">
                                                      <?=$rs[code_project]?"$rs[code_project]":"&nbsp;"?>
                                                    </a></strong></td>
                                                    <td><strong>:
                                                      <?=number_format($rs[total])?>
                                                      บาท</strong></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?=$rs[name_project]?$rs[name_project]:" "?></td>
                                                  </tr>
                                                  <?
											}							  
										  ?>
                                              </table></td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="top"><nobr>											 
                                                <strong>รายละเอียดค่าใช้จ่าย </strong>
												</td>
                                              <td align="left" valign="top"><nobr>	<strong>ข้อมูล ณ วันที่
											  <?
													$str = " 
													SELECT
													max(t1.date_list) as last_date
													FROM
													list AS t1
													where (t1.tripid = '$tripid') AND id_type_cost='5'
													limit 1
													";
											$result_lastdate = mysql_query($str);
											$rs_lastdate=mysql_fetch_assoc($result_lastdate);
											echo ($rs_lastdate[last_date])?daythai($rs_lastdate[last_date])." (วันล่าสุดที่บันทึกเงินช่วยค่าครองชีพ)":daythai(date("Y-m-d"))." (ยังไม่เกิดรายการค่าใช้จ่าย)"?>
                                              </strong></td>
                                            </tr>
                                          </table></td>
										  <td width="50%">					  
										  
										  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="sample">
											  <tr>
												<td >
												<!--------------------------------------------------------->												
												
										  <table width="100%" border="0" cellpadding="0" cellspacing="2"  >
                                            <tr>
                                              <td width="36%">&nbsp;</td>
                                              <td align="center" class="style4">เงินสด (บาท)</td>
                                              <td align="center" class="style4">เครดิต (บาท)</td>
                                              <td align="center" class="style4">รวม (บาท)</td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											$sum_allintrip=$rs[total];
											?>
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่าใช้จ่ายรวมทั้งหมด</td>
                                              <td align="right" style="background-color:#FFFFFF"><strong>
                                                <?=number_format($rs[cash_total],2)?>
&nbsp;&nbsp;</strong></td>
                                              <td align="right" style="background-color:#FFFFFF"><strong>
                                                <?=number_format($rs[credit_total],2)?>
&nbsp;&nbsp;</strong></td>
                                              <td align="right" style="background-color:#FFFFFF"><strong>
                                                <?=number_format($rs[total],2)?>
&nbsp;&nbsp;</strong></td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '4')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่าใช้จ่ายโครงการ</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>											
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '5')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;เงินช่วยค่าครองชีพ (เบี้ยเลี้ยง)</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '2')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่าที่พัก</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '7')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่ารับรอง</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '1')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่าพาหนะเดินทาง</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>
											<?
											$sql_all="
											select  
												sum(t1.cash_total) as cash_total,
												sum(t1.credit_total) as credit_total,
												sum(t1.cash_total+t1.credit_total) as total,
												sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
												sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
												t2.type_cost,
												t1.id_type_cost  
											from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
											where (t1.tripid = '$tripid') AND (t2.id_type_cost = '9')
											GROUP BY t1.tripid 
											";
											$result = mysql_query($sql_all);
											$rs=mysql_fetch_assoc($result);
											?>											
                                            <tr>
                                              <td align="left" class="style4"><nobr>&nbsp;ค่าน้ำมันรถ</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[cash_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[credit_total],2)?>&nbsp;&nbsp;</td>
                                              <td align="right" style="background-color:#FFFFFF"><?=number_format($rs[total],2)?>&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                          </table>												
												
												
												
												<!--------------------------------------------------------->
												</td>
											  </tr>
											</table>

										  
										  </td>
										</tr>
									  </table>				</td>
			  </tr>
			  <tr>
				<td bgcolor="#D3D3D3"><br>
				<table width="96%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#666666">
										
					<tr bgcolor="#2A007C">
					  <td width="5%" rowspan="2" align="center" class="style4"><strong>ลำดับ</strong></td>
					  <td width="35%" rowspan="2" align="center" bgcolor="#2A007C" class="style4"><strong>หมวดรายการ</strong></td>
					  <td colspan="3" align="center" class="style4"><strong>จำนวนเงิน(บาท)</strong></td>
					  <td width="10%" rowspan="2" align="center" bgcolor="#2A007C" class="style4"><strong>ร้อยละ</strong></td>					  
					</tr>
					<tr bgcolor="#2A007C">
					  <td width="15%"  align="center" bgcolor="#2A007C" class="style4"><strong>เงินสด</strong></td>
					  <td width="15%"  align="center" bgcolor="#2A007C" class="style4" ><strong>เครดิต</strong></td>
					  <td width="15%"  align="center" bgcolor="#2A007C" class="style4" ><strong>รวม</strong></td>
					</tr>							
					<?
						$i=0;
						$no=0;
							If ($sortfield == "")
							{
								$str = " 
								select  
									sum(t1.cash_total) as cash_total,
									sum(t1.credit_total) as credit_total,
									sum(t1.cash_total+t1.credit_total) as total,
									sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
									sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,											
									t2.type_cost,
									t1.id_type_cost  
								from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  where (t1.tripid = '$tripid')    group by  t1.id_type_cost     order by date_list   ; ";
							}
							else
							{ 
								$str = " 
								select  
									sum(t1.cash_total) as cash_total,
									sum(t1.credit_total) as credit_total,
									sum(t1.cash_total+t1.credit_total) as total,
									sum( if(t1.cash_total>0,1,0) ) as Xnum_cash,
									sum( if(t1.credit_total>0,1,0) ) as Xnum_credit	,								
									t2.type_cost,
									t1.id_type_cost  
								from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  where (t1.tripid = '$tripid')   group by  t1.id_type_cost  order by $sortfield  $sort ; ";
							}
						$result = mysql_query($str);
						while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
							$i++;
							$no++;
							if ($i % 2) {$bg = "#EFEFEF";}else{	$bg = "#DDDDDD";	}
							$sum_cash_total+=$rs[cash_total];
							$sum_credit_total+=$rs[credit_total];
							$sum_total+=$rs[total];
					?>
					<tr bgcolor="<?=$bg?>">
					  <td align="center" bgcolor="<?=$bg?>"><?=$no?></td>
					  <td align="left" bgcolor="<?=$bg?>">&nbsp;<a href="listtypecost.php?tripid=<?=$tripid?>&id_type_cost=<?=$rs[id_type_cost]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><?=$rs[type_cost]?></a>&nbsp; &nbsp;&nbsp;</td>
					  <td align="right" bgcolor="<?=$bg?>"><!--<?=$rs[Xnum_cash]?$rs[Xnum_cash]."x":""?>--><?=number_format($rs[cash_total],2)?></td>
					  <td align="right" bgcolor="<?=$bg?>" ><!--<?=$rs[Xnum_credit]?$rs[Xnum_credit]."x":""?>--><?=number_format($rs[credit_total],2)?></td>
					  <td align="right" bgcolor="<?=$bg?>" ><?=number_format($rs[total],2)?></td>
					  <td align="right" bgcolor="<?=$bg?>" ><?=$sum_allintrip>0?number_format($rs[total]*100/$sum_allintrip,2)."%":""?></td>
					</tr>
					<?
					}
					?>
					<tr bgcolor="<?=$bg?>">
					  <td align="left" bgcolor="<?=$bg?>">&nbsp;</td>
					  <td align="center" bgcolor="<?=$bg?>"><strong>รวม</strong></td>
					  <td align="right" bgcolor="<?=$bg?>"><strong>
					  <?=number_format($sum_cash_total,2)?>
					  </strong></td>
					  <td align="right" bgcolor="<?=$bg?>" ><strong>
					  <?=number_format($sum_credit_total,2)?>
					  </strong></td>
					  <td align="right" bgcolor="<?=$bg?>" ><strong>
					  <?=number_format($sum_total,2)?>
					  </strong></td>
					  <td align="right" bgcolor="<?=$bg?>" ><strong>
					  <?=$sum_allintrip>0?number_format($sum_total*100/$sum_allintrip,2)."%":""?>
					  </strong></td>					  
					</tr>							
				</table>				
				</td>
			  </tr>
			  <tr>
				<td height="400" valign="top" bgcolor="#D3D3D3">
				<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
										  <td><strong>หมายเหต</strong>ุ การแสดงหมวดรายการจะแสดงเฉพาะหมวดรายการที่เกิดค่าใช้จ่ายที่เกิดขึ้นจริง </td>
										</tr>
										<tr style="height:40px">
										  <td>&nbsp;</td>
										</tr>

										<tr>
										  <td width="50%">.......................................................</td>
										</tr>
										
										<tr>
										  <td width="50%" height="25">(<strong>
											<?=GetTripOwner($tt)?>
										  </strong>)</td>
										</tr>
										<tr>
										  <td width="50%" height="25">วันที่ออกรายงาน
											<?=DBThaiLongDate(date("Y-m-d"));?></td>
										</tr>
					    </table>				</td>
			  </tr>
			</table>


						</td>
                      </tr>

                  </table></td>
                </tr>

              </table></td>
        </tr>
      </table>    </td>
  </tr>
</table>
</body>

</html>

