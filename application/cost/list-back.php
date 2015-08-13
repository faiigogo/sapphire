<?php
session_start();
//ini_set("display_errors","1");
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
				<!--<input name="" type="reset"  value = "กลับหน้าหลัก"  onClick="location.href='index.php';">-->
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

<title>ระบบลงทะเบียนเพื่อเข้าร่วมโครงการ</title>

<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="cost.css" type="text/css" rel="stylesheet">

<style type="text/css">

<!--

body {  margin: 0px  0px; padding: 0px  0px}

a:link { color: #005CA2; text-decoration: none}

a:visited { color: #005CA2; text-decoration: none}

a:active { color: #0099FF; text-decoration: underline}

a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #000000}
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
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td width="">			  </td>
              </tr>

          </table>
            <span class="style4">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</span></td>

        </tr>

<!--        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='list.php';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>-->
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
                          </tr>
                        </table>
                          <br>
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="85%">&nbsp;</td>
                              <td><a href="cost_add.php"><img src="bimg/plus.gif" width="20" height="20" border="0"> &nbsp;เพิ่มรายการ</a></td>
                            </tr>
                          </table>
                          <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                            <tr bgcolor="#A3B2CC" align="center">
                              <td rowspan="3"><strong>ลำดับ</strong></td>
                              <td rowspan="3"><strong><a href="?<?=$getstr?>sortfield=date_list">วันที่</a></strong></td>
                              <td rowspan="3"><strong>รายการ</strong></td>
                              <td colspan="6"><strong>จำนวนเงิน</strong></td>
                              <td rowspan="3"><strong><a href="?<?=$getstr?>sortfield=id_type_project">โครงการ</a></strong></td>
                              <td colspan="2" rowspan="2"><strong>BILL</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td colspan="3"><strong>CASH</strong></td>
                              <td colspan="3"><strong>CREDIT</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td><strong>มูลค่า</strong></td>
                              <td><strong>vat7%</strong></td>
                              <td><strong>รวม</strong></td>
                              <td><strong>มูลค่า</strong></td>
                              <td><strong>vat7%</strong></td>
                              <td><strong>รวม</strong></td>
                              <td><strong>เลขที่ใบเสร็จ</strong></td>
                              <td><strong>N</strong></td>
                              <td>&nbsp;</td>
                            </tr>
    <?
	$i=0;
	$no=0;
	If ($sortfield == "")
	{
		$str = " select * from list  where runno = $runno order by date_list   ; ";
	}
	else
	{
		$str = " select *  from list   runno = $runno order by $sortfield  $sort ; ";
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
if($rs[attach] != ""){ $attach = "<a href=\"".$rs[attach]."\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; } else { $attach = "";}		
?>
                            <tr bgcolor="<?=$bg?>" align="center">
                              <td><?=$no?></td>
                              <td><?=daythai($rs[date_list])?></td>
                              <td align="left"><?="&nbsp;".$attach.$rs[detail]?></td>
                              <td><?=number_format($rs[cash],2)?></td>
                              <td><?=number_format($rs[cash_vat],2)?></td>
                              <td><?=number_format($rs[cash_total],2)?></td>
                              <td><?=number_format($rs[credit],2)?></td>
                              <td><?=number_format($rs[credit_vat],2)?></td>
                              <td><?=number_format($rs[credit_total],2)?></td>
                              <td>
							  <?
							  $res = mysql_query("select * from type_project");
							  while ($rss = mysql_fetch_assoc($res))
							  {
							  If ($rs[id_type_project] == $rss[id_type_project])
							  	{
							  		echo "$rss[code_project]";
							  	}else
								{
								echo "&nbsp;";
								}
							  }
							  
							  ?>
							  </td>
                              <td><?=$rs[no_ap]?></td>
                              <td><?=$rs[complete]?></td>
                              <td><a href="cost_add.php?runno=<?=$rs[runno]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runno=<?=$rs[runno]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                              <?
	} //while

// List Template
?>
                          </table>
						  <br>
						</td>

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

