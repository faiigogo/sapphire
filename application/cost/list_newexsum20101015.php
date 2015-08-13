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
				$strsql = "select * from list  where tripid='$tripid' ";
				$result = mysql_query($strsql);				
				if(@mysql_num_rows($result)>0){
					$sql = "update list set  endtrip = 'y' where tripid = '$tripid' ";
					@mysql_query($sql);	
					trip_status($tripid);
				}else{
					trip_status($tripid);
					$sql = "UPDATE `trip` SET `trip_status`='4' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);	
				}

				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					//header("Location: ?tripid=$tripid");
					echo "<meta http-equiv='refresh' content='0;url=?tripid=$tripid'>" ;
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
.style2 {
	color: #000000;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}
.style9 {color: #000000}

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
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td width="">			  </td>
              </tr>

          </table>
            <span class="style4">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</span></td>
        </tr>

        <!--<tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้าหลัก" onClick="location.href='addtrip.php';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>-->
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">
                  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center"> <? include("header_cost.php"); // หัวโปรแกรม ?></td>
                    </tr>
                  </table>
				  <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#A3B2CC">
                            <tr>
                              <td width="30%" align="right"><span class="style2"><a href="listtrip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><span class="style9"><u>TripID</u></span></a></span></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF">                                <span class="style2">
                              <?
				$sqls = "select * from trip where tripid = '$tripid' ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo "$rss[tripid] ";
				?>
                              </span></td>
                              <td><strong>Trip Name :</strong> </td>
                              <td width="30%" bgcolor="#FFFFFF"><strong>
                                <?=$rss[tripname]?>
                              </strong></td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>Staff Name: </strong></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF"><strong>
							  <?
							  $tt = $rss[tripid];
							  ?>
							  <?=GetTripOwner($rss[tripid])?>
							  </strong></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>ช่วงเวลาออกพื้นที่ปฏิบัติงาน
							  </strong></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF">
							  	  <?
							  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '$tripid' ";
							  $resultd = mysql_query($sqld);
							  $rsd = mysql_fetch_assoc($resultd);
							  if (is_null($rsd[maxdate]))
							  {
							  echo "-";
							  }else
							  {
						       echo daythai($rsd[mindate]);
							   echo "&nbsp; - &nbsp;";
   						       echo daythai($rsd[maxdate]);		  			  
							   }  
							  ?>							  </td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><span class="style9"><strong>งบประมาณที่ได้รับอนุมัติ </strong></span></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><span class="style2">
                                <?
				$sqls = "select sum(if(id_type_tripapp=1 OR id_type_tripapp=4 OR id_type_tripapp=5,appbudget,0)) - sum(if(id_type_tripapp=3 OR id_type_tripapp=6,appbudget,0)) as app from tripvalue where (tripid = '$tripid') ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo number_format($rss[app],2);
				?>
                              </span></td>
                              <td bgcolor="#A3B2CC"><strong>บาท </strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>งบประมาณที่ใช้จริง - <a href="listcash.php?mode=total&tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">เงินสด</a> </strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><span class="style2">
<?
$sqls				= " select sum(cash_total) as cash_total,sum(credit_total) as credit_total  from list  where tripid = '$tripid'; ";
$res				= mysql_query($sqls);
$resc				= mysql_fetch_assoc($res);
$cash_total	= $resc[cash_total] + $resc[credit_total];
echo number_format($resc[cash_total],2);
?>
                              </span></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>- <a href="listcredit.php?mode=total&tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">เครดิต</a> </strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><strong>
                              <?=number_format($resc[credit_total],2);?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>รวม</strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><strong>
                              <?=number_format($cash_total,2);?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>คงเหลือ</strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><strong>
                                <?
							  $remain = $rss[app] - $resc[cash_total] ;
							  echo number_format($remain,2);
							  ?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                          </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="20%">&nbsp;</td>
                              <td width="30%">
							  <?
				If ($pri =='100')
				{
				?>					  
				<a href="trip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><img src="bimg/plus.gif" width="20" height="20" border="0"> &nbsp;ทำรายการขออนุมัติงบประมาณ</a>
				<?
				}else
				{
				?>
				<a href="viewbudget.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><img src="bimg/plus.gif" width="20" height="20" border="0"> &nbsp;ดูงบประมาณที่อนุมัติ</a>
				<?
				}
				?>							  </td>
                              <td width="30%">
							  <?
							  $scheckend = "select * from list where tripid = '$tripid' and endtrip = 'y' ";
							  $resultcheckend = mysql_query($scheckend);
							  $rscheckend = mysql_num_rows($resultcheckend);
							  If ($rscheckend !='0')
							  {
							  echo "ปิดการเดินทาง ไม่สามาถเพิ่มรายการได้";
							  }else
							  {				  
							  ?>
							  <img src="bimg/plus.gif" width="20" height="20" border="0"></a><a href="cost_add.php?tripid=<?=$tripid?>">&nbsp;&nbsp;ป้อนรายการค่าใช้จ่าย</a>
							  <?
							  }// endif check ปิดการเดินทาง
							  ?>							  </td>
                              <td width="30%">
                              <? 
				$sqlcheck = "
				select tripid from list  where tripid='$tripid'
				UNION
				select tripid from tripvalue where tripid = '$tripid'
				";
				$resultcheck =@mysql_query($sqlcheck);
				$resultnum = @mysql_num_rows($resultcheck);
			  				if(($resultnum != 0) || $pri=="100"){?>
                              <a href="#" onClick="if (confirm('คุณต้องการปิดการเดินทางนี้!!')) location.href='?action=endtrip&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>';" ><img src="bimg/plus.gif" width="20" height="20" border="0"> ปิดการเดินทาง</a>
<?php /*?>                              <? }else{ ?>
                              <a href="#" onClick="if (confirm('คุณต้องการยกเลิกการเดินทางนี้!!')) location.href='?action=endtrip&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>';" ><img src="bimg/plus.gif" width="20" height="20" border="0"> ยกเลิกการเดินทาง</a><?php */?>
                              <? }?>
                              </td>
                            </tr>
                          </table>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            <tr>
                              <td colspan="5" align="left" bgcolor="#A3B2CC"><strong>ค่าใช้จ่ายจำแนกรายโครงการ</strong></td>
                            </tr>
   <?
	$i=0;
	$no=0;
/* check userid query 
	If  ($pri == '100')
	{
		If ($sortfield == "")
		{
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')   group by  t1.id_type_project   order by date_list   ; ";
		}
		else
		{ 
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')    group by  t1.id_type_project    order by $sortfield  $sort ; ";
		}
	}else
	{
			If ($sortfield == "")
		{
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')  and (userid= '$_SESSION[userid]')  group by  t1.id_type_project   order by date_list   ; ";
		}
		else
		{ 
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')  and (userid= '$_SESSION[userid]')  group by  t1.id_type_project    order by $sortfield  $sort ; ";
		}
	
	}// end if privilage
	*/
	If ($sortfield == "")
		{
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')   group by  t1.id_type_project   order by date_list   ; ";
		}
		else
		{ 
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.code_project,t1.id_type_project from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid')    group by  t1.id_type_project    order by $sortfield  $sort ; ";
		}
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}		
?>
                            <tr bgcolor="<?=$bg?>">
                              <td width="30%" align="left" bgcolor="<?=$bg?>"><?=$no?>&nbsp;โครงการ &nbsp; <?=$rs[code_project]?>&nbsp; &nbsp;&nbsp;</td>
                              <td width="0%" align="left" bgcolor="<?=$bg?>">เป็นเงิน                              </td>
                              <td width="30%" align="right" bgcolor="<?=$bg?>" ><?=number_format($rs[total],2)?></td>
                              <td bgcolor="<?=$bg?>" >บาท</td>
                              <td width="16%" bgcolor="<?=$bg?>"><a href="trip_project_detail.php?tripid=<?=$tripid?>&id_type_project=<?=$rs[id_type_project]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">(แสดงรายละเอียด)</a></td>
                            </tr>
<?
}
?>
                          </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            <tr>
                              <td colspan="5" align="left" bgcolor="#A3B2CC"><strong>ค่าใช้จ่ายจำแนกรายหมวดค่าใช้จ่าย</strong></td>
                            </tr>
                            <?
	$i=0;
	$no=0;
		If ($sortfield == "")
		{
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.type_cost,t1.id_type_cost  from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  where (t1.tripid = '$tripid')    group by  t1.id_type_cost     order by date_list   ; ";
		}
		else
		{ 
			$str = " select  sum(t1.cash_total+t1.credit_total) as total,t2.type_cost,t1.id_type_cost  from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  where (t1.tripid = '$tripid')   group by  t1.id_type_cost  order by $sortfield  $sort ; ";
		}
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}		
?>
                            <tr bgcolor="<?=$bg?>">
                              <td width="30%" align="left" bgcolor="<?=$bg?>"><?=$no?>
                                &nbsp;
                                <?=$rs[type_cost]?>
                                &nbsp; &nbsp;&nbsp;</td>
                              <td width="0%" align="left" bgcolor="<?=$bg?>">เป็นเงิน</td>
                              <td width="30%" align="right" bgcolor="<?=$bg?>" ><?=number_format($rs[total],2)?></td>
                              <td bgcolor="<?=$bg?>" >บาท</td>
                              <td width="16%" bgcolor="<?=$bg?>"><a href="listtypecost.php?tripid=<?=$tripid?>&id_type_cost=<?=$rs[id_type_cost]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">(แสดงรายละเอียด)</a></td>
                            </tr>
                            <?
}
?>
                          </table>
                          <p>&nbsp;</p>
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="50%">&nbsp;</td>
                              <td width="50%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="50%">.......................................................</td>
                              <td width="50%">.......................................................</td>
                            </tr>
                            <tr>
                              <td width="50%" height="25">(<strong>
                                <?=GetTripOwner($tt)?>
                              </strong>)</td>
                              <td width="50%">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                            </tr>
                            <tr>
                              <td width="50%" height="25">วันที่ออกรายงาน 
                              <?=DBThaiLongDate(date("Y-m-d"));?></td>
                              <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อนุมัติ</td>
                            </tr>
                          </table>                          
                          <p><br>
                        </p></td>
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

