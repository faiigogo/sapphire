<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
# Modifine :: Suwat
#LastUpdate::26/01/2010
#DatabaseTable::callcenter_entry, moniter_keyin

#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$dbnameuse = $db_name;
			

function CalMoneySubV2($staff_id,$get_idcard,$get_ticketid){
global $dbnameuse,$db_name,$dbnamemaster,$arr_f_tbl1,$subfix,$subfix_befor,$arr_f_tbl3;
$datereq1 = "2009-12-14";

$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
	
}//end while($rs_std = mysql_fetch_assoc($result_std)){

$numval = array() ;

$str = "SELECT 
distinct monitor_keyin.idcard,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
date(monitor_keyin.timeupdate) as val
FROM
keystaff
Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND 
keystaff.staffid='$staff_id'
AND date(timeupdate) >= '$datereq1'
and 
tbl_assign_sub.ticketid='$get_ticketid'
and monitor_keyin.idcard='$get_idcard'
GROUP BY monitor_keyin.idcard   ORDER BY keystaff.staffid ASC ";
//echo $str."<br>";
$results = mysql_db_query($dbnameuse,$str);
while($rss  = mysql_fetch_assoc($results)){

$j++;

$results3 = mysql_db_query("cmss_master"," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = "cmss_".$rss3[siteid] ;
$d = explode("-", $rss[val]);
$ndate = $d[0]."-".$d[1]."-".$d[2];

				
			##  log หลังทำการบันทึก
			if($t[0] != "salary"){
				$tb1 = $t[0]."$subfix";
				$sql_logupdate = "SELECT count(*) as num_salary FROM log_update WHERE subject LIKE '%ข้อมูลเงินเดือน%' AND username='$rss[idcard]' AND updatetime >= '$ndate' AND action='edit1'  and staff_login='$staff_id'";
				$result_logupdate = mysql_db_query($dbsite,$sql_logupdate);
				$rs_log = mysql_fetch_assoc($result_logupdate);
				$num_add = $rs_log[num_salary];
					if($rs_log[num_salary] > 0){
							$numval[$tb1] += $num_add*$k_point[$tb1];
					}
					
				###  นับจำนวนบรรทัดเงินเดือนทั้งหมด
				$sql_nums = "SELECT COUNT(*) AS nums FROM salary WHERE id='$rss[idcard]'";
				$result_s = mysql_db_query($dbsite,$sql_nums);
				$rs_s = mysql_fetch_assoc($result_s);
				$nums = $rs_s[nums];
				$limit1 = $nums-$num_add;
				
				###  คำนวณข้อมูลเงินเดือนที่เกิดจากการแก้ไข
				$sql_s1 = "SELECT * FROM salary WHERE id='$rss[idcard]' ORDER BY runno DESC LIMIT $limit1,$limit1";
				$result_s1 = mysql_db_query($dbsite,$sql_s1);
				while($rss1 = mysql_fetch_assoc($result_s1)){
					if($rss1[lv] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[order_type] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[schoolid] > 0){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}
					if($rss1[school_label] != ""){
							$numval[$tb1] += 1*	$price_point[$tb1];
					}//end if($rss1[school_label] != ""){
					
				}//end while($rss1 = mysql_fetch_assoc($result_s1)){
				
			}//end if($t[0] != "salary"){
		
		############ ส่วนของการลา
		if($t[0] == "hr_absent"){
		$tb1 = $t[0]."$subfix";
				$sql_logupdate1 = "SELECT count(*) as num_absent FROM hr_absent WHERE subject LIKE '%ข้อมูลจำนวนวันลาหยุด%' AND username='$rss[idcard]' AND updatetime >= '$ndate' AND action='add'  and staff_login='$staff_id'";
				$result_logupdate1 = mysql_db_query($dbsite,$sql_logupdate1);
				$rs_log1 = mysql_fetch_assoc($result_logupdate1);
				$num_add1 = $rs_log1[num_absent];
					if($num_add1 > 0){
							$numval[$tb1] += $num_add1*$k_point[$tb1];
					}//end 	if($rs_log1[num_salary] > 0){
					
		}//end if($t[0] == ""){
##################  คำนวณจาก ตารางที่มีรหัสเป็น gen_id ##################################################
	#####  การศึกษา
	if($t[0] == "graduate"){
		$tb1 = $t[0]."$subfix";
				$sql_logupdate2 = "SELECT count(*) as num_graduate FROM graduate WHERE subject LIKE '%ข้อมูลการศึกษา%' AND username='$rss[idcard]' AND updatetime >= '$ndate' AND action='edit'  and staff_login='$staff_id'";
				$result_logupdate2 = mysql_db_query($dbsite,$result_logupdate2);
				$rs_log2 = mysql_fetch_assoc($result_logupdate2);
				$num_add2 = $rs_log2[num_graduate];
					if($num_add2 > 0){
							$numval[$tb1] += $num_add2*$k_point[$tb1];
					}//end 	if($rs_log1[num_salary] > 0){
	
	}//end if($t[0] == "graduate"){


###############################   end 	
}//end while($rss  = mysql_fetch_assoc($results)){
	
echo "<pre>";
print_r($numval);

	return  array_sum($numval);
}//end function 


echo CalMoneySubV2("10039","5650600015489","TK-255212281649350");

 ?>