<?
phpinfo();
exit;

$myServer = "192.168.2.14"; 
$myUser = "sa"; 
$myPass = "password"; 
$myDB = "Northwind"; 
$s = mssql_connect($myServer, $myUser, $myPass) or die("Couldn't connect to SQL Server on $myServer"); 
echo "connected";


?>