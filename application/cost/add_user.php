<?
/*****************************************************************************
Function		: แก้ไขข้อมูลของ epm_staff
Version			: 1.0
Last Modified	: 16/8/2548
Changes		:
*****************************************************************************/
set_time_limit(0);
include ("checklogin.php");
include ("config/phpconfig.php");
$report_title = "บุคลากร";
$org_id = intval($org_id);
$epm_mode = "off";

function mk_username($ename,$esurname){
	$uname = strtolower($ename . "." . substr($esurname,0,3));
	$lastuname = $uname;
	$n = 3; $k=0;
	$SQL = "select userid from cost.cos_user where username='$uname' ";
	$Result_MK = mysql_query($SQL);
	if ( @mysql_num_rows($Result_MK) > '0' ){
		$n++;
		if (strlen($esurname) > $n){
			$uname = strtolower($ename . "." . substr($esurname,0,$n));
			$lastuname = $uname;
		}else{
			$k++;
			$uname = $lastuname . $k;
		} //if
	} // while
	return $uname;
}
$user_id = $_SESSION[userid_origin] ? $_SESSION[userid_origin] : $_SESSION[userid];
$id=($pri =='100')?$id : $user_id;

if ($_SERVER[REQUEST_METHOD] == "POST"){
		if ($action == "new"){
			$gen_username = mk_username($engname,$engsurname);
			$sql = "insert into cost.cos_user SET 
			`username`='$gen_username',
			`password`='logon',
			`name`='$staffname',
			`surname`='$staffsurname',
			`engname`='$engname',
			`engsurname`='$engsurname',
			`pri`='10' 
			";
			@mysql_query($sql);
			$id_insert= mysql_insert_id();
			$sql_acc="INSERT INTO cost.type_accrone SET
			`id_cost_accrone`='511013-$id_insert',
			`type_accrone`='ค่าเบี้ยเลี้ยง-$staffname',
			`id_type_cost`='5',
			`userid` = '$id_insert' ";
			@mysql_query($sql_acc);
			
			$sql_g = "insert into cost_gnis.cos_user SET 
			`username`='$gen_username',
			`password`='logon',
			`name`='$staffname',
			`surname`='$staffsurname',
			`engname`='$engname',
			`engsurname`='$engsurname',
			`pri`='10' 
			";
			@mysql_query($sql_g);
			$id_insert= mysql_insert_id();
			$sql_acc="INSERT INTO cost_gnis.type_accrone SET
			`id_cost_accrone`='511013-$id_insert',
			`type_accrone`='ค่าเบี้ยเลี้ยง-$staffname',
			`id_type_cost`='5',
			`userid` = '$id_insert' ";
			@mysql_query($sql_acc);
			
		}else if ($action == "edit"){
		
			$sql = "UPDATE cost.cos_user SET 
			`name`='$staffname',
			`surname`='$staffsurname',
			`password`='$password',
			`engname`='$engname',
			`engsurname`='$engsurname'
			WHERE userid = '$id'
			";
			@mysql_query($sql);
			$sql_g = "UPDATE cost_gnis.cos_user SET 
			`name`='$staffname',
			`surname`='$staffsurname',
			`password`='$password',
			`engname`='$engname',
			`engsurname`='$engsurname'
			WHERE username = '$username'
			";
			@mysql_query($sql_g);
		}
		//echo "<pre> $sql  <hr>";	print_r($_POST);	echo "</pre>"; die;
	echo "<script language='javascript'>alert('บันทึกข้อมูล $staffname แล้ว');</script>" ;

	if($pri =='100'){
	echo "<meta http-equiv='refresh' content='0;url=list_user.php'>" ;
	}else{
	echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;
	}
	die;
}
?>


<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	<? if($pri!="100"){?>
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	<? }?>
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
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

<body bgcolor="#EFEFFF">

<?
 if ($action == "edit" && $id){
	$sql = "Select  * FrOm cost.cos_user WHERE userid = '$id' limit 1 ";
	$result = @mysql_query($sql);
	$rs = mysql_fetch_assoc($result);
 }else{
	$action = "";		 
 }
?>

<form action="?" method="POST" NAME="form1" ONSUBMIT="Javascript:return (checkFields());">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>" >
<INPUT TYPE="hidden" NAME="step" VALUE="<?=$step?>" >
<INPUT TYPE="hidden" NAME="org_id" VALUE="<?=$org_id?>" >
<INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?$action:"new"?>"  >
<INPUT TYPE="hidden" NAME="xusername" VALUE="<?=$uname?>"  >
<INPUT TYPE="hidden" NAME="xpassword" VALUE="<?=$pwd?>"  >
<table border=0 align=center cellspacing=1 cellpadding=3 bgcolor="#DDDDDD" width="98%">
    <tr bgcolor="#a3b2cc"> 
      <td colspan=2> &nbsp; <FONT COLOR="WHITE" style="font-size:14pt;"><B><?=$title?>ข้อมูล<?=$report_title?></B></font></td>
    </tr>
<?

 if ($step == "confirm" ){	
?>
	<tr bgcolor="#EFEFFF" valign=top> <td width="31%" class="link_back"> Username </td>  <td width="69%"> <U><?=$uname?></U> </td> </tr>
	<tr bgcolor="#EFEFFF" valign=top> <td class="link_back"> Password </td>  <td> <U><?=$pwd?></U> </td> </tr>
	<tr bgcolor="#808080" height=10><td colspan=2></td>	</tr>
<?
}else if( $action == "edit"){
?>
	<tr bgcolor="#EFEFFF" valign=top> <td width="31%" class="link_back"> Username </td><td width="69%"> <U><?=$rs[username]?></U> </td> </tr>
	<tr bgcolor="#EFEFFF" valign=top> <td class="link_back"> Password </td>  <td> <INPUT TYPE="text" NAME="password" VALUE="<?=$rs[password]?>"  > </td> </tr>
	<tr bgcolor="#808080" height=10><td colspan=2></td>	</tr>
<?
}
?>
    <? if($epm_mode=="ON"){?>
	<tr bgcolor=white valign=top>
	  <td class="link_back">ตำแหน่ง(ระบบจะใช้ในการแสดงผล)</td>
	  <td><INPUT TYPE="text" NAME="title" VALUE="<?=$rs[title]?>" size="60" maxlength=200 class=inputbox <?=$lock?>></td>
    </tr>
    <? } ?>
    <? if($epm_mode=="ON"){?>
	<tr bgcolor=white valign=top> 
      <td class="link_back">คำนำหน้า (ไทย) </td>
      <td> 
        <INPUT TYPE="text" NAME="prename" VALUE="<?=$rs[prename]?>" size="30" maxlength=50 class=inputbox <?=$lock?>>      </td>
    </tr>
    <? } ?>

	<tr bgcolor=white valign=top> 
      <td class="link_back">ชื่อ (ไทย) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="staffname" VALUE="<?=$rs[name]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">นามสกุล (ไทย) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="staffsurname" VALUE="<?=$rs[surname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>
    <? if($epm_mode=="ON"){?>
	<tr bgcolor=white valign=top> 
      <td class="link_back">คำนำหน้า (อังกฤษ) </td>
      <td> 
        <INPUT TYPE="text" NAME="engprename" VALUE="<?=$rs[engprename]?>" size="30" maxlength=50 class=inputbox <?=$lock?>>      </td>
    </tr>
	<? }?>
	<tr bgcolor=white valign=top> 
      <td class="link_back">ชื่อ (อังกฤษ) <FONT COLOR="RED">*</FONT></td>
      <td> 
        <INPUT TYPE="text" NAME="engname" VALUE="<?=$rs[engname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">นามสกุล (อังกฤษ) <FONT COLOR="RED">*</FONT></td>
      <td>
        <INPUT TYPE="text" NAME="engsurname" VALUE="<?=$rs[engsurname]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>
    <? if($epm_mode=="ON"){?>
	<tr bgcolor=white valign=top> 
      <td class="link_back">เลขบัตรประจำตัว</td>
      <td><INPUT TYPE="text" NAME="card_id" VALUE="<?=$rs[card_id]?>" size="20" maxlength=30 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top> 
      <td class="link_back">Email Address</td>
      <td> <INPUT TYPE="text" NAME="email" VALUE="<?=$rs[email]?>" size="60" maxlength=200 class=inputbox <?=$lock?>>      </td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ประเภท</td>
	  <td>
	  <select name="sex" <?=$lock?> style="width:150px;">
<?
$sex_array = array("M"=>"ชาย","F"=>"หญิง", "O"=>"องค์กร");	
foreach ($sex_array as $sex=>$caption){
	if ($rs[sex] == $sex) $sel="SELECTED"; else $sel="";
	echo "<option value='$sex' $sel>$caption";
}
		?>
	  </select>	  </td>
</tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">ที่อยู่</td>
	  <td><TEXTAREA NAME="address" ROWS="3" COLS="60" <?=$lock?>><?=$rs[address]?></TEXTAREA></td>
    </tr>

	<tr bgcolor=white valign=top>
	  <td class="link_back">โทรศัพท์</td>
      <td> <INPUT TYPE="text" NAME="telno" VALUE="<?=$rs[telno]?>" size="60" maxlength=100 class=inputbox <?=$lock?>>      </td>
    </tr>


	<tr bgcolor=white valign=top>
	  <td class="link_back">หมายเหตุ</td>
	  <td><TEXTAREA NAME="comment" ROWS="3" COLS="60" <?=$lock?>><?=$rs[comment]?></TEXTAREA></td>
    </tr>
<? }?>
    <tr bgcolor="#888899" valign=top> 
      <td colspan=2 align=right> 
        <INPUT TYPE="submit" VALUE="    บันทึก    " CLASS=xbutton>
        <INPUT TYPE="button" VALUE=" กลับหน้าหลัก  " class=xbutton ONCLICK="<?=$pri=="100"?"location.href='list_user.php'":"window.close()"?>">	  </td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
