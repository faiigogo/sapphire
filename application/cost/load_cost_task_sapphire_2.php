<?php

if (isset($_GET['key']) && $_GET['key'] = 'superSapphire'):
    $connect = mysql_connect('202.129.35.101', 'sapphire', 'sprd!@#$%');
    if (!$connect) {
        die('<option value="e">Could not connect: ' . mysql_error() . '</option>');
    }
    $result = mysql_query("SET character_set_results=tis-620");
    $result = mysql_query("SET NAMES TIS620");
    mysql_select_db('dailyreport', $connect) or die('<option value="e">die2</option>');

    $task_data = mysql_query("select  *  from Daily_Task_Data WHERE 1");

    $export_result = "INSERT INTO daily_task_data_mini (ProjectCode, TaskId, CostId, TaskName) VALUES ";

    while ($row = mysql_fetch_array($task_data)):
        $export_result .= "('" . $row['ProjectCode'] . "','" . $row['TaskId'] . "','" . $row['CostId'] . "','" . $row['TaskName'] . "'),";
    endwhile;
    $export_result[strlen($export_result) - 1] = ";";
    
    $arr = array(0 => $export_result);
    echo $_GET['callback'] . "(" . json_encode($arr) . ");";
    mysql_close($connect);
endif;
?>

