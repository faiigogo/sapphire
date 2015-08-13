<?
session_start();
include ("config/phpconfig.php");
include ("libary/upload.inc.php");

$table	= "attach";
$folder	= "attach/";

if($tripid == ""){

	$msg = "<div align='center'>ไม่พบข้อมูล Tripid ที่ส่งมา</div>";
	include_once("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=addtrip.php'>" ;
	exit;
	
} else {

	$nquery 	= mysql_query(" select tripname from `trip` where tripid='".$tripid."' ; ")or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
	$rss 			= mysql_fetch_assoc($nquery);
	$tripname	= $rss[tripname];
	mysql_free_result($nquery);
	
}

//Delete File
if($action == "del"){

	$sql	= " select attach from `$table` where tripid='$tripid' and no='$no' ;";
	$del 	= mysql_query($sql)or die("<br>Query line " . __LINE__ . " Error<hr>".mysql_error());
	$xrs 	= mysql_fetch_assoc($del);
	if(file_exists($folder.$xrs[attach]) && $xrs[attach] != "") { unlink($folder.$xrs[attach]);}
	
	$sql	= " delete from `$table` where tripid='$tripid' and no='$no' ;";
	$del	= mysql_query($sql)or die("<br>Query line " . __LINE__ . " Error<hr>".mysql_error());
	$msg	= "<div align='center'>ลบข้อมูลเรียบร้อยแล้ว</div>";
	include_once("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=$PHP_SELF?tripid=$tripid'>" ;
	exit;
	
}

if($_SERVER[REQUEST_METHOD] == "POST"){ 
if($action == "upload"){
/*
if($file_name != ""){
	$sql		= " select attach from `$table` where tripip = '$tripip' and no = '$no' ";
	$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());	
	$row 	= mysql_num_rows($result);
	$rs 		= mysql_fetch_assoc($result);	
	$image 	= $folder.$rs[location];	
	if($rs[location] != "" && file_exists($image)){ unlink($image); }	
	mysql_free_result($result);
} 
*/

$file			= $_FILES['file']['tmp_name'];
$file_name	= $_FILES['file']['name'];
$upload		= upload($folder, $file, $file_name, "all");		
$msg 		= upload_status($upload[0]);
if($msg != ""){
	require_once('msg_box.php');		
	exit;
}	

$sql		= " select max(no) as no from `$table` where tripid = '".$tripid."'; ";
$result	= mysql_query($sql)or die(" line ". __LINE__ . " error<hr>".mysql_error());
$rs		= mysql_fetch_assoc($result);
$max		= (intval($rs[no]) <= 0) ? 1 : ($rs[no] + 1);
mysql_free_result($result);
unset($sql,$rs);

/*
if($row == 0){ 
	$sql = " insert into `$table` set attach = '".$upload[1]."', description='".$description."', no = '".$max."', tripid = '".$tripid."'; ";
} else {		
	$sql = " update `$table` set attach = '".$upload[1]."', description='".$description."' where no = '".$no."' and tripid = '".$tripid."'; ";			
}
*/
	$sql 		= " insert into `$table` set attach = '".$upload[1]."', description='".$description."', no = '".$max."', tripid = '".$tripid."'; ";
	$query 	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$msg 	= "<b class='blue'>Complete</b><br>บันทึกข้อมูลเรียบร้อยแล้ว";
	include("msg_box.php");
	echo "<meta http-equiv='refresh' content='2;url=?tripid=$tripid'>" ;
	exit;

}}
?>
<html>
<head>
<title>แนบไฟล์</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="libary/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function sendVal(){

	 if(document.post.file.value.length == 0){
		alert(" โปรดระบุ file ที่จะทำการ upload ");
		document.post.file.focus();
		return false;	
	}
		document.post.action.value = "upload";	
		document.post.submit();
		return true;	
		
}
</script>
</head>
<body><br><br>
<? if($action=="new"){ ?>
<form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();" enctype="multipart/form-data">
<table width="602" border="0" cellspacing="0" cellpadding="0" align="center" class="frame">
<tr><td>
<table width="600" border="0" align="center"cellpadding=2 cellspacing=0 bgcolor="black">
<tr bgcolor="#dddddd" class="normal">
	<td height="20" colspan="2">&nbsp;<b><?=$title?>&nbsp;Upload ข้อมูล trip :</b> <font class="normal_blue"><?=$tripname?></font></td>
</tr>
<tr bgcolor="#EFEFEF">
	<td height="20" colspan="2">&nbsp;
	<input type="hidden" name="tripid" value="<?=$tripid?>">
	<input type="hidden" name="action">	</td>
</tr>
<tr bgcolor="#EFEFEF">
	<td width="171" height="20" align="right">เลือกไฟล์&nbsp;<b>:</b>&nbsp;</td>
	<td width="421"><input type="file" name="file" style="width:300px;" class="input"></td>
</tr>
<tr bgcolor="#EFEFEF">
	<td colspan="2" height="5"></td>    
</tr>
<tr bgcolor="#EFEFEF" valign="top">
	<td height="20" align="right">รายละเอียด&nbsp;<b>:</b>&nbsp;</td>
    <td><textarea name="description" class="input" style="width:300px; height:100px;"></textarea></td>
</tr>
<tr bgcolor="#EFEFEF">
	<td colspan="2" height="5"></td>    
</tr>
<tr bgcolor="#dddddd" align="center">
	<td height="20" colspan="2">
	<button style="width:100px;" onClick="sendVal()">บันทึกข้อมูล</button> 
	<button style="width:100px;" onClick="history.back();">ยกเลิก</button>	</td>
</tr>
</table>
</td></tr>
</table>
</form>
<? } else { ?>
<table width="90%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#EFEFEF">
	<td height="20" colspan="4">&nbsp;<a href="addtrip.php"><img src="bimg/profile_collapsed.gif" border="0"> กลับหน้าหลัก</a>
	> เพิ่มไฟล์แนบของรายการ <b>:</b> <font color="#003399"><?=$tripname?></font></td>
</tr>
<tr bgcolor="#dddddd">
	<td width="60" height="20" align="center"><b>ลำดับที่</b></td>
    <td width="144">&nbsp;<b>ชื่อไฟล์</b></td>
    <td width="502">&nbsp;<b>รายละเอียด</b></td>
    <td width="151" align="center">ลบไฟล์</td>
</tr>
<?
$i 			= 0;
$sql		= " select * from `$table` where tripid='".$tripid."'; ";
$result 	= mysql_query($sql)or die("Query line " . __LINE__ . " Error<hr>".mysql_error());

while($rs = mysql_fetch_assoc($result)){

	$i 		= $i + 1;
	$del 	= "<a href=\"?action=del&tripid=".$rs[tripid]."&no=".$rs[no]."\" style=\"text-decoration:none;\" ";
	$del	= $del."onClick=\"return confirm('ท่านต้องการที่จะลบข้อมูลนี้ ใช่หรือไม่ ?');\">";
	$del	= $del."<img src=\"bimg/b_drop.png\" height=\"16\" width=\"16\" border=\"0\" align=\"absmiddle\" alt=\"ลบข้อมูล\"></a>";		
?>
<tr bgcolor="#EFEFEF" valign="top">
	<td height="20" align="center"><?=$i?></td>
    <td>&nbsp;<?="<a href=\"".$floder.$rs[attach]."\">".$rs[attach]."</a>"?></td>
    <td>&nbsp;<?=$rs[description]?></td>
    <td align="center"><?=$del?></td>
</tr>
<? 
} 
mysql_free_result($result);
?>
<tr align="right" bgcolor="#dddddd">
	<td colspan="4"><a href="?action=new&tripid=<?=$tripid?>"><font class="normal_blue">
	<img src="bimg/profile_collapsed.gif" width="9" height="9" border="0"> เพิ่ม file</font></a>&nbsp;</td>
</tr>
</table>
<? } ?>
</body>
</html>