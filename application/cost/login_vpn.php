<? 
session_start();
include ("config/phpconfig.php");

//echo "<pre>";
//print_r($_SERVER);
$url_ip = $_SESSION["HTTP_HOST"];
//echo $url_ip;
$redir_url = "http://192.168.2.13/sapphire/application/cost/login.php";
if(substr($_SERVER["HTTP_HOST"],0,8) != "192.168."){
//	echo $redir_url;
	header("Location: $redir_url");	
//	die;
}


if ($_SERVER[REQUEST_METHOD] == "POST"){

	$sql = " select * from cos_user where  username = '$user'  AND   password = '$pass' ";
	$result = mysql_query($sql);
	$rs=mysql_fetch_assoc($result);
	if(isset($rs[username])){
		If ($rs[pri] == "20"){
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
				echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;
		}
	}else{
			echo"
					<script language=\"javascript\">
					alert(\" ไม่สามารถเข้าระบบได้ \\n เนื่องจาก Username หรือ รหัสผ่านผิด  \");
					</script>
		";
		echo "<meta http-equiv='refresh' content='0;url=login.php'>" ;
		exit();

	}

}else{
session_destroy();
}
?>


<html>
<head><title>Please Login :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="cost.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr><td height="500"><div align="center">
<form action="?" method="post" name="post" onSubmit="return check();">
  <table width="500" border="1" cellspacing="0" cellpadding="0" bordercolor="#eeeeee">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="right" valign="middle" bgcolor="#A5B5CE" class="normal"><img src="images/logo_sapp.jpg" width="160" height="50"></td>
          </tr>
          <tr>
            <td height="170" width="282" valign="middle" bgcolor="#A5B5CE" class="normal"><div align="center"><img src="bimg/secu.png" width="64" height="64"> <br>
              กรุณากรอกชื่อผู้ใช้และรหัสผ่านเข้าสู่ระบบ</div></td>
            <td width="204" valign="middle" bgcolor="#A5B5CE"><table width="100%" border="1" cellpadding="0" cellspacing="0" align="center" bordercolor="#e1e1e1">
                <tr>
                  <td width="219"><table width="200" border="0" cellspacing="0" cellpadding="0" bgcolor="#f8f8f8">
                      <tr>
                        <td height="40" colspan="2"><div align="center"><img src="bimg/login.gif" width="74" height="33"></div></td>
                      </tr>
                      <tr>
                        <td width="83" class="blue"><div align="right">UserName&nbsp;</div></td>
                        <td width="117"><input name="user" type="text" id="user_login2" size="18" maxlength="20" class="input"></td>
                      </tr>
                      <tr>
                        <td class="blue"><div align="right">Password&nbsp;</div></td>
                        <td><input name="pass" type="password" id="pwd_login2" size="18" maxlength="20" class="input"></td>
                      </tr>
                      <tr>
                        <td height="30">&nbsp;</td>
                        <td><div align="left">
                          <input name="submit" type="submit" class="input" value="Login" style="font-weight:bold">
                        </div></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <script lanuage="javascript">
function check() {
var v1 = document.post.user_login.value ;
var v2 = document.post.pwd_login.value ;
if(v1.length==0) {
alert("กรุณากรอกชื่อเข้าสู่ระบบ") ;
document.post.user_login.focus() ;
return false ;
}
else if(v2.length==0) {
alert("กรุณากรอกรหัสผ่าน") ;
document.post.pwd_login.focus() ;
return false ;
}
else 
return true ;
}
</script>
</form>
</div></td>
</tr>
</table>
</body>
</html>