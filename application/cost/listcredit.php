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
	header("Location: list.php?tripid=$tripid");
	exit;
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

        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='list.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
                          </tr>
                        </table>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#A3B2CC">
                            <tr>
                              <td width="30%" align="right"><span class="style2"><a href="listtrip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><span class="style9"><u>TripID</u></span></a></span></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF"><span class="style2">
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
                              <td width="30%" align="right"><strong>ช่วงเวลาออกพื้นที่ปฏิบัติงาน</strong></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF"><?
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
							  ?></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><span class="style9"><strong>งบประมาณที่ได้รับอนุมัติ </strong></span></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><span class="style2">
                                <?
				$sqls = "select sum(appbudget) as app from tripvalue  where (tripid = '$tripid')   ";
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
				If ($pri =='100')
				{
				$sqls = "select sum(cash_total) as cash_total,sum(credit_total) as credit_total  from list  where tripid = '$tripid'  and credit_check ='1' ";
				}else
				{
				$sqls = "select sum(cash_total) as cash_total,sum(credit_total) as credit_total  from list  where tripid = '$tripid'  and userid= '$_SESSION[userid]' and credit_check ='1' ";
				}
				$res = mysql_query($sqls);
				$resc = mysql_fetch_assoc($res);
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
                                <?=number_format($resc[cash_total]+$resc[credit_total],2);?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                          </table>
                          <br>
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="50%" height="25"><strong>รายการค่าใช้จ่ายประเภทบัตรเครดิต</strong></td>
                            </tr>
                          </table>
                          <table width="98%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#000000">
                            <tr>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=date_list&tripid=<?=$tripid?>">วันที่</a></strong></td>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                              <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนเงินCREDIT</strong></td>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><a href="?<?=$getstr?>sortfield=id_type_credit&tripid=<?=$tripid?>">ประเภทบัตร</a></td>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=id_type_cost&tripid=<?=$tripid?>">หมวดค่าใช้จ่าย</a></strong></td>
                              <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=complete&tripid=<?=$tripid?>">BILL</a></strong></td>
                              <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="center" bgcolor="#A3B2CC"><strong>มูลค่า</strong></td>
                              <td align="center" bgcolor="#A3B2CC"><strong>Vat7%</strong></td>
                              <td align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
                              <td align="center" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr><?
	$i=0;
	$no=0;
	If  ($pri == '100')
	{
	
		If ($sortfield == "")
		{
			$str = "select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. credit_check='1')  order by date_list  ";
		}
		else
		{
		$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. credit_check='1')  order by $sortfield $sort   ";
		}
	}else
	{
		If ($sortfield == "")
		{
			$str = "select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. credit_check='1') and (t1.userid = '$userid') order by date_list  ";
		}
		else
		{
		$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where (t1.tripid = '$tripid') and (t1. credit_check='1') and (t1.userid = '$userid') order by $sortfield $sort   ";
		}
		
	}// end if privilage
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
							  <tr>
                              <td align="center" bgcolor="<?=$bg?>"><?=$no?></td>
                              <td align="center" bgcolor="<?=$bg?>"><?=daythai($rs[date_list])?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?="&nbsp;".$attach.$rs[detail]?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_vat],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_total],2)?></td>
                              <td align="center" bgcolor="<?=$bg?>"><?
							  $res = mysql_query("select * from type_credit");
							  while ($rss = mysql_fetch_assoc($res))
							  {
							  If ($rs[id_type_credit] == $rss[id_type_credit])
							  	{
							  		echo "$rss[type_credit]";
							  	}
							  }
							  
							  ?></td>
                              <td align="center" bgcolor="<?=$bg?>"><?
							  $res = mysql_query("select * from type_cost");
							  while ($rss = mysql_fetch_assoc($res))
							  {
							  If ($rs[id_type_cost] == $rss[id_type_cost])
							  	{
							  		echo "$rss[type_cost]";
							  	}
							  }
							  
							  ?></td>
							  <td align="center" bgcolor="<?=$bg?>">
							  							  <?
							  If ($rs[complete] =="y")
							  {
							  	echo "<img src=\"bimg/yy.png\" >";
							  }elseif ($rs[complete] =="n")
							  {
							  	echo  "<img src=\"bimg/alert.gif\" >";
							  }
							  ?></td>
                              <td bgcolor="<?=$bg?>">
							  <? If ($rs[close]=="y")
							  {
							  	echo "ไม่สามารถแก้ไขได้";
								}else
								{
								?> 
							  <a href="cost_add.php?runno=<?=$rs[runno]?>&tripid=<?=$tripid?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>
							  	<?
								}  //end if check close trip
								?>						  
							  </td>
                            </tr>
                              <?
	} //while

// List Template
?>
                          </table>
						  <p>&nbsp;</p>
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
                        </table>					      <p>&nbsp;  </p></td>

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

