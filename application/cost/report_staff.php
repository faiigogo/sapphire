<?
session_start();
include ("config/phpconfig.php");
include("cost/function.php");

//$debug = true;

$jump = ($jump == "" || !isset($jump)) ? date("d/m/Y") : $jump ; 
if($mode){$mode=1;}
$d 			= explode("-", swapdate($jump));
$mm	= add_zero($d[1]) - 1;
$mm_n    = $d[1];
$yy =  intval($d[0]);
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

if($id_type_cost==""){ $id_type_cost = 5;}
if($_GET[mode]==""){ $_GET[mode] = 1;}


// --------------- ถ้ามีการเลือกช่วงเวลา ---------------
if(($date1 =="") AND ($date2 =="")){
	if($_GET[jump]!=""){
	$datereport 	= " date_list LIKE '".($d[0])."-".add_zero($d[1])."-$d[2]%"."'";
	$monthreport = " SUBSTRING(date_list,1,7) LIKE '".($d[0])."-".add_zero($d[1])."'";
	$showtime = shortday(swapdate($_GET[jump]));
	}else{
	$datereport 	= " SUBSTRING(date_list,1,7) LIKE '".($d[0])."-".add_zero($d[1])."'";
	$monthreport = " SUBSTRING(date_list,1,7) LIKE '".($d[0])."-".add_zero($d[1])."'";
	$showtime = "เดือน ".$mname[intval($d[1])];
	}
}else{
if($_GET[mode]==1){
	$date_tmp1 = explode("-",$date1);
	$date1 = ($date_tmp1[0])."-$date_tmp1[1]-$date_tmp1[2]";
	$date_tmp2 = explode("-",$date2);
	$date2 = ($date_tmp2[0])."-$date_tmp2[1]-$date_tmp2[2]";
}
	$datereport 	= " date_list between '$date1' AND '$date2' ";
	$monthreport = " date_list between '$date1' AND '$date2' ";
	$showtime = shortday($date1)." - ".shortday($date2);
}

if($_GET[mode]==1){
	$sql	= "  SELECT SUM(cash_total) AS cash_total1 , SUM(credit_total) AS credit_total1,count(*) AS numcount , list.* , cos_user.*  
					FROM list INNER JOIN trip ON list.tripid = trip.tripid
					INNER JOIN cos_user ON trip.userid = cos_user.userid    " ;
	$sql	= $sql." WHERE  ($datereport)  AND (list.id_type_cost = '$id_type_cost')  ";
	$sql	= $sql."  GROUP BY cos_user.userid ";
	
 	$csql	= "  SELECT   *    FROM  list ";
	$csql	= $csql." where   (SUBSTRING(date_list,1,7) LIKE '$yy-$mm_n%') AND (list.id_type_cost = '$id_type_cost')    ";
	$csql	= $csql." order by  date_list  ";
	
}else{

	$sql	= "  SELECT cash_total , credit_total  , list.* , cos_user.*  
					FROM list INNER JOIN trip ON list.tripid = trip.tripid
					INNER JOIN cos_user ON trip.userid = cos_user.userid  " ;
	$sql	= $sql." WHERE  ($datereport)  AND (cos_user.userid ='$_GET[userid]') AND (list.id_type_cost = '$id_type_cost')  ";
	//$sql	= $sql."  GROUP BY list.userid ";
	
 	$csql	= "  SELECT   *    FROM  list ";
	$csql	= $csql." where   (SUBSTRING(date_list,1,7) LIKE '$yy-$mm_n%') AND (list.userid ='$_GET[userid]') AND (list.id_type_cost = '$id_type_cost')    ";
	$csql	= $csql." order by  date_list  ";

}

//$debug=true;
if($debug){
	echo "Report  <br> $mode	<hr>";
	echo "Report  <br> $sql	<hr>";
	echo "Report  <br> $csql	<hr>";
}	

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title></title>
<link href="style.css" rel="stylesheet">
<script language='javascript' src='popcalendar.js'></script>
<script language="javascript">
function showAct(epmid, jump) {
	
	var rnd		= "rnd=" + Math.random();
	var value	= rnd + "&epmid=" + epmid + "&jump=" + jump ;
	var txt		= "<table width='200' border='0' cellspacing='1' cellpadding='0' align='center' bgcolor='#404040'>";
	txt += "<tr align='center' bgcolor='#eeeeee'><td height='30' bgcolor='#ffffff'><img src=\"images/indicator_roll.gif\" align=\"absmiddle\">";
	txt += "&nbsp;Loading...</tr></td></table>";
	document.getElementById("Activities").innerHTML= txt;

 	xmlHttp.open('POST', 'calendar_showact.php', true); 
    xmlHttp.onreadystatechange = function() { 
         if (xmlHttp.readyState==4) {
              if (xmlHttp.status==200) { document.getElementById("Activities").innerHTML = xmlHttp.responseText }
         }
    };
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlHttp.send(value); 
}

function CheckForm(){
	missinginfo = "";
	missinginfo1 = "";
	if ((document.form.id_type_cost.value == "")){ 	
			missinginfo1 += "\n- กรุณาเลือกหมวดค่าใช้จ่าย ";  		
	}	

	
	if ((document.form.date1.value == "") || (document.form.date2.value == "")){ 	
			missinginfo1 += "\n- กรุณาเลือกวันที่เริ่มและวันที่สิ้นสุดให้ครบ ";  		
	}	
	
	if ((document.form.date1.value  > document.form.date2.value )){ 	
		missinginfo1 += "\n- คุณกำลังเลือกช่วงเวลาผิด  !  ";  		
	}	
	
		
	if (missinginfo1 != "") { 	
		missinginfo += "ไม่สามารถประมวลผลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
	}
	
}
</script>
</head>
<body bgcolor="#A5B2CE">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px;">
  <tr>
   <td align="center" bgcolor="#000066" class="fillcolor" style="padding:3px;">
     <form name="form" method="post" action="?" onSubmit="return CheckForm();">
    <span class="plink">
<select name="id_type_cost" id="id_type_cost" >
  <option value=""> --กรุณาเลือกหมวดค่าใช้จ่าย-- </option>
  <?
		$select1  = mysql_query("select  * from type_cost;");
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			if ($rselect1[id_type_cost] == $id_type_cost){ 			
				echo "<option value='$rselect1[id_type_cost]' SELECTED>$rselect1[type_cost]</option>";
			}else{
				echo "<option value='$rselect1[id_type_cost]' >$rselect1[type_cost]</option>";
			}
		}//end while

?>
</select>    
วันที่เริ่มต้น</span>&nbsp;        
    <INPUT NAME="date1" TYPE="text" id="date1" size="15" value="<?=$date1?>">
    <input type=button onclick='popUpCalendar(this, this.form.date1, "yyyy-mm-dd");' value='V' style='font-size:11px'>
    <span class="plink">วันที่สิ้นสุด</span>&nbsp;&nbsp;
        <input type="text" name="date2" size="15" value="<?=$date2?>">
        <input type=button onClick='popUpCalendar(this, this.form.date2, "yyyy-mm-dd");' value='V' style='font-size:11px'>
        <input type="submit" name="button" id="button" value=" แสดงผล ">
     </form>    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr valign="top">
    <td width="18%" height="102" align="center"><? include("calendar.php"); ?>	</td>
	<td width="82%">
<? if($_GET[mode]==1){?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#404040">
<tr bgcolor="#A0A0A0"> 
	<td height="20" colspan="6" class="headerTB">&nbsp;รายงานสรุปตามหมวด
	  <?
	  	$select1  = mysql_query("select  * from type_cost where id_type_cost = '$id_type_cost' ;");
		$rselect1=mysql_fetch_assoc($select1);
		echo "$rselect1[type_cost]";
	  ?>
	: 
	  <?=$showtime?></td>
</tr>
<tr valign="middle">
  <td rowspan="2" align="center" bgcolor="#5C85EF"><strong>ลำดับ</strong></td>
  <td rowspan="2" align="center" bgcolor="#5C85EF"><strong>ชื่อ</strong></td>
  <td rowspan="2" align="center" bgcolor="#5C85EF"><strong>จำนวนรายการ (รายการ)</strong></td>
  <td height="19" colspan="3" align="center" bgcolor="#5C85EF"><strong>จำนวนเงิน (บาท)</strong></td>
  </tr>
<tr valign="middle">
  <td height="19" align="center" bgcolor="#5C85EF">เงินสด</td>
  <td align="center" bgcolor="#5C85EF">เครดิต</td>
  <td align="center" bgcolor="#5C85EF">รวม</td>
  </tr>

<?
$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " error".mysql_error());
$n=1;
while($rs = mysql_fetch_assoc($result)){
// ---------------------------------------------------------------
$sum_numcount += $rs[numcount] ;
$sum_cash_total += $rs[cash_total1] ;
$sum_credit_total += $rs[credit_total1] ;
//----------------------------------------------------------------
$userData = getUser($rs['tripid']);
$bgcolor = ($bgcolor == "#ffffff") ? "#f8f8f8" : "#ffffff";
?>	
<tr valign="top" bgcolor="<?=$bgcolor?>" onmouseover='mOvr(this,"B5D1FF");' onmouseout='mOut(this,"<?=$bgcolor?>");'
<? /*onClick="showAct('<?=$rs[epm_id]?>','<?=$jump?>');" */ ?>>
  <td width="5%" align="center"><?=$n?></td>
    <td width="40%" height="20">&nbsp;<a href="?mode=2&jump=<?=$jump?>&date1=<?=$date1?>&date2=<?=$date2?>&userid=<?=$userData[userid]?>&id_type_cost=<?=$id_type_cost?>"><? echo  "$userData[name]  $userData[surname]";?></a></td>
	<td width="17%" align="center"><? echo  "$rs[numcount]";?>&nbsp;</td>
	<td width="18%" align="right"><? echo  number_format($rs[cash_total1],2);?></td>
	<td width="20%" align="right"><? echo  number_format($rs[credit_total1],2);?></td>
	<td width="20%" align="right"><? echo  number_format($rs[cash_total1]+$rs[credit_total1],2);?>&nbsp;</td>
	</tr>
<?
$n++;
} // end  for 
?>
<tr valign="top">
  <td align="center" bgcolor="#5C85EF">&nbsp;</td>
  <td height="18" align="right" bgcolor="#5C85EF"><strong>รวม&nbsp;</strong></td>
  <td align="center" bgcolor="#5C85EF"><strong><? echo  $sum_numcount;?>&nbsp;</strong></td>
  <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_cash_total,2);?></strong></td>
  <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_credit_total,2);?></strong></td>
  <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_cash_total+$sum_credit_total,2);?>&nbsp;</strong></td>
  </tr>
</table>
<? }else{ ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#404040">
  <tr bgcolor="#A0A0A0">
    <td height="20" colspan="8" class="headerTB">&nbsp;รายงานสรุปตามหมวด
      <?
	  	$select1  = mysql_query("select  * from type_cost where id_type_cost = '$id_type_cost' ;");
		$rselect1=mysql_fetch_assoc($select1);
		echo "$rselect1[type_cost]";
	  ?>
      :
      <?=$showtime?></td>
  </tr>
  <tr valign="middle" class="index1">
    <td rowspan="2" align="center" bgcolor="#5C85EF"><strong>ลำดับ</strong></td>
    <td rowspan="2" align="center" bgcolor="#5C85EF">TripID</td>
    <td rowspan="2" align="center" bgcolor="#5C85EF"><strong>ชื่อ</strong></td>
    <td rowspan="2" align="center" bgcolor="#5C85EF">รายละเอียด</td>
    <td rowspan="2" align="center" bgcolor="#5C85EF">วันที่บันทึก</td>
    <td height="19" colspan="3" align="center" bgcolor="#5C85EF"><strong>จำนวนเงิน (บาท)</strong></td>
    </tr>
  <tr valign="middle" class="index1">
    <td height="19" align="center" bgcolor="#5C85EF">เงินสด</td>
    <td align="center" bgcolor="#5C85EF">เครดิต</td>
    <td align="center" bgcolor="#5C85EF">รวม</td>
  </tr>
  <?
$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " error".mysql_error());
$n=1;
while($rs = mysql_fetch_assoc($result)){
// ---------------------------------------------------------------
$sum_numcount += $rs[numcount] ;
$sum_cash_total += $rs[cash_total] ;
$sum_credit_total += $rs[credit_total] ;
//----------------------------------------------------------------

if($rs[attach] != ""){ 
	$attach = "<a href=\"".$rs[attach]."\"  target=\"_blank\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; 
} else { 
	$attach = "";
}		

$userData = getUser($rs['tripid']);

$bgcolor = ($bgcolor == "#ffffff") ? "#f8f8f8" : "#ffffff";
?>
  <tr valign="top" bgcolor="<?=$bgcolor?>" onmouseover='mOvr(this,"B5D1FF");' onmouseout='mOut(this,"<?=$bgcolor?>");'
<? /*onClick="showAct('<?=$rs[epm_id]?>','<?=$jump?>');" */ ?>>
    <td width="4%" align="center"><?=$n?></td>
    <td width="7%"><? echo  $rs[tripid];?></td>
    <td width="13%" height="20">&nbsp;<? echo  "$userData[name]  $userData[surname]";?></td>
    <td width="36%"><? echo  $attach."  ".$rs[detail];?></td>
    <td width="18%" align="center"><? echo  shortday($rs[date_list]);?></td>
    <td width="11%" align="right"><? echo  number_format($rs[cash_total],2);?></td>
    <td width="11%" align="right"><? echo  number_format($rs[credit_total],2);?></td>
    <td width="11%" align="right"><? echo  number_format($rs[credit_total]+$rs[credit_total],2);?>&nbsp;</td>
  </tr>
  <?
$n++;
} // end  for 
?>
  <tr valign="top">
    <td height="18" colspan="5" align="center" bgcolor="#5C85EF"><strong>รวม&nbsp;</strong></td>
    <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_cash_total,2);?></strong></td>
    <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_credit_total,2);?></strong></td>
    <td align="right" bgcolor="#5C85EF"><strong><? echo  number_format($sum_credit_total+$sum_credit_total,2);?>&nbsp;</strong></td>
  </tr>
</table>
<? } // end mode?>
<br></td>
</tr>
</table>
<BR>
</body>
</html>