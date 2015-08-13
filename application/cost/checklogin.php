<?
session_start();
if ($_SESSION[islogin] != "1" )
{
?>
<HTML><HEAD>

<meta http-equiv="refresh" content="0;URL=login.php">
<?	exit;
}
?>