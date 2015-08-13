<? 
session_start();
include ("config/phpconfig.php");

$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");	
//echo "<center><img src=\"images/ico_constructing.gif\"> กำลังประมวล กรุณารอสักครู่... </center>";

$sqlAvatar = "
				SELECT
				COUNT(avatar_user.avatar) AS count_avatar
				FROM
				cos_user
				Inner Join avatar_user ON cos_user.userid = avatar_user.avatar
				WHERE
				avatar_user.userid =  '$_SESSION[userid]' 
				";
	$query_result = mysql_query( $sqlAvatar );
	$rowAvatar = mysql_fetch_assoc($query_result);

?>
<html>
<head>
<title>รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<?
if ($_SERVER[REQUEST_METHOD] == "GET" && ($rowAvatar['count_avatar'] > 0 || $_SESSION['avatar_mode']=="on") && $action == "entry" ){
	//$sql = " select * from cos_user where  userid = '$avatarid' AND avatar = '1' ";
	 $strSQL = "
		  SELECT
		  cos_user.userid,
		  cos_user.username,
		  cos_user.name,
		  cos_user.surname,
		  cos_user.pri,
		  avatar_user.avatar
		  FROM
		  cos_user
		  Inner Join avatar_user ON cos_user.userid = avatar_user.avatar
		  WHERE
		  avatar_user.userid =  '$_SESSION[userid]' 
		  AND avatar_user.avatar = '$avatarid' 
	  ";		
	 //echo "$strSQL";die;
	$result = mysql_query($strSQL);
	$rs=mysql_fetch_assoc($result);
	if(isset($rs[username])){
				//$_SESSION[islogin] = "1" ;
				$_SESSION[userid_origin] = $_SESSION[userid] ;
				$_SESSION[name_origin] = $_SESSION[name] ;
				$_SESSION[surname_origin] = $_SESSION[surname] ;
				
				$_SESSION[userid] = $rs[userid] ;
				$_SESSION[name] = $rs[name] ;
				$_SESSION[surname] = $rs[surname] ;
				$_SESSION[avatar_mode] = "on" ;
				//$_SESSION[pri] = $rs[pri] ;
				echo "<meta http-equiv='refresh' content='0;url=addtrip.php?showall=y'>" ;
	}else{
		echo"
					<script language=\"javascript\">
						alert(\" ไม่พบ AVATAR ที่คุณต้องการ \");
					</script>
		";
		echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;
		exit();
	}
	//echo "<center><img src=\"images/ico_constructing.gif\"> กำลังเข้าสู่ระบบ กรุณารอสักครู่... </center>";
}else if ( ($rowAvatar['count_avatar'] > 0  || $_SESSION['avatar_mode']=="on")  && $action == "clear" ){
				$avatar_name = $_SESSION[name] . " ". $_SESSION[surname];
				$_SESSION[avatar_mode] = "" ;
				$_SESSION[userid] = $_SESSION[userid_origin] ;
				$_SESSION[name] = $_SESSION[name_origin] ;
				$_SESSION[surname] = $_SESSION[surname_origin] ;	
		echo"
					<script language=\"javascript\">
					alert(\" ออกจากการจำลองใช้งานเป็น $avatar_name แล้ว \");
					</script>
		";
}
	echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;
die;
?>