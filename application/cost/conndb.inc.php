<?
session_start()  ;
if  ($tig_session_get == "public" ){
			session_register('source_db');
			$tig_session  ="public"  ;
			$source_db="public";
}elseif ($tig_session_get == "dataentry" ) {
			session_unregister('source_db');		
			$source_db="";
}else{
	if($source_db=="public"){
				session_register('source_db');
				$tig_session  ="public"  ;
				$source_db="public";
	}
}

$graphserver="" ;
$data_entry="../../report/dataentry/";
//data database
$host = "localhost"  ;
$username = "webmaster"  ;
$password = "poc2505ssk"  ;
$db_dataentry = "sisaket_dataentry";
$db_public = "sisaket_dataentry"  ;  

//system data base
$sysdbname2 =""  ;
//province data
$prov_id =  "33"   ;
$prov_name = "ศรีสะเกษ"    ;
$prov_name_eng = "SISAKET"    ;
$provid = "3300"     ;
$provid_8 = "33000000"     ;
$connect_status =   "On line"  ;

//---gis link------
//gis ของจังหวัด
$gislink="/sskgis/gistemp_main/mapview.php"; 
$gistarget = "_blank";
//gis list
$depgislink="/gis_template/gislist.php"; 
$depgistarget = "_blank";
//---gis link end

$approve_moudle = "yes" ;
$connect_step = 3 ;
$link1 =MYSQL_CONNECT($host, $username, $password) ;
if (!$link1) {
   DIE(mysql_error() ."Unable to connect to HOST  $host");
}

if ((session_is_registered("session_username")) AND ( $source_db == "public")){
	$dbname = $db_public  ;
}
else if(session_is_registered("session_username")){
	$dbname = $db_dataentry  ;
}
else{
	$dbname = $db_public  ;
}

$con1 =  mysql_select_db($dbname , $link1)  ;
if (!($con1)) {
   die( mysql_error() . "Unable to select database $dbname  <br>   ");
}
?>