<?php
if (isset($_GET['pro_code'])):
    $connect = mysql_connect('202.129.35.101', 'sapphire', 'sprd!@#$%');
    if (!$connect) {
        die('<option value="e">Could not connect: ' . mysql_error() . '</option>');
    }
    $result = mysql_query("SET character_set_results=tis-620");
    $result = mysql_query("SET NAMES TIS620");
    mysql_select_db('dailyreport', $connect) or die('<option value="e">die2</option>');

    $task_data = mysql_query("select  *  from Daily_Task_Data WHERE Daily_Task_Data.ProjectCode = '" . $_GET['pro_code'] . "'");

    $arr = array();
//    array_push($arr, array('TaskId' => 0, 'CostId' => 0, 'TaskName' => ''));
    while ($row = mysql_fetch_array($task_data)):
//        if ($row['TaskId'] != 0) {
            array_push($arr, array('TaskId' => $row['TaskId'], 'CostId' => $row['CostId'], 'TaskName' => iconv("tis-620","utf-8",$row['TaskName'])));
//        }
    endwhile;
    echo $_GET['callback'] . "(" . json_encode($arr) . ");";
    mysql_close($connect);
endif;
?>

