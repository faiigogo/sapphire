<?php

if (isset($_POST['insert_data'])):

    $insert_data = str_replace("\'", "'", $_POST['insert_data']);

    $connect = mysql_connect('202.129.35.101', 'sapphire', 'sprd!@#$%');
    if (!$connect) {
        die('<option value="e">Could not connect: ' . mysql_error() . '</option>');
    }

    $result = mysql_query("SET character_set_results=tis-620");
    $result = mysql_query("SET NAMES TIS620");

    mysql_select_db('cost_temp', $connect) or die('<option value="e">die2</option>');

    $task_data = mysql_query("DROP TABLE IF EXISTS daily_task_data_mini");
    
//    if($task_data){
//        echo "<br> Drop table success <br>";
//    } else {
//        echo "<br> Drop table fail <br>";
//    }
    
    $sql = "CREATE TABLE IF NOT EXISTS daily_task_data_mini ( ";
    $sql .= "id int(11) NOT NULL AUTO_INCREMENT, ";
    $sql .= "ProjectCode varchar(50) DEFAULT NULL, ";
    $sql .= "TaskId varchar(100) DEFAULT NULL, ";
    $sql .= "CostId varchar(100) DEFAULT NULL, ";
    $sql .= "TaskName varchar(200) DEFAULT NULL, ";
    $sql .= "PRIMARY KEY (id) ";
    $sql .= ") ENGINE=MyISAM CHARSET=tis620 AUTO_INCREMENT=1";
    $task_data = mysql_query($sql);
    
//    if($task_data){
//        echo "Create table success <br>";
//    } else {
//        echo "Create table fail <br>";
//    }
    
    $task_data = mysql_query(iconv("utf-8", "tis-620", $insert_data));
    
    mysql_close($connect);
endif;
?>