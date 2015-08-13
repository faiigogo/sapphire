<?php
session_start();
//include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){
$start_project = swapdate($start_project);
$end_project = swapdate($end_project);

			 if ($_POST[action]=="edit2")
			 {
				$sql = "update type_project set  code_project='$code_project' , name_project = '$name_project' , no_project = '$no_project', value = '$value' ,start_project = '$start_project', end_project = '$end_project'
				 where id_type_project ='$id_type_project' ;";
				 
			
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					header("Location: ?id=$id&action=edit&refreshpage=1");
					exit;
				}
			}else
				{
				$sql = "INSERT INTO  type_project (id_type_project,code_project,name_project,no_project,value,start_project,end_project)	VALUES ('$id_type_project','$code_project','$name_project','$no_project','$value','$start_project','$end_project')";
					$result  = mysql_query($sql);
					if($result)
					{
						header("Location: ?id=$id&action=edit&refreshpage=1");
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
}else if ($_GET[action] == 'delete')
	{
		mysql_query("delete from type_project where id_type_project = $id_type_project ");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			header("Location: ?runid=$runid&action=edit&refreshpage=1");
			exit;
			}
	
}else
		{		
	 	$sql = "select * from  type_project   ;";
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
<title>ประเภท</title>
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
              <td width="15%">&nbsp;</td>
              <td width="85%"><B class="pheader">
                เช็ครหัสโครงการกับAccrone</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <?
 if ($_GET[action]!="edit2")
 {
?>
        <td valign="top" ><p>&nbsp;</p>
            <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
              <tr bgcolor="#A3B2CC">
                <td align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                <td><div align="center"><b>รหัสโครงการ</b></div></td>
                <td width="27%"><div align="center"><strong>รหัส Accrone </strong></div></td>
                <td width="27%">&nbsp;</td>
              </tr>
              <?php
			  
		
$myServer = "192.168.2.14";
$myUser = "sa"; 
$myPass = ""; 
$myDB = "Company_001"; 
$db = new COM("ADODB.Connection"); 
//$dsn = "DRIVER=\{SQL Server}; SERVER=\{$myServer};UID=\{$myUser};PWD=\{$myPass}; DATABASE=\{$myDB}"; 
//$dsn = "DRIVER={SQL Server}; SERVER=$myServer;UID=$myUser;PWD=$myPass; DATABASE=$myDB;"; 
$dsn = "Provider=sqloledb;Data Source=$myServer;Initial Catalog=$myDB;User Id=$myUser;Password=$myPass;";
//echo $dsn;
$db->Open($dsn);

/*
 while (!$rsPJID->EOF)
 { 
    echo $rsACC->Fields['RecID']->Value."";
    $rsACC->MoveNext();
 }	
*/
		$i = 0;
		$no=0;
		$max=0;
		$result = mysql_query("select * from type_project  ;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$i++;
			$no++;
			if ($rs[id_type_project] > $max) $max=$rs[id_type_project];
			
			if ($i % 2) {
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}
			
			$sqlPJID = "SELECT * FROM SMGe_CompProj_ShowGridMain Where Status = 1 and Active = 1  and  DocCode = '$rs[code_project]' ";
			$rsPJID = $db->Execute($sqlPJID);
			If ($rsPJID->EOF)
			{
		//		echo  "ไม่พบรหัสนี้ใน Accrone ";
				$ProjID = "ไม่พบรหัสนี้ใน Accrone ";
			}else
			{
				$ProjID  = $rsPJID->Fields['DocCode']->Value ;
			}
			If  ($rs[code_project] == $ProjID)
			{
				$project_acc = $ProjID;
				$project_site = $rs[code_project];
			}else
			{
				$project_acc = $ProjID;
				$project_site = $rs[code_project];
				$bg = "#FF0000";
			}
		?>
              <tr bgcolor="<?=$bg?>">
                <td align="left"><?=$i?></td>
                <td align="center"><?=$project_site?></td>
                <td width="27%" align="center"><?=$project_acc?></td>
                <td align="center" bgcolor="<?=$bg?>">
				  
				  <a href="addtype_project.php?id_type_project=<?=$rs[id_type_project]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id_type_project=<?=$rs[id_type_project]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </p>         
			    </td>
              </tr>
              <?
		}
		?>
            </table>
            <br>
            <?
}
else if ($_GET[action]=="edit2")
{
		$sql = "select * from type_project where id_type_project='$id_type_project'  ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$start_project = swapdate($rs[start_project]);
 			$end_project = swapdate($rs[end_project]);
		}


}

?>
<form name="form1"  method = POST  action = "<?=$PHP_SELF?>"  onSubmit="return ch2();">
              <INPUT TYPE="hidden" NAME="id_type_project" VALUE="<?=$id_type_project?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
</form>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
