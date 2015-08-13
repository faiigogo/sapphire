<?
session_start() ; 
$application = $_SESSION['application'];
session_destroy() ;
$msg = "<font class=blue>ออกจากระบบเรียบร้อยแล้ว</font><br>ระบบกำลังพาท่านสู่หน้าหลัก กรุณารอซักครู่";
include("msg_box.php");
echo "<meta http-equiv='refresh' content='2;url=login.php?application=$application'>";
exit();
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">