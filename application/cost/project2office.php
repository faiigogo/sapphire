<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");


if ($action == "p2o"){
	#Begin project2office Sapphire
	$sql = " update list set  id_type_project = 5,id_type_project_old='$id_type_project' WHERE id_type_project = '$id_type_project' ";
	$result = mysql_query($sql) ;
	$numaff = mysql_affected_rows();
	if($numaff>0){
			$sql1 = " DELETE  FROM  type_project  WHERE   id_type_project = '$id_type_project'   ";
			mysql_query($sql1) ;
			$msg	 = "แก้ไขเรียบร้อย";
			include("msg_box.php");
			echo "<meta http-equiv='refresh' content='0;url=addtype_project.php'>" ;
			exit;
	}else{
			$sql1 = " DELETE  FROM  type_project  WHERE   id_type_project = '$id_type_project'   ";
			mysql_query($sql1) ;
			$msg	 = "ไม่มีรายการค่าใช้จ่ายในโปรเจคนี้ ระบบจะลบโปรเจคนี้อย่างเดียว";
			include("msg_box.php");
			echo "<meta http-equiv='refresh' content='0;url=addtype_project.php'>" ;
			exit;
	}
	#End project2office Sapphire
	#Begin project2office Gnis
	$sql = " update list set  id_type_project = 5,id_type_project_old='$id_type_project' WHERE id_type_project = '$id_type_project' ";
	$result = mysql_db_query($db_name_gnis, $sql) ;
	$numaff = mysql_affected_rows();
	if($numaff>0){
			$sql1 = " DELETE  FROM  type_project  WHERE   id_type_project = '$id_type_project'   ";
			mysql_db_query($db_name_gnis, $sql1) ;
			$msg	 = "แก้ไขเรียบร้อย";
			include("msg_box.php");
			echo "<meta http-equiv='refresh' content='0;url=addtype_project.php'>" ;
			exit;
	}else{
			$sql1 = " DELETE  FROM  type_project  WHERE   id_type_project = '$id_type_project'   ";
			mysql_db_query($db_name_gnis, $sql1) ;
			$msg	 = "ไม่มีรายการค่าใช้จ่ายในโปรเจคนี้ ระบบจะลบโปรเจคนี้อย่างเดียว";
			include("msg_box.php");
			echo "<meta http-equiv='refresh' content='0;url=addtype_project.php'>" ;
			exit;
	}
	#End project2office Gnis
}
?>
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
</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom ">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30" colspan="2" class="style4">แก้ไขโครงการเป็นค่าใช้จ่าย office </td>
        </tr>
<!--        <tr bgcolor="#CACACA">
          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้าหลัก" onClick="location.href='addtype_project.php?tripid=<?=$tripid?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>-->
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
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

