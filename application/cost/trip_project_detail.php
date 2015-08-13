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
	echo "<meta http-equiv='refresh' content='2;url=?tripid=$tripid&id_type_project=$id_type_project&sname=$sname&ssurname=$ssurname'>" ;
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
          <td height="30" colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="" class="style4">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</td>
              </tr>

          </table>
          </td>
        </tr>

<!--        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="กลับหน้าหลัก" type="button"  style="width: 90;" class="xbutton" value="กลับหน้าหลัก" onClick="location.href='list.php?tripid=<?=$tripid?>&id_type_project=<?=$id_type_project?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" >
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
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bordercolor="#A3B2CC" bgcolor="#A3B2CC">
                            <tr>
                              <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">
                                <tr>
                                  <td colspan="2" align="center" valign="top"><span class="style2">รายงานการเดินทางเพื่อออกปฏิบัติหน้าที่ในต่างจังหวัด</span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top"><strong>รหัสการเดินทาง</strong><span class="style2"> :
                                    <?
				$sqls = "select * from trip where tripid = '$tripid' ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo "$rss[tripid] ";
				?>
                                  </span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top"><strong>กิจกรรม</strong><strong> :
                                    <?=$rss[tripname]?>
                                  </strong></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top"><strong>ชื่อ-นามสกุล </strong><strong> :
                                    <?
							  $tt = $rss[tripid];
							  ?>
                                        <?=GetTripOwner($rss[tripid])?>
                                  </strong></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top"><strong>ช่วงเวลาออกปฏิบัติงาน :
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
							  echo ($str_date)?"จำนวน ".str_replace( "-","",intval(($str_date)/(60*60*24)) )." วัน	" : "";
							  ?>
                                  </strong> </td>
                                </tr>
                                <tr>
                                  <td width="10%" align="left" valign="top"><strong>โครงการ </strong></td>
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
										AND (t1.id_type_project = '$id_type_project')
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
										AND (t1.id_type_project = '$id_type_project')										
										group by  t1.id_type_project    
										order by $sortfield  $sort ; ";
									}
								$result = mysql_query($str);
								while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
								?>
                                      <tr>
                                        <td width="80"><NOBR><strong><a href="listproject.php?tripid=<?=$tripid?>&id_type_project=<?=$rs[id_type_project]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">
                                          <?=$rs[code_project]?"\"$rs[code_project]\"":""?>
                                        </a></strong>&nbsp;</td>
                                        <td ><?=$rs[name_project] ?></td>
                                      </tr>
                                      <?
								}							  
							  ?>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top">
								  <?
										$str = " 
										SELECT
										max(t1.date_list) as last_date
										FROM
										list AS t1
										where (t1.tripid = '$tripid')
										AND (t1.id_type_project = '$id_type_project')	
										limit 1
										";
								$result_lastdate = mysql_query($str);
								$rs_lastdate=mysql_fetch_assoc($result_lastdate);
								  ?>
								    <strong>รายละเอียดค่าใช้จ่าย : ข้อมูล ณ วันที่
                                    <?=($rs_lastdate[last_date])?daythai($rs_lastdate[last_date])." (วันที่สุดท้ายที่เกิดรายการค่าใช้จ่าย)":daythai(date("Y-m-d"))." (ยังไม่เกิดรายการค่าใช้จ่าย)"?>
                                    </strong></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            
                            <tr bgcolor="<?=$bg?>">
                              <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                              <td width="30%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>หมวดรายการ</strong></td>
                              <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนเงิน(บาท)</strong></td>
                            </tr>
                            <tr bgcolor="<?=$bg?>">
                              <td width="20%"  align="center" bgcolor="#A3B2CC"><strong>เงินสด</strong></td>
                              <td width="20%"  align="center" bgcolor="#A3B2CC" ><strong>เครดิต</strong></td>
                              <td width="20%"  align="center" bgcolor="#A3B2CC" ><strong>รวม</strong></td>
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
										from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
										where (t1.tripid = '$tripid')    
										AND (t1.id_type_project = '$id_type_project')	
										group by  t1.id_type_cost     order by date_list   ; ";
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
										from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost  
										where (t1.tripid = '$tripid')   
										AND (t1.id_type_project = '$id_type_project')	
										group by  t1.id_type_cost  order by $sortfield  $sort ; ";
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
                              <td align="left" bgcolor="<?=$bg?>">&nbsp;<a href="listtypecost.php?tripid=<?=$tripid?>&id_type_project=<?php echo $_GET['id_type_project']?>&id_type_cost=<?=$rs[id_type_cost]?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><?=$rs[type_cost]?></a>&nbsp; &nbsp;&nbsp;</td>
                              <td align="right" bgcolor="<?=$bg?>"><!--<?=$rs[Xnum_cash]?$rs[Xnum_cash]."x":""?>--><?=number_format($rs[cash_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>" ><!--<?=$rs[Xnum_credit]?$rs[Xnum_credit]."x":""?>--><?=number_format($rs[credit_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>" ><?=number_format($rs[total],2)?></td>
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
                            </tr>							
                          </table>
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td>หมายเหตุ การแสดงหมวดรายการให้แสดงเฉพาะหมวดรายการที่เกิดค่าใช้จ่ายที่เกิดขึ้นจริง </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
						  
						  
						  
						  
                         <table width="90%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                            <tr bgcolor="#A3B2CC" align="center">
                              <td width="5%" rowspan="2"><strong>ลำดับ</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=date_list&tripid=<?=$tripid?>&id_type_project=<?=$id_type_project?>">วันที่</a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                              <td colspan="3" bgcolor="#A3B2CC"><strong>จำนวนเงิน</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=id_type_project&tripid=<?=$tripid?>&id_type_project=<?=$id_type_project?>">หมวดค่าใช้จ่าย</a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>Cost ID</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>Tor ID</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=complete&tripid=<?=$tripid?>&id_type_project=<?=$id_type_project?>">BILL</a></strong></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td><strong>เงินสด</strong></td>
                              <td><strong>เครดิต</strong></td>
                              <td><strong>รวม</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            
							<?
							$i=0;
							$no=0;
							If ($pri =='100')
							{
								If ($sortfield == "")
								{
									$str = "select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. id_type_project='$id_type_project')  order by date_list  ";
								}else
								{
								$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. id_type_project='$id_type_project')  order by t1.$sortfield $sort  ";
								}
							}else
							{
								If ($sortfield == "")
								{
									$str = "select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. id_type_project='$id_type_project') and (t1.userid = '$userid') order by date_list  ";
								}else
								{
								$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. id_type_project='$id_type_project') and (t1.userid = '$userid') order by t1.$sortfield $sort  ";
								}
							}// end if privilage
							$result = mysql_query($str);
							while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
								$sum_cash+=$rs[cash_total];
								$sum_credit+=$rs[credit_total];								
								$i++;
								$no++;
								if ($i % 2) {
								$bg = "#EFEFEF";
								}else{
								$bg = "#DDDDDD";
								}
							if($rs[attach] != ""){ $attach = "<a href=\"".$rs[attach]."\"  target=\"_blank\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; } else { $attach = "";}		
							?>
                            <tr bgcolor="<?=$bg?>" align="center">
                              <td width="5%"><?=$no?></td>
                              <td bgcolor="<?=$bg?>"><?=daythai($rs[date_list])?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?="&nbsp;".$attach.$rs[detail]?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[cash_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[cash_total]+$rs[credit_total],2)?></td>
                              <td bgcolor="<?=$bg?>">
							  <?
							  $res = mysql_query("select * from type_cost");
							  while ($rss = mysql_fetch_assoc($res)){
								  if($rs[id_type_cost] == $rss[id_type_cost]){
									echo "$rss[type_cost]";
								  }
							  }							  
							  ?>							  </td>
                              <td align="center"><?php echo $rs['cost_id'];?></td>
                               <td align="center"><?php echo $rs['tor_id'];?></td>
                              <td bgcolor="<?=$bg?>">
							  <?
								  if($rs[complete] =="y"){
									echo "<img src=\"bimg/yy.png\" >";
								  }elseif ($rs[complete] =="n"){
									echo  "<img src=\"bimg/alert.gif\" >";				  
								  }
							  ?>							  </td>
                              <td bgcolor="<?=$bg?>">
							  <? 
							  	if($rs[cleartrip]=="y" || $rs[close]=="y"){
									echo "ไม่สามารถแก้ไขได้";
								}else{
								?> 
							  <a href="cost_add.php?runno=<?=$rs[runno]?>&tripid=<?=$tripid?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; 
							  <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>&id_type_project=<?=$id_type_project?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>
							  	<?
								}  //end if check close trip
								?></td>
								</tr>						
      						<? } 
							
				if(mysql_num_rows($result)>0){
					?>							
                            <tr align="center" bgcolor="#CCCCCC">
                              <td colspan="3"><strong>รวม</strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_cash,2)?>
                              </strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_credit,2)?>
                              </strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_cash+$sum_credit,2)?>
                              </strong></td>
                              <td colspan="5" ></td>
                              </tr>							
						<?
						}else{
						?>
                           <tr bgcolor="#CCCCCC" align="center">
                              <td colspan="12"><strong>ไม่มีข้อมูล</strong></td>                         
                            </tr>						
						<?					
						}							  
						?>  		
                          </table>
						  						  
						  
						  
						                            
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="50%">&nbsp;</td>
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

