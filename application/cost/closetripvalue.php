<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

//$date_tripvalue = $getyear.'-'.$getmonth.'-'.$getday;
if ($action == "delete"){
	$xsql = mysql_query("select attach from `tripvalue` where runid = '$runid'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$xrs = mysql_fetch_assoc($xsql);
	if(file_exists($xrs[attach])){ unlink($xrs[attach]); }

	$sql = mysql_query("delete from tripvalue where runid = '$runid' ")or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
	$msg = "<b class='blue'>Complete</b><br>ลบข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	header("Location: tripvalue.php?tripid=$tripid");
	exit;
}
if ($_SERVER[REQUEST_METHOD] == "POST"){
		 if ($action =="close")
		 {
		 		Foreach ($checkbox as $key => $id){
					if ($close > ""){
						$sql = "update tripvalue  set close = 'y' where runid = $id ";
					}else{
						$sql = "update tripvalue  set close = '' where runid = $id ";
					}
					@mysql_query($sql);
					//echo $sql."<br>";
					$tripvalue_arr[] = $id;
					$tripvalue_check = "ON";
				}
				
				if( $tripvalue_check == "ON" ){
					$no_tripvalue = implode( "," , $tripvalue_arr);
					echo $strSQL = " SELECT * from tripvalue where runid in ($no_tripvalue) group by tripid";
					$result_runidX = @mysql_query($strSQL);
					while($result_runid = mysql_fetch_assoc($result_runidX)){
						$tripid_array[$result_runid[tripid]]=$result_runid[tripid];
						trip_status($result_runid[tripid]);
					}			
				}
				
				//echo "<pre>";		print_r($_POST);		echo "</pre>";
				
				//die;
				
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					//header("Location: ?tripid=$tripid");
					echo "<meta http-equiv='refresh' content='0;url=?tripid=$tripid'>" ;
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

<title>ระบบลงทะเบียนเพื่อเข้าร่วมโครงการ</title>

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

 function CheckAll()
{
count = document.forms[0].elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.forms[0].elements[i].checked == 1)
    	{document.forms[0].elements[i].checked = 0; }
    else {document.forms[0].elements[i].checked = 1;}
	}
}
function UncheckAll(){
count = document.forms[0].elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.forms[0].elements[i].checked == 1)
    	{document.forms[0].elements[i].checked = 0; }
    else {document.forms[0].elements[i].checked = 1;}
	}
}



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
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='tripvalue.php?tripid=<?=$tripid?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>-->
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
                              <td width="30%" align="right"><span class="style2"><a href="tripvaluetrip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><span class="style9"><u>TripID</u></span></a></span></td>
                              <td width="25%" align="center" bgcolor="#FFFFFF"><span class="style2">
                                <?
				$sqls = "select * from trip where tripid = '$tripid' ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo "$rss[tripid] ";
				$display = ($pri =='80' && $rss['userid'] != $_SESSION[userid])?' style="display:none" ':'';
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
							  if($rsd[mindate] || $rsd[maxdate]){
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
				$sqls = "select sum(appbudget) as app from tripvalue  where (tripid = '$tripid')  ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo number_format($rss[app],2);
				?>
                              </span></td>
                              <td bgcolor="#A3B2CC"><strong>บาท </strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>งบประมาณที่ใช้จริง - <a href="tripvaluecash.php?mode=total&tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">เงินสด</a> </strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><span class="style2">
                                <?
				$sqls = "select sum(cash_total) as cash_total,sum(credit_total) as credit_total  from list  where tripid = '$tripid'   ";
				$res = mysql_query($sqls);
				$resc = mysql_fetch_assoc($res);
				echo number_format($resc[cash_total],2);
				$act = $resc[cash_total] ;
				?>
                              </span></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>- <a href="tripvaluecredit.php?mode=total&tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>">เครดิต</a> </strong></td>
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
                            <tr>
                              <td width="30%" align="right"><strong>คงเหลือ</strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><strong>
                                <?
							  $remain = $rss[app] - $act;
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
                              <td width="20%"><a href="closetrip.php?tripid=<?=$tripid?>">ตรวจเช็ครายการค่าใช้จ่าย</a></td>
                              <td><a href="trip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><img src="bimg/plus.gif" width="20" height="20" border="0"> &nbsp;ทำรายการขออนุมัติงบประมาณ</a></td>
                              <td>
                              <span <?=$display?>>
							  <?
							  $scheckend = "select * from tripvalue where tripid = '$tripid' and endtrip = 'y' ";
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
							  ?>
                              </span>
                              </td>
                              <td>
                              <span <?=$display?>>
                              <a href="#" onClick="if (confirm('คุณต้องการปิดการเดินทางนี้!!')) location.href='?action=endtrip&runid=<?=$rs[runid]?>&tripid=<?=$tripid?>';" ><img src="bimg/plus.gif" width="20" height="20" border="0"> ปิดการเดินทาง</a>
                              </span>
                              </td>
                            </tr>
                          </table>
                          <form  name ="form1" method = POST  action = "?action=close"   >
						  
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="50%"><INPUT TYPE="hidden" NAME="tripid" VALUE="<?=$tripid?>">
							  <?
							  If ($remain == '0')
							  {
							  ?>
                              <input type="checkbox" name="checkbox2" value="checkbox" onClick="CheckAll()"> 
                              เลือกทั้งหมด</td>
							  <?
							  $c = 1;
							  }else
							  {
							  echo " ไม่สามารถปิดรายการได้ ";
							   $c = 0;
							  }
							  ?>
                              <td><a href="trip.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>"></a></td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                          <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                            <tr bgcolor="#A3B2CC" align="center">
                              <td width="5%" rowspan="2">เลือกรายการ</td>
                              <td width="5%" rowspan="2"><strong>ลำดับ</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=date_tripvalue&tripid=<?=$tripid?>">วันที่</a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>จำนวนเงิน</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>ประเภทการอนุมัติ<a href="?<?=$getstr?>sortfield=id_type_project&tripid=<?=$tripid?>"></a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=complete&tripid=<?=$tripid?>">BILL</a></strong></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td>&nbsp;</td>
                            </tr>
                            
    <?
	$i=0;
	$no=0;

	$str = " select *  from tripvalue  where tripid = '$tripid' ; ";

	
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
		If ($rs[close] == "y" )
		{
		$bg = "#8090ff";
		}
if($rs[attach] != ""){ $attach = "<a href=\"".$rs[attach]."\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; } else { $attach = "";}		
?>
                            <tr bgcolor="<?=$bg?>" align="center">
                              <td width="5%"><label>
                                <input type="checkbox" name="checkbox[]" value="<?=$rs[runid]?>"  <? if ($c =="0") echo "disabled";?>>
                              </label></td>
                              <td width="5%"><?=$no?></td>
                              <td bgcolor="<?=$bg?>"><?=daythai($rs[datetrans])?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?="&nbsp;".$attach.$rs[attach]?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[appbudget],2)?></td>
                              <td bgcolor="<?=$bg?>">
							  <?
	$sqlfor = "select * from trip_approve where id_type_tripapp= '$rs[id_type_tripapp]' ";
	$resultfor = mysql_query($sqlfor);
	$rsfor = mysql_fetch_assoc($resultfor);
	echo $rsfor[type_trip_approve];	
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
                              <td bgcolor="<?=$bg?>">
                              <span <?=$display?>>
                              <a href="cost_add.php?runid=<?=$rs[runid]?>&tripid=<?=$tripid?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runid=<?=$rs[runid]?>&tripid=<?=$tripid?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>
                              </span> 
                              </td>
                              <?
					} //while

						// tripvalue Template
				if(mysql_num_rows($result)>0){
					?>
                           <tr bgcolor="#CCCCCC"" align="center">
                              <td colspan="4"><strong>รวม</strong></td>
                              <td align="right" ><strong>
                                <?=number_format($sum_cash+$sum_credit,2)?>
                              </strong></td>
                              <td colspan="3" >&nbsp;</td>                              
                            </tr>	
						<?
						}else{
						?>
                           <tr bgcolor="#CCCCCC"" align="center">
                              <td colspan="8"><strong>ไม่มีข้อมูล</strong></td>                         
                            </tr>						
						<?					
						}
						?>			
                          </table>
						  <br>
						  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                            <tr valign="middle">
                              <td align="right" width="290" height="32">&nbsp;&nbsp;</td>
                              <td align="right" width="300" height="32">
                              <span <?=$display?>>
                              <input name="open" type="submit" id="open" value="เปิดรายการ">
                              &nbsp;&nbsp;
                              <input name="close" type="submit" id="close" value="ปิดรายการ">
                              </span>
                              &nbsp; &nbsp;&nbsp;</td>
                            </tr>
                          </table>
						  </form>
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

