<script language="JavaScript" type="text/javascript"> 
<!-- Hidden Status Bar -->
function hidestatus(){
window.status=''
return true
}

if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)

document.onmouseover=hidestatus
document.onmouseout=hidestatus
<!-- End Hidden Status Bar -->

function closewin() {
window.opener.location.reload();
self.close();
}

function mOvr(src,clrOver){ 
if (!src.contains(event.fromElement)){ 
src.style.cursor = 'hand'; 
src.bgColor = clrOver; 
} 
} 

function mOut(src,clrIn){ 
if (!src.contains(event.toElement)){ 
src.style.cursor = 'default'; 
src.bgColor = clrIn; 
} 
} 

function MM_openBrWindow(theURL,winName,features) {
  window.open(theURL,winName,features);
}

function jumpmenu()
{

	var url = document.menu.submenu.value;
	window.location.href = url;

}
</script>
<?
//Send e-Document
function senddoc($subject, $message, $receive, $sender){

	$stamp = date("Y-m-d H:i:s"); 
	$message = trim($message);	
	$message = CheckTag($message);

	$sql = "insert into edocument set subject = '$subject', message = '$message', owner='$sender', receive = '$receive', timesend='$stamp'";	
	$result = mysql_query($sql)or die("Query Line " . __LINE__ . " error<hr>".mysql_error());
	$docid = mysql_insert_id();
	if($receive != ""){			
	$people = explode("," , $receive);	
		for($i = 0;$i<count($people);$i++){			
				$ssql = mysql_query("insert into edoc_receive set docid = '$docid', userid = '$people[$i]', status = '0', folderid = '1' ")or die("Query Line " . __LINE__ . " error<hr>".mysql_error());
		}
	}			
	$scp = "<script language=\"JavaScript\">";
	$scp = $scp."win=window.open(\"edoc_popup.php\",\"popup\",\"height=100,width=300,left=150,top=150\");";
	$scp = $scp."window.focus();";
	$scp = $scp."</script>";
	return $scp;
	
}

//Swap date format in 2006-06-12 to 12/06/2006

function swapdate($temp){

	$kwd = strrpos($temp, "/");
	if($kwd != ""){
		$d = explode("/", $temp);
		$ndate = $d[2]."-".$d[1]."-".$d[0];
	} else { 		
		$d = explode("-", $temp);
		$ndate = $d[2]."/".$d[1]."/".($d[0]);
	}
	
	return $ndate;
	
}


//Del from server when not complete sending
function sendchk($temp, $arr){
	if($temp == "n"){
		for($i = 0; $i < count($arr); $i++){
		if(file_exists("../file_temp/edocument/".$arr[$i])){ unlink("../file_temp/edocument/".$arr[$i]); }
		}
		$status = "y";
	} else { 
		$status = $temp;
	}
	return $status;
}

//Function Check Attachment is exist
function chkattach($temp){
	if(file_exists($temp)){
		$dl = "<a href=\"$temp\" style=\"text-decoration:none\"><img src=\"../images/web/attach.gif\" height=\"13\" width=\"12\" border=\"0\" align=\"absmiddle\"></a>&nbsp;";
	} else {
		$dl = "";
	}
	return $dl;
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

//Function Delete File
function delfile($temp){
	if(file_exists($temp)){ unlink($temp); }
}

//Image border
function frameimg($temp){

	$fr = "<table width=\"50\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">";
    $fr = $fr."<tr>";
    $fr = $fr."<td height=\"7\"><img src=\"images/web/border01.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."<td width=\"50\" height=\"7\" background=\"images/web/border04.gif\"><img src=\"images/web/border04.gif\" height=\"7\" /></td>";
    $fr = $fr."<td height=\"7\"><img src=\"images/web/border06.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."</tr>";
    $fr = $fr."<tr>";
    $fr = $fr."<td width=\"7\" background=\"images/web/border02.gif\"></td>";
    $fr = $fr."<td width=\"50\">".$temp."</td>";
    $fr = $fr."<td width=\"7\" background=\"images/web/border07.gif\"></td>";
    $fr = $fr."</tr>";
	$fr = $fr."<tr>";
	$fr = $fr."<td width=\"7\" height=\"7\"><img src=\"images/web/border03.gif\" width=\"7\" height=\"7\" /></td>";
	$fr = $fr."<td width=\"50\" height=\"7\" background=\"images/web/border05.gif\"><img src=\"images/web/border05.gif\" height=\"7\" /></td>";
    $fr = $fr."<td width=\"7\" height=\"7\"><img src=\"images/web/border08.gif\" width=\"7\" height=\"7\" /></td>";
    $fr = $fr."</tr>";
    $fr = $fr."</table>";
	
	return $fr;
}

//Function Attach Status
function attach_status($temp){
	$display = "<link href=\"../libary/style.css\" rel=\"stylesheet\" type=\"text/css\">";
	$display = $display."<table width=\"370\" height=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td><div align=\"center\">";
	$display = $display."<table width=\"302\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#eeeeee\"><tr bgcolor=\"#f8f8f8\"><td height=\"120\" valign=\"top\">";
	$display = $display."<table width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr bgcolor=\"#eeeeee\"><td height=\"20\" class=\"normal_blue\">&nbsp;<img src=\"../images/web/arrow.gif\" align=\"absmiddle\">&nbsp;<b>กำลังดำเนินการ</b></td></tr>";
	$display = $display."<tr class=\"normal\"><td height=\"100\"><div align=\"center\">".$temp."</div></td></tr>";
	$display = $display."</table>";
	$display = $display."</td></tr></table>";
	$display = $display."</div></td></tr></table>";
	return $display;
}

//Change attach file for download
function tag_download($temp){
	
	if($temp != ""){
		$single = explode(",", $temp);
		for($i = 0; $i < count($single); $i++){
			$narray[$i] = " <a href=\"../file_temp/edocument/".$single[$i]."\" style=\"text-decoration:none\"><font class=\"normal_blue\">".$single[$i]."</font></a>"; 
		}	
		$output = implode(",", $narray);
	} else {
		$output = $temp;
	}
	
return $output;	
}

//Function check file exist
function chk_filename($temp, $fdr){

	$file = $fdr.$temp;
	if(file_exists($file)){ 
		
		$fn = explode(".", $temp);
		$f_name = $fn[0];	
		$f_ext = $fn[1];		

		//find number in () 
		$f_otag = (strrpos($fn[0], "(" ) + 1);
		$f_ctag = ((strlen($fn[0]) - 1) - $f_otag);
		$f_numeric = substr($f_name, $f_otag, $f_ctag);
		
		//if is number just increse it 		
		if(is_numeric($f_numeric)){ 
			
			$f_numeric = $f_numeric + 1;
			$f_name = substr($f_name, 0, ($f_otag - 1 ));
			$filename = substr($fn[0],0, ($f_otag - 1))."(".$f_numeric.").".$fn[1];		
			
		} else { $filename = $fn[0]."(1).".$fn[1]; }
	} else { 	$filename = $temp; }
		
return $filename;	
}

//Document Status
function docstatus($temp)
{
	if($temp == 0){ $pic = "../images/web/f_unread.gif"; } 
	elseif($temp == 1){ $pic = "../images/web/f_read.gif"; } 
	elseif($temp == 2){ $pic = "../images/web/f_urgent_read.gif"; } 
	elseif($temp == 3){ $pic = "../images/web/f_fwd.gif"; } 
	else{ $pic = "../images/web/f_fwd.gif"; }
	$img = "<img src=\"$pic\" width=\"18\" height=\"12\" border=\"0\">";
	return $img;	
}

//ตัดค่า array พร้อมกับเรียงข้อมูลใหม่
function array_trim($arr, $indice)
{ 
	if(!isset($arr[$indice])) { 
       unset($arr[$indice]); 
     } 
     array_shift($arr); 
     return $arr; 
} 

//แสดงดาวออกมาจาก database
function rate($temp)
{
	$img = "images/web/star.gif";
	if(file_exists($img)){ $img = "<img src=\"images/web/star.gif\" border=\"0\">"; }else{ $img = "<img src=\"../images/web/star.gif\" border=\"0\">"; }
	for($i = 1;$i <= $temp; $i++){
	$imgs = "$img".$imgs;
	}
	return $imgs;
}

function remove_zero($temp) 
{
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

function add_zero($temp) 
{
	$num_chk = strlen($temp);
	if($num_chk == 1) {	
		$rnum = "0".$temp;
	} else {
		$rnum = $temp;
	}
	return $rnum;
}

//Show Telephone number
function showtel($temp){
	$t = strlen($temp);
	if($t == 10){
		$t1 = substr($temp, 0, 3);
		$t2 = substr($temp, 3, 3);
		$t3 = substr($temp, 6, 4);
		$tel = $t1."-".$t2."-".$t3;
	} elseif($t == 9) {
		$t1 = substr($temp, 0, 2);
		$t2 = substr($temp, 2, 3);
		$t3 = substr($temp, 5, 4);
		$tel = $t1."-".$t2."-".$t3;
	} else {
 		$tel = $temp;
	}
return $tel;
}


//Show full time
function fulltime($temp){
	$t = explode(":", $temp);
	if($t[1] == 00){ 
		$time = remove_zero($t[0])." นาฬิกา ";
	} else {
		$time = remove_zero($t[0])." นาฬิกา ".remove_zero($t[1])." นาที";
	}
	return $time;
}

//function ที่ใช้แสดงวันที่แบบเต็ม ใช้ใน edocument
function daythai($temp)
{
	//$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$month = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$num = explode("-", $temp);			
	if($num[0] == "0000"){
	  $date = "ไม่ระบุ";
	} else {
	  $tyear = $num[0] +543;
	  $date = remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}
	return $date;
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

// function ที่ใช้แสดงช่องว่าง และเว้นบรรทัด
function detail($temp)
{
	$temp = ereg_replace("  " ,"&nbsp;" ,$temp);
	$temp = ereg_replace(chr(13) ,"<br>" ,$temp);
	return $temp;
}

function RewindTag($temp){		
	$temp = ereg_replace ("  " ,"&nbsp;" ,$temp);				
	$temp = eregi_replace ( "<b>", "[b]" , $temp ) ;
	$temp = eregi_replace ( "</b>", "[/b]" , $temp ) ;
	$temp = eregi_replace ( "<i>", "[i]" , $temp ) ;
	$temp = eregi_replace ( "</i>", "[/i]" , $temp ) ;
	$temp = eregi_replace ( "<u>", "[u]" , $temp ) ;
	$temp = eregi_replace ( "</u>", "[/u]" , $temp ) ;
	$temp = eregi_replace ( "<a href=\"\\1\" target=\"_blank\" style=\"color:#3366FF\">\\1</a>", "\[url\]([^\[]+)\[/url\]", $temp);
	$temp = eregi_replace ( "<font color=\"red\">" , "[color=red]" , $temp ) ;
	$temp = eregi_replace ( "<font color=\"green\">" , "[color=green]" , $temp ) ;
	$temp = eregi_replace ( "<font color=\"0280D5\">" , "[color=blue]" , $temp ) ;
	$temp = eregi_replace ( "<font color=\"F7941D\">" , "[color=orange]" , $temp ) ;
	$temp = eregi_replace ( "<font color=\"ff00ff\">" , "[color=pink]" , $temp ) ;	
	$temp = eregi_replace ( "<font color=\"993300\">" , "[color=brown]" , $temp ) ;	
	$temp = eregi_replace ( "<font color=\"olive\">", "[color=olive]", $temp ) ;
	$temp = eregi_replace ( "<font color=\"001D9A\">", "[color=darkblue]"  , $temp ) ;
	$temp = eregi_replace ( "</font>" , "[/color]", $temp ) ;				
	$temp = eregi_replace ( "<font style=\"font-size:9px\">", "[size=9]"  , $temp ) ;
	$temp = eregi_replace ( "<font style=\"font-size:12px\"'>", "[size=12]"  , $temp ) ;
	$temp = eregi_replace ( "<font style=\"font-size:16px\">", "[size=16]"  , $temp ) ;		
	$temp = eregi_replace ( "</font >" , "[/size]", $temp ) ;		
	return ( $temp ) ;
}	

function CheckTag($temp){		
	$temp = eregi_replace ( "<script", "&lt;script" , $temp ) ;
	$temp = eregi_replace ( "</script>", "&lt;/script&gt;" , $temp ) ;
	$temp = eregi_replace ( "<meta", "&lt;meta" , $temp ) ;
	$temp = eregi_replace ( "<link", "&lt;link" , $temp ) ;
	$temp = eregi_replace ( "<embed", "&lt;embed" , $temp ) ;
	$temp = eregi_replace ( "</embed>", "&lt;/embed&gt;" , $temp ) ;		

	//สำหรับเปลี่ยนอักขระที่กำหนด ให้เป็นแทก html ต่างๆ						
	$temp = ereg_replace ("  " ,"&nbsp;" ,$temp);		
	$temp = eregi_replace ( "<" , "&lt;" , $temp ) ;
	$temp = eregi_replace ( ">" , "&gt;" , $temp ) ;	   
	$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
	$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
	$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
	$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
	$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
	$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
	$temp = eregi_replace ("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\" style=\"color:#3366FF\">\\1</a>",$temp);
	$temp = eregi_replace ( "\[color=red]", "<font color=\"red\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=green]", "<font color=\"green\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=blue]", "<font color=\"0280D5\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=orange]", "<font color=\"F7941D\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=pink]", "<font color=\"FF00FF\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=brown]", "<font color=\"993300\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=olive]", "<font color=\"olive\">" , $temp ) ;
	$temp = eregi_replace ( "\[color=darkblue]", "<font color=\"001D9A\">" , $temp ) ;
	$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
	$temp = eregi_replace ( "\[size=9]", "<font style=\"font-size:9px\">" , $temp ) ;
	$temp = eregi_replace ( "\[size=12]", "<font style=\"font-size:12px\">" , $temp ) ;
	$temp = eregi_replace ( "\[size=16]", "<font style=\"font-size:16px\">" , $temp ) ;
	$temp = eregi_replace ( "\[/size\]", "</font >" , $temp ) ;
	return ( $temp ) ;
}

//----------------------------MD5 Encoding--------------------------------//	
function get_rnd_iv($iv_len)
{
   $iv = '';
   while ($iv_len-- > 0) {
       $iv .= chr(mt_rand() & 0xff);
   }
   return $iv;
}

function md5_encrypt($plain_text, $password, $iv_len = 16)
{
   $plain_text .= "\x13";
   $n = strlen($plain_text);
   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
   $i = 0;
   $enc_text = get_rnd_iv($iv_len);
   $iv = substr($password ^ $enc_text, 0, 512);
   while ($i < $n) {
       $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
       $enc_text .= $block;
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   return base64_encode($enc_text);
}

function md5_decrypt($enc_text, $password, $iv_len = 16)
{
   $enc_text = base64_decode($enc_text);
   $n = strlen($enc_text);
   $i = $iv_len;
   $plain_text = '';
   $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
   while ($i < $n) {
       $block = substr($enc_text, $i, 16);
       $plain_text .= $block ^ pack('H*', md5($iv));
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}

//เปลี่ยนข้อมูลที่โพสมาจาก AJAX จาก UTF-8 เป็น TIS-620
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

function trip_status($tripid){
	if($tripid){
				$trip = 0;
				$closed = $ended = $cleared = true;
				$sqlcheck = "select * from list  where tripid='$tripid' ; ";
				$resultcheck = mysql_query($sqlcheck);
				$resultnum = mysql_num_rows($resultcheck);
				while ($rscheck=mysql_fetch_array($resultcheck,MYSQL_ASSOC)) {
					if ($rscheck["close"] != "y" && $rs["close"] != "y" )  $closed = false;
					if ($rscheck["endtrip"] != "y")  $ended = false;
					if ($rscheck["cleartrip"] != "y")  $cleared = false;
				}
				
				if ($resultnum == "0" ){
					//echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
					$sql = "UPDATE `trip` SET `trip_status`='1' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);	
				}else if ($closed){
					//echo "<img src=\"images/promo_violet.png\" alt=\"สรุปค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					$sql = "UPDATE `trip` SET `trip_status`='4' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);
				}else if ($cleared){
					//echo "<img src=\"images/promo_green.png\" alt=\"ผ่านการตรวจรับเอกสารรอการอนุมัติ\" width=\"24\" height=\"24\">";
					$sql = "UPDATE `trip` SET `trip_status`='3' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);
				}else if ($ended){
					//echo "<img src=\"images/promo_orange.png\" alt=\"บันทึกรายการค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
					$sql = "UPDATE `trip` SET `trip_status`='2' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);
				}else{
					//echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
					$sql = "UPDATE `trip` SET `trip_status`='1' WHERE (`tripid`='$tripid')   ";
					@mysql_query($sql);
				}	
	}
}
?> 
