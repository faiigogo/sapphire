<?
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");
include ("config/phpconfig.php");
include ("libary/function.php");

$code	= post_decode($_GET['code']);
$sql		= " select * from `type_project` where code_project = '".$code."'; ";

$result	= mysql_query($sql)or die("Query line " . __LINE__ . "<hr>".mysql_error());
$row		= mysql_num_rows($result);
if($row >= 1){
	echo "<font color='red'>หมายเลขโครงการซ้ำกับที่มีอยู่แล้ว</font>"; 
}
?>