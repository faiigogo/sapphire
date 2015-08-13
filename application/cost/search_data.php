<?php
set_time_limit(0);
session_start();
//include ("checklogin.php");

include ("config/phpconfig.php");


if($_GET['start']=="on"){
	$dbname = "cost";
	$data_search = '2555050158';
	echo "<strong style='color:#00FF00;'>Data Search:".$data_search."</strong><br/>";
	$sql_table = "SHOW TABLES ";
	$query_table = mysql_db_query($dbname,$sql_table);
	while( $table = mysql_fetch_assoc($query_table)){
		echo '<strong>Table: '.$table['Tables_in_'.$dbname].'</strong><br/>';
		$sql_filed = "SHOW FIELDS FROM ".$table['Tables_in_'.$dbname];
		$query_filed = mysql_db_query($dbname,$sql_filed);
		while( $filed = mysql_fetch_array($query_filed)){
			if($filed[1]!="date"){
				$sql = "SELECT COUNT(`".$filed[0]."`) AS count_data FROM `".$table['Tables_in_'.$db_name]."`  WHERE `".$filed[0]."`='".$data_search."' ";
				$query = mysql_db_query($dbname,$sql);
				$data = mysql_fetch_assoc($query);
				
				if($data['count_data']>0){
					echo "&nbsp;&nbsp;Table: ".$table['Tables_in_'.$db_name]."<br/>";
					echo "&nbsp;&nbsp;Filed: ".$filed[0]." (".$data['count_data'].")<br/>";
					echo "</br>";
				}
			}
		}
		
	}
	echo "<hr>";
	
}
?>