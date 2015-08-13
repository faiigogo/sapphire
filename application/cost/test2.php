<?php 
$myServer = "THEMAI\SQLEXPRESS"; 
$myUser = "sa"; 
$myPass = "dataadmin"; 
$myDB = "incentive"; 
/*
$connection_string = 'DRIVER={SQL Server};SERVER=$myServer;DATABASE=$myDB';
$user = 'sa';
$pass = 'dataadmin';
$connection = odbc_connect( $connection_string, $user, $pass );


$query = "SELECT username+' '+Question AS Employee FROM login "; 
$result = odbc_exec($connection,$query); 
$numRows = odbc_num_rows($result); 
echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 
while($row = odbc_fetch_array($result)) { 
	echo "<li>" . $row["Employee"] . "</li>"; 
} 


*/
$db = new COM("ADODB.Connection"); 
$dsn = "DRIVER={SQL Server}; SERVER={$myServer};UID={$myUser};PWD={$myPass}; DATABASE={$myDB}"; 
$db->Open($dsn);
$rs = $db->Execute("SELECT * FROM login");

while (!$rs->EOF)
{
    echo $rs->Fields['Question']->Value."<BR>"; 
    $rs->MoveNext(); 
}
?> 