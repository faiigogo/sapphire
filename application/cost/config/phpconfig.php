<?php
//session_start();
include ("cost/function.php");

if($_GET['application']!=""){
	$_SESSION['application'] = $_GET['application'];
}else if($_SESSION['application']){
	$_SESSION['application'] = $_SESSION['application'];
}
//echo session_id()."<br/>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

if($_SESSION["application"]==""){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=windows-874">';
	echo '<center><table align="center"><tr><td align="center">';
		echo '<DIV style="text-align:left;margin:20px;">';
		echo '<a href="login.php?application=sapphire"><img src="images/star_full.png" border="0" align="absmiddle"/> ระบบบันทึกค่าใช้จ่ายออกนอกพื้นที่ Sapphire</a>';
		echo '</DIV>';
		echo '<DIV style="text-align:left;margin:20px;">';
		echo '<a href="login.php?application=gnis"><img src="images/star_full.png" border="0" align="absmiddle"/> ระบบบันทึกค่าใช้จ่ายออกนอกพื้นที่ Gnis</a>';
		echo '</DIV>';
	echo '</td></td></table></center>';
	exit();
}

$_SESSION["logo_size"] = ($_SESSION['application']=="sapphire")?30:50;

$servername     = 'localhost';//192.168.2.11
$username         = 'root';
$userpassword   = 'root';
/*$servername     = 'localhost';
$username         = 'root';
$userpassword   = 'jang';*/
$db_name = ($_SESSION['application']=="sapphire")?'cost':'cost_gnis';
$db_name_gnis = 'cost_gnis';
$db_epm = "epm";

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; die;


if($debug == "ON"){
	$out_lan = "ON";
	$_SESSION["out_lan"] = "ON";
	echo "DEBUG MODE ";
}

/*
	$redir_url = "http://192.168.2.13/sapphire/application/cost/login.php";
	$url_ip = $_SERVER["HTTP_HOST"]; 
	if(date("Ymd") > "20101027" && $out_lan!="ON"){
		if(substr($_SERVER["HTTP_HOST"],0,8) != "192.168." && $_SERVER["HTTP_HOST"] != "127.0.0.1" && $_SERVER["HTTP_HOST"] != "localhost"){
			header("Location: $redir_url");
			die;
		}
	}

*/
/*

$servername     = 'localhost';
//$username         = 'webmaster';
//$userpassword   = 'office!sprd';
$username         = 'sapphire';
$userpassword   = 'sprd!@#$%';
$db_name = 'cost';
*/
//$redir_url = "http://192.168.2.13/sapphire/application/cost/login.php";
//$url_ip = $_SESSION["HTTP_HOST"];
//echo "";
//if(substr($url_ip,0,8) != "192.168."){
//		//header("Location: $redir_url");
//		//exit();
//}

	//echo "ip :: $user_ip";
	
	//echo " ip :: $ip";
//	if(substr($ip,0,8) != "192.168."){
//		echo "<meta http-equiv='refresh' content='0; url=http://192.168.2.13/sapphire/application/cost/login.php'>";
//		exit;	
//	}
		//echo "<meta http-equiv='refresh' content='0; url=http://192.168.2.13/sapphire/application/cost/login.php'>";
	//header ("Location:  $r_url"); 	

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ก.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

/* open connection Mysql Server */

    $conn = mysql_connect( $servername,$username,$userpassword ) or die(mysql_error());
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");	
    if (!$conn)
	die ("ไม่สามารถติดต่อกับ MySql ได้ ");
	mysql_select_db($db_name,$conn) 
	or die ("ไม่สามารถเลือกใช้ฐานข้อมูลได้ ");

?>
