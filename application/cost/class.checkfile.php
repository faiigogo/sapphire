<?php
class checkfile{
	var $_table;
	var $_config;
	var $_totalrows;
	var $_page;
	var $_id;
	
	function checkfile(){
		
		
		
		$this->_table = "trip";
		$this->_id = "tripid";
		$this->_page = 20;
	}
	
	function checkfile_report(){
		
		$SQL = "SELECT t2.runno,t1.tripid,t1.tripname,t2.date_list,t2.attach,t3.userid,t3.name,t3.surname,t2.no_ap,t2.detail FROM trip AS t1 Inner Join list AS t2 ON t1.tripid = t2.tripid Left Join cos_user AS t3 ON t2.userid = t3.userid WHERE t2.date_list BETWEEN'2012-09-01' AND '2012-10-09' ORDER BY t2.runno ASC,t3.name ASC,t3.surname ASC,t2.date_list ASC,t1.tripid ASC,t1.tripname ASC";		
		$_result = mysql_query($SQL);
		
		
		while($_rows = mysql_fetch_assoc($_result)){
			
				if(file_exists($_rows["attach"])){
					$_rows["status"] = 1;	
					
					//echo $_rows["tripid"].",'".$_rows["tripname"]."','".$_rows["date_list"]."','".$_rows["attach"]."','".$_rows["userid"]."','".$_rows["name"]."','".$_rows["surname"]."','".$_rows["no_ap"]."','".$_rows["detail"]."','".$_rows["status"]."<br>";
					
				}	
				else
					$_rows["status"] = 0;	
		
		
		$this->add_to_db($_rows);
		}
		
	return true;	
	}
	
	function add_to_db($_request){
		$_SQL = "INSERT INTO cost_checkfile(runno,tripid,tripname,date_list,attach,userid,name,surname,no_ap,detail,status) values('".$_request["runno"]."','".$_request["tripid"]."','".$_request["tripname"]."','".$_request["date_list"]."','".$_request["attach"]."','".$_request["userid"]."','".$_request["name"]."','".$_request["surname"]."','".$_request["no_ap"]."','".$_request["detail"]."','".$_request["status"]."')";
			
		$_rs = mysql_query($_SQL);
		
		//if(!$_rs)
			echo $_SQL."<br>";
	
	
	
	return true;
	}
	}
	
?>