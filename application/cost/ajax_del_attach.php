<?php
	session_start();
    header("Content-Type: text/plain; charset=windows-874");
	include ("config/phpconfig.php");
	
	$sql_attach = "SELECT attach FROM `list` WHERE `runno`='$p_id' ";
	$query = mysql_db_query($db_name,$sql_attach ) or die(mysql_error());
	$row = mysql_fetch_assoc($query);
	if(is_file($row['attach'])){
		unlink($row['attach']);
	}
	$strSQL="	UPDATE `list` SET `attach`='' WHERE (`runno`='$p_id')  	";
	$result= mysql_db_query($db_name,$strSQL ) or die(mysql_error());
	echo "success";

?>
