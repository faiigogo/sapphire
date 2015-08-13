<?php

session_start();
header("Content-Type: text/plain; charset=windows-874");
include ("config/phpconfig.php");
include ("cost/function.php");



// หาโปรเจ็คที่ ปิดอยู่ จากตาราง Project_Status ที่มีสถานะของโครงกร และเก็บรหัสโครงการแบบย่อ
$query_project_status = 'SELECT * FROM dailyreport101.Project_Open';

$result_project_open = mysql_query($query_project_status) or die(mysql_error());
;

$sql_project_open = array();
if (mysql_num_rows($result_project_open) >= 1) {
    while ($is_project = mysql_fetch_assoc($result_project_open)) {
        $sql_project_open[] = "'" . $is_project['code_project'] . "'";
    }


    $sql_project_open = " AND $db_name.type_project.code_project IN (" . implode(',', $sql_project_open) . ")";
}
// /////////////////////////////////////////////////////////////////////////////////
//echo "==".$p_id."<br>";
if ($p_id == "office") {
    //echo $p_id."<hr>";
    $cond = "  WHERE $db_name.type_project.code_project LIKE 'OF%'";
} else if ($p_id == "marketing") {
    $cond = "  WHERE $db_name.type_project.code_project LIKE 'MAR%'";
} else if ($p_id == "RD") {
    $cond = " WHERE $db_name.type_project.code_project LIKE 'RD%'";
} else if ($p_id == "presale") {
    $cond = " WHERE $db_name.type_project.code_project LIKE 'PS%'";
} else if ($p_id == "project") {
    $cond = " WHERE $db_name.type_project.code_project NOT LIKE 'OF%' AND $db_name.type_project.code_project NOT LIKE 'MAR%' AND $db_name.type_project.code_project NOT LIKE 'RD%' AND $db_name.type_project.code_project NOT LIKE 'PS%'";
} else {
    $cond = " WHERE 1";
}
$sql_select = "SELECT * FROM $db_name.type_project  $cond $sql_project_open ORDER BY  $db_name.type_project.code_project DESC";
//echo 	$sql_select;
$result = mysql_db_query($db_name, $sql_select)or die(mysql_error());
while ($result1 = mysql_fetch_assoc($result)) {
    $result1[name_project] = LimitText($result1[name_project], 100);
    $name2 = "$result1[code_project] : $result1[name_project]";
    //$sname=  $result[name_short] ;
    echo $name2 . "::" . $result1[id_type_project] . ",";
    //echo "$secname4,"; 
}//end while
// ปิดการเชื่อมต่อ
mysql_close();
?>
