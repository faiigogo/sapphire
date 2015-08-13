<?

//Swap date format in 2006-06-12 to 12/06/2006
function swapdate($temp){
	$kwd = strrpos($temp, "/");
	if($kwd != ""){
		$d = explode("/", $temp);
		$ndate = $d[2]."-".$d[1]."-".$d[0];
	} else { 		
		$d = explode("-", $temp);
		$ndate = $d[2]."/".$d[1]."/".$d[0];
	}
	return $ndate;
}

//function ที่ใช้แสดงวันที่แบบเต็ม ใช้ใน edocument
function daythai($temp){
	if($temp != "0000-00-00"){
	
		$month 	= array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); 
		$num 	= explode("-", $temp);			
		if($num[0] == "0000"){
		  $date 	= "ไม่ระบุ";
		} else {
		  $tyear = $num[0] +  543;
		  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
		}
	
	} else {
		$date = "ไม่ระบุ";
	}	
		return $date;
}

function shortday($temp){
	if($temp != "0000-00-00"){
	
		$month 	= array("ม.ค.", "ก.พ.", "มี.ค.", "ม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); 
		$num 	= explode("-", $temp);			
		if($num[0] == "0000"){
		  $date 	= "ไม่ระบุ";
		} else {
		  $tyear = $num[0] +  543;
		  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
		}
	
	} else {
		$date = "ไม่ระบุ";
	}	
		return $date;
}

//function ที่ใช้แสดงวันที่แบบเต็ม
function fulldate($temp){
	$date = explode(" ", $temp);
	$temp = $date[0];
	$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$num = explode("-", $temp);		
	$day = $num[2];
	$tyear = $num[0] + 543;
	$date = "<font class=\"normal_black\">".$day."</font>&nbsp;".$month[$num[1] - 1 ]."&nbsp;พ.ศ.&nbsp;<font class=\"normal_black\">".$tyear."</font>";	
	return $date;
}

function remove_zero($temp){
	$num_chk = strlen($temp);
	if($num_chk == 2) {	
		$num_1 = substr($temp, 0, 1);  
		if($num_1 == 0){ 
			$rnum = substr($temp, 1, 2); 
		} else { 
			$rnum = $temp; 
		}
	} else { 
	$rnum = $temp; 
	}
	return $rnum;
}

function add_zero($temp){
	$num_chk = strlen($temp);
	if($num_chk == 1) {	
		$rnum = "0".$temp;
	} else {
		$rnum = $temp;
	}
	return $rnum;
}

//Function Delete File
function del_file($temp){
	if(file_exists($temp)){ unlink($temp); }
}

//Function check file exist
function chk_file($file_name, $folder){
	if(file_exists($folder.$file_name)){ 
		
		$f 				= explode(".", $file_name);
		$f_name 	= $f[0];	
		$f_ext 		= $f[1];		

		//find number in () 
		$f_otag 		= (strrpos($f[0], "(") + 1);	
		$f_ctag 		= (strrpos($f[0], ")") - $f_otag) ;		
		$f_num		= substr($f_name, $f_otag, $f_ctag);
		
		//if is number just increse it 		
		if(is_numeric($f_num)){ 	
			$filename 	= substr($f[0],0, strrpos($f[0], "("))."(".($f_num + 1).").".$f[1];					
		} else { 
			$filename 	= $f[0]."(1).".$f[1]; 
		}
		
	} else {	 
			$filename 		= $file_name; 
	}
		
return $filename;	
}

//Random Generater
function random($length){
	
	$template = "1234567890abcdefghijklmnopqrstuvwxyz";  
    
	settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
    	$b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

// function ที่ใช้แสดงรายละเอียดต่าง ๆ ของ files ที่จะทำการ upload
function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

//Use in AJAX for decode
function post_decode($string) {
	$str = $string;
    $res = "";
    for ($i = 0; $i < strlen($str); $i++) {
    	if (ord($str[$i]) == 224) {
        	$unicode = ord($str[$i+2]) & 0x3F;
            $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
            $unicode |= (ord($str[$i]) & 0x0F) << 12;
            $res .= chr($unicode-0x0E00+0xA0);
            $i += 2;
       	} else {
            $res .= $str[$i];
        }
	}
    return $res;
}

function cpdate($First, $Second)
{

	$first_date 			= explode ("-", $First);
	$second_date 		= explode ("-", $Second);

	$intFirstDay 			= $first_date[2];
	$intFirstMonth 		= $first_date[1];
	$intFirstYear 			= $first_date[0];

	$intSecondDay 		= $second_date[2];
	$intSecondMonth	= $second_date[1];
	$intSecondYear 		= $second_date[0];

	$intDate1Jul 			= gregoriantojd($intFirstMonth, $intFirstDay, $intFirstYear);
	$intDate2Jul 			= gregoriantojd($intSecondMonth, $intSecondDay, $intSecondYear);

$diff_date 	= $intDate1Jul - $intDate2Jul + 1;
//$diff_date	= ($diff_date <= 0) ? "<font color=red>".abs($diff_date)."</font>" : "<font color=green>".$diff_date."<font>";
$diff_date	= ($diff_date <= 0) ? "<font color=red>".($diff_date)."</font>" : "<font color=green>".$diff_date."<font>";
return $diff_date;
}

function swapyear($temp, $lang){
	if($temp != ""){
		
		$d	 		= explode("-", $temp);
		$year	= ($lang == "t") ? $d[0] + 543 : $d[0] - 543 ;
		return $year."-".$d[1]."-".$d[2];	
	} else {
		return false;
	}
}

//Function Trim data
function trimtxt($temp, $val){

	$txtchk = strlen($temp);
	if($txtchk > $val){ 	
		$txt= substr($temp,0 ,$val); 
		$txt = $txt."...";		
	} else { 
		$txt = $temp; 
	}
	return $txt;
}

function smtp_mail($title_name,$email_to,$email_from,$msgtext,$refid=''){
	global $PHP_SELF;
	//require_once "Mail.php";
	require_once("class.phpmailer.php");
	//$msg= "MIME-Version: 1.0\r\n";
	//$msg .= "Content-type: text/html; charset=tis-612\r\n"; 
	$msg .= "
		<head>
		<title> HTML content</title>
		</head>
		<body>".ereg_replace(chr(13),"<br>", $msgtext)."</body>
		</html>
	";
	$from = $email_from;
	$to = $email_to;
	
	$subject = iconv('TIS-620', 'UTF-8',$title_name);
	$msg = iconv('TIS-620', 'UTF-8',$msg);
	
	//$subject = $title_name;
	$body = $msg;
	$host = "mail.sapphire.co.th"; 
	$username = "epm@sapphire.co.th";
	$password = "sapphire";
	$content=" text/html; charset=utf-8";

	###################### NEW MAILLER 5.1
	$mail = new PHPMailer();
	$mail->IsSMTP();                    			// set mailer to use SMTP
	$mail->CharSet ="utf-8";
	$mail->IsSMTP();
	$mail->Host ="mail.sapphire.co.th";
	$mail->Port=25;
	
	$mail->Username = $username;  		// SMTP username
	$mail->Password = $password; 			// SMTP password
	
	$mail->From = "$from";
	$mail->FromName = "EPM SAPPHIRE R&D";
	$mail->AddAddress("$to");
	$mail->AddReplyTo("$from");
	
	$mail->WordWrap = 50;                   // set word wrap to 50 characters
	$mail->IsHTML(true);                       // set email format to HTML
	
	$mail->Subject = "$subject";
	$mail->Body    = "$msg";
	//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
	//echo "$subject"."$msg";
	if(!$mail->Send()){
	   echo "Message could not be sent. <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}
###################### END MAILLER 5.1
	### บันทึก
	$page=basename("$PHP_SELF");
	$strSQL="
	INSERT INTO `tbl_mail_log` SET 
		`mail_from`='$email_from',
		`mail_refid`='$refid',
		`mail_to`='$email_to',
		`mail_title`='$subject',
		`mail_text`='$msgtext',
		`mail_application`='$page'
		`mail_status`='$result_mail'
	";
	//@mysql_query($strSQL);
	//echo "<pre>$email_from, $subject, $msg, $headers, $refid"; die;
}

if (!function_exists('date_parse')) {
	function date_parse($xdate){
			$arrX = explode("-",$xdate);
			//echo $xdate;

			$retX['day'] = $arrX[2];
			$retX['month'] = $arrX[1];
			$retX['year'] = $arrX[0];
			
			return $retX ;
	}
}

function dateDiff($startDate, $endDate)
{
    // Parse dates for conversion
    $startArry = date_parse($startDate);
    $endArry = date_parse($endDate);

    // Convert dates to Julian Days
    $start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
    $end_date  = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);

    // Return difference
    return round(($end_date - $start_date), 0);
} 

function holidate($start_date,$end_date){	
		$diffdate = dateDiff($start_date,$end_date);
		//$diffdate = $diffdate > 0 ? $diffdate -1 : $diffdate;		
		$holiday[num]= 0; 
		for( $i=0;$i<$diffdate;$i++){
			//$mktime = strtotime( $start_date , "+1 day");
			$mktime = strtotime($start_date . " + $i days");
			if( date("D",$mktime) == "Sun" || date("D",$mktime) == "Sat"){
				$holiday[num]++;
				$holiday[]=date("Y-m-d",$mktime);
			}
		}		
		$strSQL = " SELECT * FROM epm.`epm_holiday_common` Where ( date_value between '$start_date' AND '$end_date' ) ";
		$Result = mysql_query($strSQL);
		$diffdate = ( @mysql_num_rows($Result) >0 ) ? $diffdate - @mysql_num_rows($Result) : $diffdate ;		
		# โชววันหยุด
		if( @mysql_num_rows($Result) >0 ){
			while($row_holiday = mysql_fetch_assoc($Result)){
				$holiday[] = $row_holiday[date_value];
			}	
		}		
		//echo "<pre>"; print_r($holiday); echo "</pre>";
		
		$diffdate = $diffdate - $holiday[num];
		
		return $diffdate;
}

function trip_diffdate($start_date="",$end_date=""){	
	if($start_date && $end_date ){	
		$start_date2 = $start_date;
		$start_date   = $start_date < $end_date ? $start_date   : $end_date ;
		$end_date    = $start_date2 > $end_date ? $start_date2 : $end_date ;		
		//$diffdate	   = dateDiff($start_date,$end_date);
		$diffdate = holidate($start_date,$end_date); 			
	}else{
		$diffdate=0;	
	}	
	return $diffdate;
}
?>