<?php
//session_start();

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


/* ฟังก์ชั่น Close connection */
function CloseDB()
{
    global $conn;
    mysql_close($conn);
}

function GetTripOwner($tid){
	$sql = "select concat(t2.name,' ',t2.surname) from trip t1 inner join cos_user t2 on t1.userid=t2.userid where t1.tripid='$tid';" ;
	$result = mysql_query($sql);
	$rs = mysql_fetch_array($result);
	return $rs[0];
}

function DateInput($d,$pre){
	global $monthname;
	if (!$d){
		$d = (intval(date("Y")) + 543) . "-" . date("m-d"); // default date is today
	}

	$d1=explode("-",$d);
?>
วันที่
<select name="<?=$pre?>_day" >
<?
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
</select>

เดือน 
<select name="<?=$pre?>_month" >
<?
for ($i=1;$i<=12;$i++){
	$xi = sprintf("%02d",$i);
	if (intval($d1[1])== $i){
//		echo "<option value='$xi' SELECTED>$xi</option>";
		echo "<option value='$xi' SELECTED>$monthname[$i]</option>";
	}else{
//		echo "<option value='$xi'>$xi</option>";
		echo "<option value='$xi'>$monthname[$i]</option>";
	}
}
?>
</select>

ปี พ.ศ. 
<select name="<?=$pre?>_year" >
<?
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option SELECTED>$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}
?>
</select>
<?
}




function MakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . $d1[0];
}

function DBThaiDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543);
}


function DBThaiLongDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}


function ThaiDate2DBDate($d){
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	
	$d1=explode("/",$d);
	return (intval($d1[2]) - 543) . "-" . $d1[1] . "-" . $d1[0];
}

?>