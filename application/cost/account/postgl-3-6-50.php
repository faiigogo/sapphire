<?php
session_start();
//ini_set("display_errors","1");
include ("../checklogin.php");
include ("../phpconfig.php");
include ("../libary/function.php");

/*
$myServer = "THEMAI\SQLEXPRESS"; 
$myUser = "sa"; 
$myPass = "dataadmin"; 
$myDB = "Company_001"; 
*/

$myServer = "202.69.143.78";
$myUser = "sa"; 
$myPass = ""; 
$myDB = "Company_001"; 

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

<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="../cost.css" type="text/css" rel="stylesheet">

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

        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 50;" class="xbutton" value="Exit" onClick="location.href='showtrip.php';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">
                          <p>&nbsp;</p>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="5" bgcolor="#A3B2CC">
                            <tr>
                              <td width="20%" align="left"><span class="menuitem">บริษัท แซฟไฟร์ รีเสิร์ช แอนด์ ดีเวลล๊อปเม็นท์ จำกัด </span></td>
                            </tr>
                            <tr>
                              <td width="20%" align="left"><strong>199/445 หมู่2 ต.หนองจ๊อม อ.สันทราย จ.เชียงใหม่ 50210 </strong></td>
                            </tr>
                          </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#A3B2CC">
                            <tr>
                              <td width="20%" align="right">&nbsp;</td>
                              <td width="30%" align="center">&nbsp;</td>
                              <td width="10%" align="right"><strong>เลขที่</strong></td>
                              <td width="30%" bgcolor="#FFFFFF"><strong>
                                <?=$nogl?>
                              </strong></td>
                            </tr>
                            <tr>
                              <td width="20%" align="right">&nbsp;</td>
                              <td width="30%" align="center">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#A3B2CC"><strong>วันที่</strong></td>
                              <td width="30%" bgcolor="#FFFFFF"><?
							  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '$tripid' ";
							  $resultd = mysql_query($sqld);
							  $rsd = mysql_fetch_assoc($resultd);
   						       echo daythai($rsd[maxdate]);		  			  
							  ?></td>
                            </tr>

                            <tr>
                              <td width="20%" align="right"><strong>ใบสำคัญจ่าย</strong></td>
                              <td width="30%" align="right">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="20%" align="right"><strong>รายละเอียด</strong></td>
                              <td width="30%" align="center">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><strong>ชื่อ</strong></td>
                              <td align="center" bgcolor="#FFFFFF"><strong>
                                <?
								$name =  GetTripOwner($tripid);
								echo $name  ;
								$strid = "select  t1.id_type_project,t2.code_project from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project  where (t1.tripid = '$tripid') and t2.id_type_project  = '$id_type_project'    ;";
								$resultid  = mysql_query($strid);
								$rsid = mysql_fetch_assoc($resultid);
								
								?>
                              </strong></td>
                              <td width="10%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><strong>โครงการ</strong></td>
                              <td align="center" bgcolor="#FFFFFF"><?
							  echo $rsid[code_project];
							  ?></td>
                              <td width="10%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"><strong>ช่วงเวลาออกพื้นที่ปฏิบัติงาน</strong>ี่</td>
                              <td align="center" bgcolor="#FFFFFF"><?
							  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '$tripid' ";
							  $resultd = mysql_query($sqld);
							  $rsd = mysql_fetch_assoc($resultd);
						       echo daythai($rsd[mindate]);
							   echo "&nbsp; - &nbsp;";
   						       echo daythai($rsd[maxdate]);		  			  
							  ?></td>
                              <td width="10%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                          </table>
                          <br>
 <?
$docdate 		= swapdate($rsd[maxdate]);
$refdocdate 	= swapdate($rsd[maxdate]);
$detail 			= $name.$tripid.$code_project;
//$myServer		= "202.69.143.78";
$myServer 	= "192.168.2.14";
$myUser 		= "sa"; 
$myPass 		= ""; 
$myDB 			= "Company_001"; 


/*
$myServer = "THEMAI\SQLEXPRESS"; 
$myUser = "sa"; 
$myPass = "dataadmin"; 
$myDB = "Company_001"; 
*/

$db = new COM("ADODB.Connection"); 
//$dsn = "DRIVER=\{SQL Server}; SERVER=\{$myServer};UID=\{$myUser};PWD=\{$myPass}; DATABASE=\{$myDB}"; 
//$dsn = "DRIVER={SQL Server}; SERVER=$myServer;UID=$myUser;PWD=$myPass; DATABASE=$myDB;"; 
$dsn = "Provider=sqloledb;Data Source=$myServer;Initial Catalog=$myDB;User Id=$myUser;Password=$myPass;";
//$dsn = "DRIVER={SQL Server};SERVER=$myServer;DATABASE=$myDB;AutoTranslate=no";
//$cid 	= odbc_connect($dsn, $myUser, $myPass) or die ("เชื่อมไม่ได้");

//echo $dsn;
$db->Open($dsn);


// Check Project 
$sqlPJID	= "SELECT RecID FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$code_project' ";
$rsPJID 	= $db->Execute($sqlPJID);

If ($rsPJID->EOF)
{
?>
	<script>alert("ไม่เจอโปรเจคนี้ในระบบฐานข้อมูลของ Accrone")</script>
<?
	exit();
}

$sqlcheck = "SELECT  *  FROM  ShowGL_HD  Where  DocCode = '$nogl' ";
//echo $sqlcheck;
$rscheck  = $db->Execute($sqlcheck); 
If (!$rscheck->EOF)
{
$check  =  $rscheck->Fields['RecID']->Value;
}else
{
$check = 0;
}

If (intval($check) == 0)
{
	$step = "insert";
}else
{
	$step = "update";
}
$datenow  = date("Ymd");
//echo "check = $check  <BR>";
//echo "step = $step ";

if ($step =="insert")
{
$rs = $db->Execute("INSERT INTO ShowGL_HD (System,RecHDID,SuppID,DocCode,RefDocCode,DocDate,RefDocDate,TempGLID,AccBookID,GLDescription,DebitAmnt,CreditAmnt,GL,SysGL,CheqFlag,Active,TimeUpdate)  VALUES  ('FA',0,0,'$nogl','','$docdate','$refdocdate',0,15,'$detail',$sum_debit,$sum_credit,0,1,0,1,'20070408') ");
}elseif ($step == "update")
{
$rs = $db->Execute("UPDATE  ShowGL_HD SET 
System  = 'FA' ,RecHDID = 0 ,SuppID  = 0,DocCode = '$nogl'  ,RefDocCode =  '' ,DocDate = '$docdate' ,RefDocDate =  '$refdocdate',TempGLID =  0,AccBookID = 15 ,GLDescription  = '$detail' ,DebitAmnt  = $sum_debit ,CreditAmnt  = $sum_credit,GL = 0 ,SysGL = 1 ,CheqFlag  = 0,Active = 1 ,TimeUpdate = '$datenow'  where RecID = '$check' ");
}
?>
<br>
 <?
$sqlRecHD = "SELECT max(RecID) as RecID  FROM ShowGL_HD Where DocCode = '$nogl' ";
$rsRecHD  = $db->Execute($sqlRecHD);
$RecHD  =  $rsRecHD->Fields['RecID']->Value;
//echo $RecHD;
						  ?>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            <tr>
                              <td width="15%" bgcolor="#A3B2CC"><div align="center"><strong>เลขที่บัญชี</strong></div></td>
                              <td width="45%" bgcolor="#A3B2CC"><div align="center"><strong>รายละเอียด</strong></div></td>
                              <td colspan="2" bgcolor="#A3B2CC"><div align="center"><strong>เดบิท</strong></div></td>
                              <td width="20%" bgcolor="#A3B2CC"><div align="center"><strong>เครดิต</strong></div></td>
                            </tr>
      <?
If ($step == "update")
{
	$sqldelete = "delete  from ShowGL_DT where RecHDID = '$RecHD' ";
//	echo $sqldelete;
	$db->Execute($sqldelete);
}
	$i=0;
	$no=0;
	$id_saving = 0;
	$id_tax_type = 0;
	$id_saving_check ="";
	$sum_cash = 0;
	$sum_credit =0;
	$sum_vat_get = 0;
	$sum_vat_noget = 0;
	$sum_debit = 0;
		$str = "select  t1.userid,t1.vat5,t1.vat5_check,t1.detail,t1.cash as cash,t1.credit as credit,t2.id_type_cost,t2.type_cost,t1.id_saving,t1.id_tax_type,t1.cash_check,t1.credit_check,t1.cash_vat,t1.credit_vat,t1.cash_total,t1.credit_total   from list t1 inner join type_cost t2 on t1.id_type_cost = t2.id_type_cost where   t1.id_type_project = '$rsid[id_type_project]' and t1.tripid= '$tripid'  order by t1.id_type_cost  ;";
	//	echo $str;
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}	
		
if ($rs[vat5_check] =="1") //ภาษีซื้อขอคืน 5 %
{
	$vat5_check ="1";
	$sumvat5 = $sumvat5+$rs[vat5];
}

if ($rs[cash_check] =="1")    // รายการประเภทเงินสด
{
	$sumcash = $sumcash+$rs[cash];	
	//check การรวมเงินของภาษี 
	if ($rs[id_tax_type] =="1") //ภาษีซื้อขอคืน
	{
		$sum_vat_get = $sum_vat_get + $rs[cash_vat];
	}elseif  ($rs[id_tax_type] =="2") //ภาษีซื้อไม่ขอคืน
	{
		$sum_vat_noget = $sum_vat_noget + $rs[cash_vat];
	}
	
	// เช็คสถานะ เพื่อนำค่ารายการบัญชี saving ไปแสดงในรายการของเครดิต
			$ch_ca = "1";  // set สถานะว่ามีการติ๊กแบบเงินสด
			$sum_credit_saving = $sum_credit_saving+$rs[cash_total];	 // นำค่าไปแสดงในการบัญชี saving
			if ($id_saving =="0")  // เช็คว่ามีการเลือกรายการบัญชี หรือยัง
			{
			$id_saving = $rs[id_saving];	
			}elseif ($id_saving != "$rs[id_saving]")
			{
			$id_check = "มีรายการที่ป้อน รหัส saving ไม่ตรงกับรายการอื่น";	
			}else
			{
			$id_saving = $rs[id_saving];
			}
	
	
}elseif ($rs[credit_check] =="1")  //รายงานประเภทที่จ่ายด้วยบัตร เครดิต
{
	$ch_credit ="1";
	$sum_credit_credit = $sum_credit_credit+$rs[credit_total];	  // นำค่าไปแสดงในรายการเงินกู้ยืมกรรมการ
	$sumcredit = $sumcredit + $rs[credit];
	if ($rs[id_tax_type] =="1") //ภาษีซื้อขอคืน
	{
		$sum_vat_get = $sum_vat_get + $rs[credit_vat];
	}elseif  ($rs[id_tax_type] =="2") //ภาษีซื้อไม่ขอคืน
	{
		$sum_vat_noget = $sum_vat_noget + $rs[credit_vat];
	}
}
?>
                            <tr bgcolor="<?=$bg?>">
							<?
 							If ($rs[id_type_cost] == '5')
							 {
							$straccr  = "select * from type_accrone t1 where t1.id_type_cost = '$rs[id_type_cost]' and  t1.userid = '$rs[userid]' order by t1.id_type_cost ";
							}else
							{
							$straccr  = "select * from type_accrone t1 where t1.id_type_cost = '$rs[id_type_cost]' order by t1.id_type_cost ";
							}
							$resultaccr = mysql_query($straccr);
							$rsaccr = mysql_fetch_array($resultaccr);
						//	echo $straccr;
							?>
                              <td width="15%" bgcolor="#FFFFFF"><?=$rsaccr[id_cost_accrone]?></td>
                              <td width="45%" bgcolor="#FFFFFF"><?
							 echo $rsaccr[type_accrone];
							 ?></td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF"><?
							  if ($rs[cash_check] =="1")
							  {
							  $debit_show = $rs[cash];
							  $sum_debit = $sum_debit + $rs[cash];
							  }elseif ($rs[credit_check] =="1")
							  {
							  $debit_show = $rs[credit];
							  $sum_debit = $sum_debit + $rs[credit];
							  }
							  echo number_format($debit_show,2);
							  ?></td>
<?
		//// write ลง Table ///////////////

$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '$rsaccr[id_cost_accrone]' ";
$rsACC  = $db->Execute($sqlACC); 

$sqlPJID = "SELECT RecID FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$code_project' ";
$rsPJID = $db->Execute($sqlPJID);

$sqlBr = "SELECT RecID FROM SMGe_BranchProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 0001 and CompanyID = 1";
$rsBr  = $db->Execute($sqlBr);

$sqlSide = "SELECT RecID FROM SMGe_SideProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1" ;
$rsSide = $db->Execute($sqlSide);

$sqlDept = "SELECT RecID FROM SMGe_DepartmentProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1 and SideID = 1";
$rsDept = $db->Execute($sqlDept);
/*
 while (!$rsACC->EOF)
 { 
    echo $rsACC->Fields['RecID']->Value."";
    $rsACC->MoveNext();
 }	
*/
//RecID 
$RecID  = $rsDT->Fields['RecID']->Value ;  
$RecHDID  = $RecHD ;
$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$ProjID  = $rsPJID->Fields['RecID']->Value ;
$DebitAmnt  = $debit_show ;
$CreditAmnt = 0;
$BranchIDFrom =   $rsBr->Fields['RecID']->Value ;
$SideID = $rsSide->Fields['RecID']->Value ;
$DeptID = $rsDept->Fields['RecID']->Value ;
$Active  = 1 ;
$UserLogin = 1;
$UserAdjust = '' ;
$AdjNew =  0 ;
$AdjFlag = 0 ;
$TimeAdj  = '$datenow'  ;

//If ($step == "insert")
//{
//$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";
//}elseif ($step == "update")
//{
$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";
//}
$rs = $db->Execute($sqlinsert);


		///////////////////////
?>
                              <td width="20%" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            </tr>
						<?
						}  // end while
						?>
			<tr bgcolor="<?=$bg?>">
                              <td width="15%" bgcolor="#FFFFFF">114000</td>
                              <td width="45%" bgcolor="#FFFFFF">ภาษีซื้อขอคืน </td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF">
                                <?=number_format($sum_vat_get,2)?>                             </td>
                              <td width="20%" align="right" bgcolor="#FFFFFF">&nbsp;</td>

			</tr>			
			<tr bgcolor="<?=$bg?>">
                              <td width="15%" bgcolor="#FFFFFF">590001</td>
                              <td width="45%" bgcolor="#FFFFFF">ภาษีซื้อไม่ขอคืน</td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF">
                                <?=number_format($sum_vat_noget,2)?>                              </td>
                              <td width="20%" align="right" bgcolor="#FFFFFF">&nbsp;</td>
			</tr>		
<?
		//// write ลง Table ภาษีซื้อขอคืน - ภาษีซื้อไม่ขอคืน  ///////////////

$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '114000' ";
$rsACC  = $db->Execute($sqlACC); 
/*
$sqlPJID = "SELECT RecID FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$code_project' ";
$rsPJID = $db->Execute($sqlPJID);

$sqlBr = "SELECT RecID FROM SMGe_BranchProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 0001 and CompanyID = 1";
$rsBr  = $db->Execute($sqlBr);

$sqlSide = "SELECT RecID FROM SMGe_SideProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1" ;
$rsSide = $db->Execute($sqlSide);

$sqlDept = "SELECT RecID FROM SMGe_DepartmentProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1 and SideID = 1";
$rsDept = $db->Execute($sqlDept);
*/

$RecHDID  = $RecHD ;
$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$ProjID  = $rsPJID->Fields['RecID']->Value ;
$DebitAmnt  = $sum_vat_get ;
$CreditAmnt = 0 ;
$BranchIDFrom =   $rsBr->Fields['RecID']->Value ;
$SideID = $rsSide->Fields['RecID']->Value ;
$DeptID = $rsDept->Fields['RecID']->Value ;
$Active  = 1 ;
$UserLogin = 1 ;
$UserAdjust = '' ;
$AdjNew =  0 ;
$AdjFlag = 0 ;
$TimeAdj  = '$datenow'  ;

$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";

$rs = $db->Execute($sqlinsert);

// ภาษีซื้อไม่ขอคืน
$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '590001' ";
$rsACC  = $db->Execute($sqlACC); 

$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$DebitAmnt  = $sum_vat_noget ;

$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";

$rs = $db->Execute($sqlinsert);


		///////////////////////
?>
<?
If ( $vat5_check =="1")
{ 
//	$strcr = "select  * from saving_type where id_saving = '$id_saving' "; 
/*
	$strcr = "select * from  type_accrone where id_saving = '$id_saving' ";
	$resultcr = mysql_query($strcr);
	while ($rscr=mysql_fetch_array($resultcr,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}	*/
?>
			<tr bgcolor="">
                              <td width="15%" bgcolor="#FFFFFF">213202</td>
                              <td width="45%" bgcolor="#FFFFFF">ภาษีหัก ณ ที่จ่ายรอนำส่ง </td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="20%" align="right" bgcolor="#FFFFFF"><?=number_format($sumvat5,2)?></td>
			</tr>		
				<?
$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '213202' ";
$rsACC  = $db->Execute($sqlACC); 

$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$DebitAmnt  = 0 ;
$CreditAmnt  = $sumvat5 ;

$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";

$rs = $db->Execute($sqlinsert);
				//	}  // end while
} // end if (vat5 =="0")
				?>
					<!--  ++++++++ เริ่มแสดงรายการ ที่เป็นด้าน เครดิต   +++++++++++++++ -->
     <?
If ( $ch_ca =="1")
{ 
//	$strcr = "select  * from saving_type where id_saving = '$id_saving' "; 
	$strcr = "select * from  type_accrone where id_saving = '$id_saving' ";
	$resultcr = mysql_query($strcr);
	while ($rscr=mysql_fetch_array($resultcr,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}	
?>
						   <tr bgcolor="<?=$bg?>">
                              <td width="15%" bgcolor="#FFFFFF"><?=$rscr[id_cost_accrone]?></td>
                              <td width="45%" bgcolor="#FFFFFF"><?=$rscr[type_accrone]?></td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF"></td>
                              <td width="20%" align="right" bgcolor="#FFFFFF">
                                <?=number_format($sum_credit_saving,2)?>
                             </td>
<?
//// write ลง Table ///////////////

$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '$rscr[id_cost_accrone]' ";
$rsACC  = $db->Execute($sqlACC); 
/*
$sqlPJID = "SELECT RecID FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$code_project' ";
$rsPJID = $db->Execute($sqlPJID);

$sqlBr = "SELECT RecID FROM SMGe_BranchProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 0001 and CompanyID = 1";
$rsBr  = $db->Execute($sqlBr);

$sqlSide = "SELECT RecID FROM SMGe_SideProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1" ;
$rsSide = $db->Execute($sqlSide);

$sqlDept = "SELECT RecID FROM SMGe_DepartmentProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1 and SideID = 1";
$rsDept = $db->Execute($sqlDept);

 while (!$rsACC->EOF)
 { 
    echo $rsACC->Fields['RecID']->Value."";
    $rsACC->MoveNext();
 }	
*/
//RecID 
$RecHDID  = $RecHD ;
$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$ProjID  = $rsPJID->Fields['RecID']->Value ;
$DebitAmnt  = 0 ;
$CreditAmnt = $sum_credit_saving ;
$BranchIDFrom =   $rsBr->Fields['RecID']->Value ;
$SideID = $rsSide->Fields['RecID']->Value ;
$DeptID = $rsDept->Fields['RecID']->Value ;
$Active  = 1 ;
$UserLogin = 1 ;
$UserAdjust = '' ;
$AdjNew =  0 ;
$AdjFlag = 0 ;
$TimeAdj  = '$datenow'  ;


$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";

$rs = $db->Execute($sqlinsert);
//echo $sqlinsert;

		///////////////////////
?>
						    </tr>
							
				<?
					}  // end while
} // end if ($ch_credit =="0")
				?>

<!--  ++++++++ เริ่มแสดงรายการ ที่เป็นด้าน เครดิต เงินกู้ยืมกรรมการ   +++++++++++++++ -->
  <?
If ($ch_credit =="1")
{ 
	$strk = "select t1.id_type_credit ,sum(t1.credit_total) as credit_total from list t1 left join type_credit t2 on t1.id_type_credit = t2.id_type_credit  where   t1.id_type_project = '$rsid[id_type_project]' and t1.tripid= '$tripid' and t1.credit_check ='1' group by t2.owner_credit  ";
//	echo $strk;
	$resultk = mysql_query($strk);
	while ($rsk=mysql_fetch_array($resultk,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}	
?>
						   <tr bgcolor="<?=$bg?>">
						   <?
						     If  ($rsk[id_type_credit] == "2" or $rsk[id_type_credit] =="4" or $rsk[id_type_credit] == "5")
							  {
							  $fromcr = "เงินกู้ยืมจากกรรมการ - k.กัมปนาท";
							  $id_cost_accrone = "220002";
							  }elseIf  ($rsk[id_type_credit] == "6" or $rsk[id_type_credit] =="7" or $rsk[id_type_credit] == "8" or $rsk[id_type_credit] == "9")
							  {
							  $fromcr = "เงินกู้ยืมจากกรรมการ - k.จุฑาทิยพ์";
							  $id_cost_accrone = "220003";
							  }elseif  ($rsk[id_type_credit] == "10")
							  {
							  $fromcr = "เงินกู้ยืมจากกรรมการ - k.สันติภาพ";
							  $id_cost_accrone = "220001";
							  }
						   ?>
                              <td width="15%" bgcolor="#FFFFFF"><?=$id_cost_accrone?></td>
                              <td width="45%" bgcolor="#FFFFFF">
							  <?=$fromcr?></td>
                              <td width="10%" bgcolor="#FFFFFF">&nbsp;</td>
                              <td width="10%" align="right" bgcolor="#FFFFFF"></td>
                              <td width="20%" align="right" bgcolor="#FFFFFF">
                                <?
								echo number_format($rsk[credit_total],2);
								$rsk_credit_total = $rsk[credit_total];
								?>                            </td>
						    </tr>
<?
//// write ลง Table ///////////////

$sqlACC = "SELECT RecID FROM SMGe_SetAccCoa_ShowGridMain Where Status = 1 and Active = 1 and DocCode = '$id_cost_accrone' ";
$rsACC  = $db->Execute($sqlACC); 
/*
$sqlPJID = "SELECT RecID FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$code_project' ";
$rsPJID = $db->Execute($sqlPJID);

$sqlBr = "SELECT RecID FROM SMGe_BranchProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 0001 and CompanyID = 1";
$rsBr  = $db->Execute($sqlBr);

$sqlSide = "SELECT RecID FROM SMGe_SideProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1" ;
$rsSide = $db->Execute($sqlSide);

$sqlDept = "SELECT RecID FROM SMGe_DepartmentProfile_ShowGridMain Where Status = 1 and Active = 1 and DocCode = 001  and CompanyID = 1 and BranchID = 1 and SideID = 1";
$rsDept = $db->Execute($sqlDept);

 while (!$rsACC->EOF)
 { 
    echo $rsACC->Fields['RecID']->Value."";
    $rsACC->MoveNext();
 }	
*/
//RecID 
$RecHDID  = $RecHD ;
$AccCoaID  = $rsACC->Fields['RecID']->Value ;  
$ProjID  = $rsPJID->Fields['RecID']->Value ;
$DebitAmnt  = 0 ;
$CreditAmnt = $rsk[credit_total] ;
$BranchIDFrom =   $rsBr->Fields['RecID']->Value ;
$SideID = $rsSide->Fields['RecID']->Value ;
$DeptID = $rsDept->Fields['RecID']->Value ;
$Active  = 1 ;
$UserLogin = 1 ;
$UserAdjust = '' ;
$AdjNew =  0 ;
$AdjFlag = 0 ;
$TimeAdj  = '$datenow'  ;

$sqlinsert = "INSERT INTO ShowGL_DT (RecHDID,AccCoaID,ProjID,DebitAmnt,CreditAmnt,BranchIDFrom,SideID,DeptID,Active,UserLogin,UserAdjust,AdjNew,AdjFlag,TimeAdj)  VALUES  ($RecHDID,$AccCoaID,$ProjID,$DebitAmnt,$CreditAmnt,$BranchIDFrom,$SideID,$DeptID,$Active,'$UserLogin','$UserAdjust',$AdjNew,$AdjFlag,'$TimeAdj') ";

$rs = $db->Execute($sqlinsert);
?>
				<?
					}  // end while
} // end If ($ch_credit =="1")
				?>
					      </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="45%">&nbsp;</td>
                              <td width="15%" align="right"><strong>รวม</strong></td>
                              <td width="10%">&nbsp;</td>
                              <td width="10%" align="right"><strong>
                              <?
							  $sum_debit = $sum_debit + $sum_vat_get + $sum_vat_noget;
							  echo number_format($sum_debit,2);
							  ?>
                              </strong></td>
                              <td width="20%" align="right"><strong>
                                <?
								$sum_c = $sum_credit_saving+$rsk_credit_total+$sumvat5;
								echo number_format($sum_c,2);
						//	echo number_format($rsk[credit_total],2);
								?>
                              </strong></td>
                            </tr>
                          </table>
                          <p>&nbsp;</p>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2">
                            <tr>
                              <td height="30" valign="bottom">ผู้จัดทำ</td>
                              <td height="30" valign="bottom">.......................................................</td>
                              <td height="30" valign="bottom">ผู้ตรวจสอบ</td>
                              <td height="30" valign="bottom">.......................................................</td>
                              <td height="30" align="center" valign="bottom">ได้รับเงินถูกต้องเรียบร้อย</td>
                            </tr>
                            <tr>
                              <td height="50"></td>
                              <td height="50"></td>
                              <td height="50">&nbsp;</td>
                              <td height="50">&nbsp;</td>
                              <td height="50" align="center" valign="bottom">.......................................................</td>
                            </tr>
                            <tr>
                              <td height="25" valign="bottom">ผู้รับรองถูกต้อง</td>
                              <td valign="bottom">.......................................................</td>
                              <td valign="bottom">ผู้อนุมัติ</td>
                              <td valign="bottom">.......................................................</td>
                              <td align="center" valign="bottom"><br>
                                ........./........./.........<br>
                              ผู้รับเงิน</td>
                            </tr>
                          </table>                          
                          <p><br>
                        </p></td>
                      </tr>
                  </table>
				  </td>
                </tr>
              </table>
</td>
        </tr>
     </table>
    </td>
  </tr>
  
 <?
$db->Close();
  ?>
</table>
</body>
</html>

