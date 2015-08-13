<?php
session_start();
include ("config/phpconfig.php");


$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");	




if($_SESSION[userid]){
				echo "<meta http-equiv='refresh' content='0;url=addtrip.php?showall=y'>" ;	
				die;
}

if ($_SERVER[REQUEST_METHOD] == "POST"){
	$sql = " select * from cos_user where  username = '$user'  AND   password = '$pass' limit 1";
	$result = mysql_query($sql) or die(mysql_error());
	# CALLING EPM USER
	if(!@mysql_num_rows($result)){
        // @todo pok เปลี่ยนไห้การเช็ค login ไปเป็นฐานข้อมูล epm2
		$sql = " select staffid from epm2.epm_staff where  username = '$user'  AND   password = '$pass'  limit 1";
		$result_epm = mysql_query($sql) or die(mysql_error());
		if(@mysql_num_rows($result_epm)){
			$Row_epm = mysql_fetch_assoc($result_epm);
			$sql_epm="select * from cost.cos_user where epm_id='$Row_epm[staffid]' limit 1";
			$result = mysql_query($sql_epm) or die(mysql_error());
		}
	}
	
	$rs=mysql_fetch_assoc($result);
	if(isset($rs[username])){
		if($rs[pri] == "0"){
			echo "<script>alert('Username นี้ไม่อนุญาตเข้าใช้งานระบบ');window.location='login.php';</script>";
		}else if($rs[pri] == "20"){
				$_SESSION[islogin] = "1" ;
				$_SESSION[userid] = $rs[userid] ;
				$_SESSION[name] = $rs[name] ;
				$_SESSION[surname] = $rs[surname] ;
				$_SESSION[pri] = $rs[pri] ;
				echo "<meta http-equiv='refresh' content='0;url=account/showtrip.php'>" ;
		}else{
				$_SESSION[islogin] = "1" ;
				$_SESSION[userid] = $rs[userid] ;
				$_SESSION[name] = $rs[name] ;
				$_SESSION[surname] = $rs[surname] ;
				$_SESSION[pri] = $rs[pri] ;
				echo "<meta http-equiv='refresh' content='0;url=addtrip.php?showall=y'>" ;
		}
	}else{
		echo"
		  <script language=\"javascript\">
		  alert(\" Username หรือ Password ไม่ถูกต้อง \");
		  </script>
		";
		echo "<meta http-equiv='refresh' content='0;url=login.php'>" ;
		exit();
	}
	//echo "<center><img src=\"images/ico_constructing.gif\"> กำลังเข้าสู่ระบบ กรุณารอสักครู่... </center>";
die;
}else{
	
	foreach($_SESSION as $k=>$sess_name){
		if($sess_name!="application"){
			session_unregister($sess_name);
		}
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	<title>FIELD OPERATION SYSTEM ระบบบันทึกค่าใช้จ่ายออกพิ้นที่ </title>
	<link rel="stylesheet" href="css/general.css" type="text/css" media="screen" />
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<script lanuage="javascript">
	function check() {
		var v1 = document.post.user_login.value ;
		var v2 = document.post.pwd_login.value ;
		if(v1.length==0) {
			alert("กรุณาระบุ UserName!") ;
			document.post.user_login.focus() ;
			return false ;
		}else if(v2.length==0) {
			alert("กรุณาระบุ Password!") ;
			document.post.pwd_login.focus() ;
			return false ;
		}
		else 
		return true ;
	}
</script>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.h3 {
	font-size: xx-small;
	color: #333333;
	text-shadow: -5px 0 #dddddd, 0 5px #dddddd,
      5px 0 #dddddd, 0 -5px #dddddd}
.h4 {
	font-family: Arial;
	font-size: 36px;
	color: #333333;
	text-shadow: -1px 0 #dddddd, 0 1px #dddddd,
      1px 0 #dddddd, 0 -1px #dddddd}	 
.tran_table {
background-color: #EBEBEB;
opacity: .7;
filter: alpha(opacity=85);
-moz-opacity: .7;
}	   
.tran_table2 {
background-color: #EBEBEB;
opacity: .7;
filter: alpha(opacity=95);
-moz-opacity: .7;
}	
.tran_table3 {
opacity: .1;
filter: alpha(opacity=05);
-moz-opacity: .1;
}	
.wrap1, .wrap2, .wrap3 {
  display:inline-table;
  /* \*/display:block;/**/
  }
.wrap1 {
  float:left;
  background:url(images/shadow.gif) right bottom no-repeat;
  }
.wrap2 {
  background:url(images/corner_bl.gif) -4px 100% no-repeat;
  }
.wrap3 {
  padding:0 16px 16px 0;
  background:url(images/corner_tr.gif) 100% -4px no-repeat;
  }
.wrap3 img {
  display:block;
  }

-->
</style>
<!--Begin floating-alert-->
<style> 
	.floating-alert {
	position:fixed;
	background:#ffffff;
	border:1px solid #ffcc00;
	font-size:16px;
	top:10px;
	right:10px;
	margin:0px;
	width:550px;
	z-index: +999;

	}

</style>

<script>
function closeAlert(){
	document.getElementById("floating-alert").style.display="none";
}
</script>
<!--End floating-alert-->
<body>
<!--Begin Alert-->
	<?php /*?><center>
	<div class="floating-alert" id="floating-alert">
		<table width="500" border="0" align="center" style="margin:10px;">
		  <tr>
			<td align="left">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				  <tr align="right">
					<td><img src="images/delete.png"  border="0" style="cursor:pointer;" title="ปิดประกาศ" onclick="closeAlert();"/></td>
				  </tr>
				</table>
				<center><h2 style="color:#FF0000">ประกาศ</h2></center>
				<p/>
				<table width="100%" border="0" style="font-size:18px;color:#FF6600;">
				  <tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;แจ้งการปิดปรับปรุงระบบ เครื่อง Graph Server IP 202.129.35.106</td>
				  </tr>
				  <tr>
					<td>ตั้งแต่วันที่ 11 มีนาคม 2554 เวลา 17:30 น ถึงวันที่ 12 มีนาคม 2554 เวลา17:30 น</td>
				  </tr>
				  <tr>
					<td>เพื่อทำการปรับปรุงและสำรองข้อมูล</td>
				  </tr>
				</table>
				
				</td>
			</tr>
		</table>
	</div>
	</center><?php */?>
<!--End Alert-->
<form action="?" method="post" name="post" onSubmit="return check();" >
	<div align="center" style="height: 100%" >
<!--	<div class="wrap1" align="center" >
	 <div class="wrap2" align="center" >
	  <div class="wrap3" align="center" >
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
			<td>-->

	
		<table  width="767px" height="444px" border="0" align="center" cellpadding="0" cellspacing="0" >
		  <tr style="background-image:url(images/logo.png);height:150px;">
			<td height="220">			</td>
		  </tr>
		  <tr>
		    <td>
			<table width="100%" height="224" border="0" cellpadding="0" cellspacing="2" bgcolor="#B2B2B2">
              <tr>
                <td height="50" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="50%">&nbsp;</td>
                <td align="left" valign="middle">
                  <table width="80%" border="0"  cellpadding="2" cellspacing="10">
                  <tr>
                    <td align="right" class="link_back">USER NAME</td>
                    <td width="30%" align="left"><input name="user" type="text" id="user_login"maxlength="20" class="white"></td>
                  </tr>
                  <tr>
                    <td align="right" class="link_back">PASSWORD</td>
                    <td align="left"><input name="pass" type="password" id="pwd_login" maxlength="20" class="white"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="submit" type="submit" style="background:#25037C; width:62px; height:22px; color:#FFF; font-weight:bold; border:none;" value="Login" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr  >
                <td height="40" colspan="2" >
                <img src="images/logo_<?=$_SESSION['application']?>.png" align="absmiddle" border="0" height="<?=$_SESSION["logo_size"]?>" />
                <p/>&nbsp;
                </td>
              </tr>
            </table>
			
			</td>
	      </tr>		  
	  </table>	
	  
<!--			</td>
		  </tr>
		</table>	  
	 </div>
	 </div>
	</div>-->
	  
		<br>
		<br>
		<br>
		<br>
	</div>		
 </form>

</body>
</html>