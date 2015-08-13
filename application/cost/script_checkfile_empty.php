<?php
require_once("phpconfig.php");
require_once("class.checkfile.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SCRIPT CHECK FILE EMPTY</title>
</head>

<body>
<?php
	$_chk_file = new checkfile();
	
	$_chk_file->checkfile_report();
?>

</body>
</html>