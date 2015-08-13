<?
### SMS config
$sms_mode='on'; // เปิดระบบการส่ง sms 
$sms_host="www.sms.in.th";
$sms_method="POST";
$sms_path="/tunnel/sendsms.php";

$sms_RefNo="1001";//1001-9999
$sms_MsgType="T";
$sms_Sender="sys_alert";
$sms_User="sapphire";
$sms_Password="es53y7h";
$sms_defualt_mobile="0861860538";
### SMS config

## SMS FUNCTION
Function sendRequest($host,$method,$path,$data){
	//$method = strtoupper($method);	
	$fp = fsockopen($host, 80);
	fputs($fp, "$method $path HTTP/1.1\r\n");
	fputs($fp, "Host: $host\r\n");
	fputs($fp,"Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: " . strlen($data) . "\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	if ($method == 'POST'){
		fputs($fp, $data);
	}
	while (!feof($fp)){
		$result .= fgets($fp,128);
	}
	fclose($fp);
	return $result;
}

function gwStatus($raw_socket_return) {
	$raw_socket_return = trim($raw_socket_return);
	$socket_status = "";
	$socket_return = explode("\n", $raw_socket_return);
	$count = count($socket_return);
	$iresult = $count-1;
	$socket_status = $socket_return[$iresult];
	return $socket_status;
}
### END SMS FUNCTION
//$sms_status=gwStatus($result_sms);		

function SendSMS2db($sms_Msn,$sms_Msg) {
	global $sms_host,$sms_method,$sms_path,$sms_RefNo,$sms_Sender,$sms_MsgType,$sms_User,$sms_Password,$dbname;

	$Msg=$sms_Msg;
	$Msn=$sms_Msn;

	echo " <div>SMS to $Msn</div>";

	$host=$sms_host;
	$method=$sms_method;
	$path=$sms_path;
	$RefNo=$sms_RefNo;
	$Sender=$sms_Sender;
	$MsgType=$sms_MsgType;
	$User=$sms_User;
	$Password=$sms_Password;
	
	$arr_TEL = explode(',',$sms_Msn);
	
	foreach($arr_TEL as $key => $val){
		$result_sms = sendRequest($host,$method,$path,'RefNo='.$RefNo.'&Sender='.$Sender.'&Msn='.$val.'&Msg='.$Msg.'&MsgType='.$MsgType.'&User='.$User.'&Password='.$Password);
	}

	$sms_status=gwStatus($result_sms);	

	$sql_sms_log="
	INSERT INTO `tbl_sms_log` SET
		`sms_refno`='$RefNo',
		`sms_from`='$Sender',
		`sms_to`='$Msn',
		`sms_status`='$sms_status',
		`sms_type`='$MsgType',
		`sms_text`='$Msg',					
		`sms_application`='$appid'
		";
	$result_sms_log = @mysql_db_query($dbname,$sql_sms_log);
}

function mail_daily_request($Title,$TO,$FROM,$MSG,$refid=''){
		global $PHP_SELF;
		require_once("class.phpmailer.php");		
		$msg .= "
			<head>
			<title> HTML content</title>
			</head>
			<body>".ereg_replace(chr(13),"<br>", $MSG)."</body>
			</html>
		";
		$from = $FROM;
		$to = $TO;
		
		$subject = iconv('TIS-620', 'UTF-8',$Title);
		$msg = iconv('TIS-620', 'UTF-8',$msg);

		$body = $msg;
		
		$host = "mail.sapphire.co.th"; 
		$username = "epm@sapphire.co.th";
		$password = "sapphire";
		$content=" text/html; charset=utf-8";

		###################### NEW MAILLER 5.1
		$mail = new PHPMailer();
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		
		$mail->CharSet ="utf-8";
		$mail->IsSMTP();
		$mail->Host ="mail.sapphire.co.th";
		$mail->Port=25;
		
		$mail->Username = $username;  // SMTP username
		$mail->Password = $password; // SMTP password
		
		$mail->From = "$from";
		$mail->FromName = "COST SAPPHIRE R&D";
		$mail->AddAddress("$to");
		$mail->AddReplyTo("$from");
		
		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = "$subject";
		$mail->Body    = "$msg";
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
		//echo "$subject"."$msg";
		
//		if(!$mail->Send())
//		{
//		   echo "Message could not be sent. <p>";
//		   echo "Mailer Error: " . $mail->ErrorInfo;
//		   exit;
//		}
		###################### END MAILLER 5.1
		
		 $sending_status = !$mail->Send() ? "failed" : "complete";
		
		### บันทึก
		$page=basename("$PHP_SELF");
		$strSQL="
		INSERT INTO `tbl_mail_log` SET 
		`mail_from`='$FROM',
		`mail_refid`='$refid',
		`mail_to`='$TO',
		`mail_title`='$Title',
		`mail_text`='$MSG',
		`mail_application`='$page',
		`mail_status`='$sending_status'
		";
		@mysql_query($strSQL);
		//echo "<pre>$FROM, $subject, $msg, $headers, $refid"; die;
		
		return $sending_status;
}
function call_owner_trip($tripid){
	$strSQL="
		SELECT
		*
		FROM
		trip
		Inner Join cos_user ON trip.userid = cos_user.userid
		WHERE
		trip.tripid =  '$tripid'
		limit 1
	";
	$result = mysql_query($strSQL);
	$Row_nfo = mysql_fetch_assoc($result);
	
	return $Row_nfo;
}
?>