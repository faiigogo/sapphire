<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){
		 if ($action =="close")
		 {
		 		Foreach ($checkbox as $key => $id)
				{
					if ($close > ""){
						$sql = "update list  set cleartrip = 'y' where runno = $id ";
					}else{
						$sql = "update list  set cleartrip  = '' where runno = $id ";
					}
					@mysql_query($sql);
				}
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					header("Location: ?tripid=$tripid");
					exit;
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
<title>ระบบบันทึกค่าใช้จ่าย</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="cost.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}

a:visited { color: #005CA2; text-decoration: none}

a:active { color: #0099FF; text-decoration: underline}

a:hover { color: #0099FF; text-decoration: underline}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}
.style9 {color: #000000}
-->
</style>
<!-- check การระบุค่า  -->
<script language="javascript"  src="libary/popcalendar.js"></script>
<script language=javascript>
<!--

//window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");

//	window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");
/*
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
*/
</script>

</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom ">
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
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 50;" class="xbutton" value="logout" onClick="location.href='logout.php';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
	  
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">
                          <br>
						  <form name="form2" method="post" action="?action=search">
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td>เลือกช่วงวันที่</td>
                              <td><span class="style9">
                                <input type="text" name="startday" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<? if($rs[date_list] == ""){ echo date("d/m/").(date("Y") ); }else{ echo swapdate($rs[date_list]); }?>" >
                              </span></td>
                              <td><span class="style9">
                                <input type="text" name="endday" id="getday" class="input" maxlength="10" style="width:200px;" value="<? if($rs[date_list] == ""){ echo date("d/m/").(date("Y") ); }else{ echo swapdate($rs[date_list]); }?>">
                              </span></td>
                              <td><label>
                                <select name="show" id="show">
                                  <option value="log">เอกสารที่บันทึก</option>
                                  <option value="now">เอกสารที่อยู่ระหว่างการป้อนรายการ</option>
                                  <option value="close">เอกสารที่บันทึกค่าใช้จ่ายเสร็จสิ้น</option>
                                  <option value="clear">เอกสารที่ผ่านการตรวจรับ</option>
                                  <option value="finish">เอกสารที่สรุปค่าใช้จ่ายเสร็จสิ้น</option>
                                </select>
                              </label></td>
                              <td>
                                <label></label>
                                  <label>
                                    <input type="submit" name="Submit" value="Submit">
                                  </label>
                                <label></label></td>
                            </tr>
                          </table>
     					 </form>
                          <br>
                          <form  name ="form1" method = POST  action = "?action=close"   >
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
							<!--<INPUT TYPE="hidden" NAME="tripid" VALUE="<?=$tripid?>">
                              <input type="checkbox" name="checkbox2" value="checkbox" onClick="CheckAll()"> 
                              เลือกทั้งหมด</td>
                              <td><a href="trip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"></a></td>
                              <td>&nbsp; -->
                              <td width="1%">
							  </td>
							  <?
	$word = "รายงานแสดงรายการที่ปิดทริปแล้วและยังไม่ได้ทำการตรวจสอบทั้งหมด";
	$i=0;
	$no=0;
	If ($sortfield == "")
	{
		$sortstring = "";
	}else
	{
		$sortstring = "order by $sortfield $sort";
	}
	$startday = swapdate($startday);
	$endday = swapdate($endday);
	If (($action == "search") and ($show == "log")) // คิวรี่ ตามวันที่ทำบันทึกรายการ
	{
		$str = " select * from list where date between '$startday' and '$endday' $sortstring  ";
		$word = "รายงานแสดงรายการตามวันที่ทำบันทึกรายการ ตั้งแต่วันที่".daythai($startday)." ถึง วันที่".daythai($endday)   ;
	}elseif (($action == "search") and ($show == "now")) // คิวรี่ตามเอกสารที่อยู่ระหว่างบันทึกรายการ
	{ 
		$str = "select * from list where (date_list between '$startday' and '$endday') and (endtrip is null) ";
		$word = "รายงานแสดงรายการตามเอกสารที่อยู่ระหว่างบันทึกรายการ ตั้งแต่วันที่".daythai($startday)." ถึง วันที่".daythai($endday)   ;	
	}elseif  (($action == "search") and ($show == "close"))  // คิวรี่ตามเอกสารที่บันทึกค่าใช้จ่ายเสร็จสิ้น
	{
		$str = "select * from list where (date_list between '$startday' and '$endday') and (endtrip ='y') and (clear  is null) ";
		$word = "รายงานแสดงรายการตามเอกสารที่บันทึกค่าใช้จ่ายเสร็จสิ้น ตั้งแต่วันที่".daythai($startday)." ถึง วันที่".daythai($endday)   ;	
	
	}elseif (($action == "search") and ($show == "clear"))  // คิวรี่ตามเอกสารที่ผ่านการตรวจรับ
	{
		$str = "select * from list where (date_list between '$startday' and '$endday') and (endtrip ='y') and (cleartrip = 'y') and (close  is null)  ";
		$word = "รายงานแสดงรายการตามเอกสารที่ผ่านการตรวจรับ ตั้งแต่วันที่".daythai($startday)." ถึง วันที่".daythai($endday)   ;	
	}elseif (($action == "search") and ($show == "finish"))  // คิวรี่ตามเอกสารที่สรุปค่าใช้จ่ายเสร็จสิ้น
	{
		$str = "select * from list where (date_list between '$startday' and '$endday') and (endtrip ='y') and (cleartrip = 'y') and (close = 'y')  ";
		$word = "รายงานแสดงรายการตามเอกสารที่สรุปค่าใช้จ่ายเสร็จสิ้น ตั้งแต่วันที่".daythai($startday)." ถึง วันที่".daythai($endday)   ;	
	}else
	{
	 $str = " select * from list where endtrip  = 'y'  and (cleartrip is null  or cleartrip = '' )  $sortstring ";
	}
?>
							  <td>
							<?
							  echo  $word ;
							  ?>
							  </td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                          <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                            <tr bgcolor="#A3B2CC" align="center">
                              <td width="3%" rowspan="3">เลือกรายการ</td>
                              <td width="3%" rowspan="3"><strong>ลำดับ</strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=date_list&tripid=<?=$tripid?>&action=<?=$action?>&show=<?=$show?>">วันที่</a></strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC">&nbsp;</td>
                              <td rowspan="3" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=tripid&action=<?=$action?>&show=<?=$show?>">ชื่อพนักงาน</a></strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC"><a href="?<?=$getstr?>sortfield=tripid&action=<?=$action?>&show=<?=$show?>">TripID</a></td>
                              <td colspan="2" bgcolor="#A3B2CC"><strong>จำนวนเงิน</strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=id_type_project&tripid=<?=$tripid?>&action=<?=$action?>&show=<?=$show?>">โครงการ</a></strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=complete&tripid=<?=$tripid?>&action=<?=$action?>&show=<?=$show?>">BILL</a></strong></td>
                              <td rowspan="3" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td><strong>CASH</strong></td>
                              <td><strong>CREDIT</strong></td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td><strong>รวม</strong></td>
                              <td><strong>รวม</strong></td>
                            </tr>
    <?
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
		if($rs[attach] != ""){ $attach = "<a href=\"".$rs[attach]."\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; } else { $attach = "";}		
?>
                            <tr bgcolor="<?=$bg?>" align="center">
                              <td width="3%"><label>
                                <input type="checkbox" name="checkbox[]" value="<?=$rs[runno]?>"  <? if ($c =="0") echo "disabled";?>>
                              </label></td>
                              <td width="3%"><?=$no?></td>
                              <td bgcolor="<?=$bg?>"><?=daythai($rs[date_list])?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?
				$trip = 0;
				$closed = $ended = $cleared = true;
		//	//	$sqlcheck = "select * from list  where tripid='$rs[tripid]' ; ";
				$resultcheck = mysql_query($sqlcheck);
		//		while ($rscheck=mysql_fetch_array($resultcheck,MYSQL_ASSOC)) {
					if ($rs["close"] != "y")  $closed = false;
					if ($rs["endtrip"] != "y")  $ended = false;
					if ($rs["cleartrip"] != "y")  $cleared = false;
			//	}

				if ($closed){
					echo "<img src=\"bimg/finish.gif\" width=\"15\" height=\"15\">";
				}else if ($cleared){
					echo "<img src=\"bimg/close.gif\" width=\"15\" height=\"15\">";
				}else if ($ended){
					echo "<img src=\"bimg/clear.gif\" width=\"15\" height=\"15\">";
				}else{
					echo "<img src=\"bimg/start.gif\" width=\"15\" height=\"15\">";
				}
				?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?="&nbsp;".$attach.$rs[detail]?>      </td>
                              <td align="left" bgcolor="<?=$bg?>">
                                <?=GetTripOwner($rs[tripid])?>
                              </td>
                              <td align="left" bgcolor="<?=$bg?>"><?=$rs[tripid]?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[cash_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_total],2)?></td>
                              <td bgcolor="<?=$bg?>">
							  <?
							  $res = mysql_query("select * from type_project");
							  while ($rss = mysql_fetch_assoc($res))
							  {
							  If ($rs[id_type_project] == $rss[id_type_project])
							  	{
							  		echo "$rss[code_project]";
							  	}
							  }
							  ?>							  </td>
                              <td bgcolor="<?=$bg?>"><?
							  If ($rs[complete] =="y")
							  {
							  	echo "<img src=\"bimg/yy.png\" >";
							  }elseif ($rs[complete] =="n")
							  {
							  	echo  "<img src=\"bimg/alert.gif\" >";
							  }
							  ?></td>
                              <td bgcolor="<?=$bg?>"><a href="cost_add.php?runno=<?=$rs[runno]?>&tripid=<?=$tripid?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a></td>
                              <?
	} //while
// List Template
?>
                          </table>
						  <br>
						  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                            <tr valign="middle">
                              <td align="right" width="290" height="32">&nbsp;&nbsp;</td>
                              <td align="right" width="300" height="32"><input name="open" type="submit" id="open" value="เปิดรายการ">
                              &nbsp;&nbsp;
                              <input name="close" type="submit" id="close" value="ปิดรายการ">
                              &nbsp; &nbsp;&nbsp;</td>
                            </tr>
                          </table>
						  </form>
						  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
                            <tr>
                              <td width="20">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="20"><img src="bimg/finish.gif" width="15" height="15"></td>
                              <td>สรุปค่าใช้จ่ายเสร็จสิ้น</td>
                            </tr>
                            <tr>
                              <td width="20"><img src="bimg/close.gif" width="15" height="15"></td>
                              <td>ผ่านการตรวจรับเอกสาร รอการอนุมัติ </td>
                            </tr>
                            <tr>
                              <td width="20"><img src="bimg/clear.gif" width="15" height="15"></td>
                              <td>บันทึกรายการค่าใช้จ่ายเสร็จสิ้น</td>
                            </tr>
                            <tr>
                              <td width="20"><img src="bimg/start.gif" width="15" height="15"></td>
                              <td>อยู่ในระหว่างการป้อนรายการ</td>
                            </tr>
                          </table>
						  <br>
	</td>
  </tr>
</table>
</body>
</html>