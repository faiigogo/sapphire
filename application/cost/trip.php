<?php
//include ("checklogin.php");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){

//if Action is edit and file is send remove old file and replace with new one
if($action == "edit"){
	if($file_name != ""){
		$xsql = mysql_query("select attach from `document` where id = '$id'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
		$xrs = mysql_fetch_assoc($xsql);
		if(file_exists($xrs[attach])){ unlink($xrs[attach]); }
	}
}

//echo "<br>".$file_name;
//echo "<br>".$file_size;
//echo "<br>".$file_type;
//Check file befor attach to server
if($file_name != "" ){

$file_name_gen = $tripid ."_". date("YmdHis") .".". str_replace(".","",substr($file_name,-4));
$filechk = "file_temp/".$file_name_gen;
if(file_exists($filechk)){ 

	$fn = split('[.]', $file_name);
	$f_name = $fn[0];	
	$f_ext = getFileExtension($file_name);
	$file_name_gen = $tripid ."_". date("YmdHis");
	$filename = "file_temp/".$file_name_gen."(1).".$f_ext;

} else {

	$filename = "file_temp/".$file_name_gen;
	
}

	if($file_size >= "2000000"){
	
		$msg = "<b class=warn>Warning</b><br>ขนาดของ file เกินจากที่กำหนดไว้ครับ<div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
		include("msg_box.php");		
		exit() ;
		
	} else {
	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){
	 
				$msg = "ไม่สมารถ upload ขึ้น server ได้<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
				include('msg_box.php');
				exit();		
			}
		unlink($file);  
		
		} else {
	
			$msg = "<font class=\"brown\">Can't upload this file</font><br>Folder ที่จะทำการบันทึกข้อมูลอาจจะยังไม่ได้กำหนดคุณลักษณะ<br>กรุณาตรวจสอบ CMOD ของ Folder<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
			include('msg_box.php');
			exit();
		
		}
	}

}


$start_project = swapdate($start_project);
$end_project = swapdate($end_project);
$datetrans = swapdate($getday);
			 if ($_POST[action]=="edit2")
			 {
				 
				$trip_stat = call_tripstatus($tripid);
				 
 				$clear_stat = $trip_stat == 3 ? "y":"";
				
			 	if($file_name != "" ){
				 $sql = "update tripvalue set appbudget = '$appbudget' , datetrans = '$datetrans' ,  attach = '$filename' ,note = '$note' , id_type_tripapp = '$id_type_tripapp' , endtrip = 'y' , cleartrip = '$clear_stat' where runid= '$runid'; ";
				} else {
 				 $sql = "update tripvalue set appbudget = '$appbudget' , datetrans = '$datetrans' ,  note = '$note' , id_type_tripapp = '$id_type_tripapp' , endtrip = 'y'   , cleartrip = '$clear_stat' where runid= '$runid'; ";
				}
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					header("Location: ?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname");
					exit;
				}
			}else
				{
				$trip_stat = call_tripstatus($tripid);
				
				$clear_stat = $trip_stat == 3 ? "y":"";
					
				$sql = "INSERT INTO  tripvalue (tripid,appbudget,datetrans,attach,note,id_type_tripapp,endtrip,cleartrip)	VALUES ('$tripid','$appbudget','$datetrans','$filename','$note','$id_type_tripapp','y','$clear_stat')";
					$result  = mysql_query($sql);
					if($result)
					{
						//header("Location: ?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname");
						echo"\n<script type=\"text/javascript\">";
						echo" window.location = \"?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname\" ";
						echo"</script>";	
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
}else if ($_GET[action] == 'delete')
	{
		mysql_query("delete from tripvalue where runid= $runid ");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			//header("Location: ?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname");
			echo"\n<script type=\"text/javascript\">";
			echo" window.location = \"?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname\" ";
			echo"</script>";	
			exit;
			}
}else
		{		
	 	$sql = "select * from  tripvalue   ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}
		?>
<html>
<head>
<title>ระบบลงทะเบียนเพื่อเข้าร่วมโครงการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="cost.css" type="text/css" rel="stylesheet">
<script language="javascript" src="libary/popcalendar.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {color: #000000}
.style2 {font-weight: bold}
-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function ch2(){
		var f1=document.form1;
		var x = document.getElementById('id_type_tripapp').value ;
		 if( x == "6"){
			if( document.getElementById('appbudget').value != document.getElementById('money_outside').value ){
				alert("ต้องโอนเงินคืนบริษัทจำนวน "+document.getElementById('money_outside').value+" บาท \nกรุณาตรวจสอบยอดเงินโอนเงินกับฝ่ายบัญชีอีกครั้ง!");
				return false;
			}
		}
	}

	function value_fixabled(){
		 //document.getElementById('appbudget').value = document.getElementById('money_outside').value;
		 //document.getElementById('appbudget').readOnly = true ;
		var x = document.getElementById('id_type_tripapp').value ;
		if(x == "6"){
				alert("ต้องโอนเงินคืนบริษัทจำนวน "+document.getElementById('money_outside').value+" บาท");
		}
	}
//-->

</SCRIPT>

<?
//refresh openner
if ($refreshpage){
?>	
<SCRIPT LANGUAGE="JavaScript">
<!--
opener.document.forms[0].submit();

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>
<?
}
?>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%"><B class="pheader">ป้อนงบประมาณอนุมัติ</B></td>
              <td width="85%"><B class="pheader"><?
				$sqls = "select * from trip where tripid = '$tripid' ";
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo "รหัส $rss[tripid] &nbsp;&nbsp; $rss[tripname]";
				
				$display = ($pri =='80' && $rss['userid'] != $_SESSION[userid])?' style="display:none" ':'';
				?>
				</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <?
 if ($_GET[action]!="edit2")
 {
?>
        <td valign="top" >
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">

          <tr bgcolor="#CACACA">
            <td width="862" bgcolor="#888888">&nbsp;</td>
            <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
              <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='list.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" >
              &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
          </tr>
        </table>
          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
            </tr>
          </table>
          <br>
          <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
              <tr bgcolor="#A3B2CC">
                <td><div align="center"><strong>ครั้งที่</strong></div></td>
                <td align="center"><strong>วันที่โอน</strong></td>
                <td align="center"><strong>จำนวนเงินที่อนุมัติ</strong></td>
                <td align="center"><strong>ประเภทการอนุมัติ</strong></td>
                <td align="center"><strong>หมายเหตุ</strong></td>
                <td><div align="center"><strong>เครื่องมือ</strong></div></td>
              </tr>
              <?php
		$i = 0;
		$no=0;
		$max=0;
		$result = mysql_query("select * from tripvalue where tripid = '$tripid'   ;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$i++;
			$no++;
		//	if ($rs[id_type_project] > $max) $max=$rs[id_type_project];
			
			if ($i % 2) {
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}
			
			$money_outside += ($rs[id_type_tripapp] == "1") ? $rs[appbudget] : "0";
			$money_outside += ($rs[id_type_tripapp] == "3") ? $rs[appbudget] : "0";
			$money_outside += ($rs[id_type_tripapp] == "4") ? $rs[appbudget] : "0";			
			
			if(file_exists($rs[attach])){ $attach = "<a href=\"$rs[attach]\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; }else{ $attach = ""; }
		?>
              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=$no?></td>
                <td align="center"><?=daythai($rs[datetrans])?></td>
                <td align="right"><?=$attach.number_format($rs[appbudget],2)?></td>
                <td align="left"><?
	$sqlfor = "select * from trip_approve where id_type_tripapp= '$rs[id_type_tripapp]' ";
	$resultfor = mysql_query($sqlfor);
	$rsfor = mysql_fetch_assoc($resultfor);
	echo $rsfor[type_trip_approve];	
	?></td>
                <td  align="left"><?=$rs[note]?></td>
                <td  align="center">
                <span <?=$display?>>
                <a href="?runid=<?=$rs[runid]?>&tripid=<?=$tripid?>&action=edit2&sname=<?=$sname?>&ssurname=<?=$ssurname?>"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; 
                <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runid=<?=$rs[runid]?>&tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> 
                </span>
                </td>
              </tr>
              <?
		}
		?>
            </table>
          <?
}
else if ($_GET[action]=="edit2")
{
		$sql = "select * from tripvalue where tripid='$tripid' and runid = '$runid' ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$start_project = swapdate($rs[start_project]);
 			$end_project = swapdate($rs[end_project]);
		}


}

?>
            <form name="form1"  method = POST  action = "<?=$PHP_SELF?>" enctype="multipart/form-data"  onSubmit="return ch2();">
              <INPUT TYPE="hidden" NAME="tripid" VALUE="<?=$tripid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <INPUT NAME="runid" TYPE="hidden" id="runid" VALUE="<?=$runid?>">
              <INPUT NAME="sname" TYPE="hidden" id="sname" VALUE="<?=$sname?>">
              <INPUT NAME="ssurname" TYPE="hidden" id="ssurname" VALUE="<?=$ssurname?>">
              <INPUT NAME="money_outside" TYPE="hidden" id="money_outside" VALUE="<?=$money_outside?>">
              <table width="80%" border="0" cellspacing="1" cellpadding="2" align="center" <?=$display?>>
                <tr>
                  <td colspan=3 align="left" valign="top" bgcolor="#888888"><B class="gcaption">
                    <?=($rs[id_type_project]!=0?"แก้ไข":"เพิ่ม")?>ข้อมูลTrip</B></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" width="20%">จำนวนเงินที่อนุมัติ</td>
                  <td align="left" valign="top" width="60%"><input name="appbudget" type="text" class="input_text" id="appbudget" value="<?=$rs[appbudget]?>" size="40">                  </td>
                </tr>
                <tr>
                  <td height="25" align="right" valign="top" class="textp style1">ประเภทการอนุมัติ</td>
                  <td height="25" valign="top" class="textp">                
                  <select name="id_type_tripapp" id="id_type_tripapp" onChange="value_fixabled(this)">
                    <option value=" "> </option>
                    <?
						$strSQL ="  select * from list  where tripid = '$tripid'  order by date_list   ";			
						$select_num  = mysql_query($strSQL);
						$NUM_TRIP_COST = @mysql_num_rows($select_num) ? @mysql_num_rows($select_num) : "0";
									
						$select1  = mysql_query("select  *  from  trip_approve;");
						while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){			
								$SELECTED =  ($rs[id_type_tripapp] == $rselect1[id_type_tripapp]) ? "SELECTED" : "";
								$OPTION2 = "<option value='$rselect1[id_type_tripapp]' $SELECTED >$rselect1[type_trip_approve]</option>";
								if( ($rselect1[id_type_tripapp] == "6" && $NUM_TRIP_COST < 1 ) OR ($rselect1[id_type_tripapp] != "6") ){
									echo $OPTION2;
								}
						}//end while
					?>
                  </select> <input type="button" name="btnNewcredit" value=" + " onClick="MM_openBrWindow('addtype_tripapp.php','','width=800,height=500')"></td>
                </tr>
                <tr>
                  <td height="25" align="right" valign="top" class="textp style1"><span class="style2 style2">วันที่</span>
                      <?
						   $d2=explode("-",$rs[datetrans]);			   
						   ?></td>
                  <td height="25" valign="top" class="textp"><span class="style2">
                    <input type="text" name="getday" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<? if($rs[datetrans] == ""){ echo date("d/m/").(date("Y") ); }else{ echo swapdate($rs[datetrans]); }?>" readonly>
                    <script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.getday, \"dd/mm/yyyy\")' value=' เลือกวัน ' class='input'>")	}</script>
                  </span></td>
                </tr>
                <tr>
                  <td height="25" align="right" valign="top" class="textp"><span class="style2"><span class="style1">แนบไฟล</span>์</span></td>
                  <td height="25" valign="top" class="textp"><input type="file" name="file" size="50" class="input" style="background-color:#ffffff;" value="<?=$rs[attach]?>"></td>
                </tr>
                <tr>
                  <td align="right" valign="top">หมายเหตุ</td>
                  <td align="left" valign="top"><textarea name="note" cols="70" rows="5" class="input_text" id="note"><?=$rs[note]?></textarea></td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="20%">&nbsp;</td>
                  <td align="left" valign="top" width="60%"><input type="submit" name="Submit" value=" บันทึก ">
                      <input type="reset" name="Submit2" value="Reset">
                      <input type="reset" name="Submit3" value="ยกเลิก" ONCLICK="<? if ($_GET[action] == "edit2") echo "location.href='?';"; else echo "window.close();"; ?>">                  </td>
                </tr>
              </table>
            </form>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
