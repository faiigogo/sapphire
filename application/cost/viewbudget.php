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

$filechk = "file_temp/".$file_name;
if(file_exists($filechk)){ 

	$fn = split('[.]', $file_name);
	$f_name = $fn[0];	
	$f_ext = getFileExtension($file_name);
	$filename = "file_temp/".$f_name."(1).".$f_ext;
	
} else {

	$filename = "file_temp/".$file_name;
	
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
			 	if($file_name != "" ){
				 $sql = "update tripvalue set appbudget = '$appbudget' , datetrans = '$datetrans' ,  attach = '$filename' ,note = '$note' , id_type_tripapp = '$id_type_tripapp'  where runid= '$runid'; ";
				} else {
 				 $sql = "update tripvalue set appbudget = '$appbudget' , datetrans = '$datetrans' ,  note = '$note' , id_type_tripapp = '$id_type_tripapp'  where runid= '$runid'; ";
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
				$sql = "INSERT INTO  tripvalue (tripid,appbudget,datetrans,attach,note,id_type_tripapp)	VALUES ('$tripid','$appbudget','$datetrans','$filename','$note','$id_type_tripapp')";
					$result  = mysql_query($sql);
					if($result)
					{
						header("Location: ?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname");
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
			header("Location: ?tripid=$tripid&action=edit&refreshpage=1&sname=$sname&ssurname=$ssurname");
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
		if (!f1.code_project.value){
		alert("กรุณาระบุรหัสโครงการ");
			return false;
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
//-->
</SCRIPT>
<?
}
?>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%"><B class="pheader">งบประมาณอนุมัติ</B></td>
              <td width="85%"><B class="pheader"><?
				$sqls = "select * from trip where tripid = '$tripid' ";
				//echo $sqls;
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo "รหัส $rss[tripid] &nbsp;&nbsp; $rss[tripname]";
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
        <td valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">

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
              </tr>
              <?php
		$i = 0;
		$no=0;
		$max=0;
		$str = " select * from tripvalue where tripid = '$tripid' ";
		//echo "<hr> $str";
		$result = mysql_query($str);
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
            </form>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
