<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=ClassTimeQueryV1P0&url=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" height="0" width="0" style=" display: none" ></iframe>
<?php 

//require_once("../config/conndb_nonsession.inc.php");
class time_query{            
	var $starttime="";
	var $timeend="";
	var $display_onend="1";
    var $ApplicationName="";
    var $dbsystem=DB_SYSTEM;
    var $server_ip="";
	function time_query($server_ip="",$app_name="",$dbsystem){
		$this->starttime=$this->getmicrotime();
        if($app_name!=""){
          $this->ApplicationName=$app_name;  
        }else{
         $this->ApplicationName=$GLOBALS[ApplicationName];  
        }
        if($dbsystem!=""){
            $this->dbsystem=$dbsystem;
        }else{
            $this->dbsystem=($GLOBALS[dbsystem]!="")?$GLOBALS[dbsystem]:$this->dbsystem;
        }
        if($server_ip!=""){
           $this->server_ip=$server_ip; 
        }        
	}
	 function __destruct(){
		if($this->display_onend=="1"){
            $this->save_time();
        }  
 	}
	function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	 } 
	function save_time(){        
		$this->timeend=$this->getmicrotime();				 
		$timequery = $this->timeend - $this->starttime;
        $serverip = ($this->server_ip!="")?$this->server_ip:$_SERVER['SERVER_NAME'];        
        $ipaddress = $this->get_ipaddress();
        $file_name = basename($_SERVER['PHP_SELF']);      
		$fullname=  $_SERVER['PHP_SELF'];
        $sessionid = session_id();
        $siteid1 = $_SESSION[secid];
        $ogj_file=$this->get_file();
        $ApplicationName=$this->ApplicationName;
        //$filefullpath=$ogj_file[file];
        $sql = " INSERT INTO system_timequery  SET  username = '".$_SESSION[session_username]."' ,ipaddress = '$ipaddress' ,siteid='$siteid1',appname = '$ApplicationName', filename = '$file_name' ,timequery = '$timequery' , serverip = '$serverip'  ";
        if($this->dbsystem != ""){
			//echo $this->dbsystem."<br>";
        //  mysql_db_query($this->dbsystem,$sql)or die(mysql_error()." LINE:: ".__LINE__);    
		mysql_db_query($this->dbsystem,$sql);
		$xid=mysql_insert_id();
		$sql="insert into system_timequery_fullpath set id='$xid',fullname='$fullname'";
		mysql_db_query($this->dbsystem,$sql);
        }  
	}
    
    function get_file(){       
     $bt = debug_backtrace(); 
     $index=count($bt)-1;
     $caller = $bt[$index];         
    }
    
    function get_ipaddress($fakeip=false){
        $ip = (!empty($_SERVER['HTTP_CLIENT_IP'])) ? (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_CLIENT_IP'] : preg_replace('/(?:,.*)/', '', $_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['REMOTE_ADDR'];
        $ip = (!$fakeip) ? $ip:$fakeip;

        // local check class b and c
        $patterns = array("/(192).(168).(\d+).(\d+)/i","/(10).(\d+).(\d+).(\d+)/i");
        foreach($patterns as $pattern) {
        if(preg_match($pattern,$ip)) {
        return $_SERVER["REMOTE_ADDR"];
        }
        }
        // local check class a
        $parts = explode(".",$ip);
        if($parts[0]==172 && ($parts[1]>15 || $parts[1]<32)) {
        return $_SERVER["REMOTE_ADDR"];
        }

        if($_SERVER['HTTP_X_FORWARDED_FOR'] != ""){
        return $_SERVER['HTTP_X_FORWARDED_FOR'] ;
        }

        return trim($ip);
    }
	 
}


$dbsystem = DB_SYSTEM;
if($stoptime_query==""){
	
    $mytime_query=new time_query("",$ApplicationName,$dbsystem);
}
 
 
?>
