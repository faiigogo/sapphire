<?php

if (isset($_GET['pro_code'])):
    $connect = mysql_connect('localhost', 'inside_system', 'System_$apph!re2014');
    if (!$connect) {
        die('<option value="e">Could not connect: ' . mysql_error() . '</option>');
    }
    $result = mysql_query("SET character_set_results=tis-620");
    $result = mysql_query("SET NAMES TIS620");
    mysql_select_db('dailyreport101', $connect) or die('<option value="e">die2</option>');

    $task_data = mysql_query("select TorId, CostId, TorName from Daily_TOR_Data WHERE ProjectCode = '" . $_GET['pro_code'] . "' ORDER BY line ASC");

    $textdata = "";
//    array_push($arr, array('TaskId' => 0, 'CostId' => 0, 'TaskName' => ''));
    while ($row = mysql_fetch_array($task_data)):
//        if ($row['TaskId'] != 0) {
        $textdata .= $row['TorId'] . "," . $row['CostId'] . "," . $row['TorName'] . "|";
//        }
    endwhile;
    $textdata[strlen($textdata) - 1] = "";
    echo $textdata;
    mysql_close($connect);
endif;
?>

