<script language="JavaScript" type="text/javascript"> 
var xmlHttp = XmlHttpRequestObject();
function XmlHttpRequestObject()
{ 
	var objXmlHttp = null
	if (navigator.userAgent.indexOf("Opera")>=0)
	{
		alert("Error creating the XMLHttpRequest object.") 
		return 
	}

	if (navigator.userAgent.indexOf("MSIE")>=0)
	{ 
		var strName	="MSXML2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
			strName="Microsoft.XMLHTTP"
		} try { 
			objXmlHttp	= new ActiveXObject(strName)
			return objXmlHttp
		} catch(e) { 
			alert("Error. Scripting for ActiveX might be disabled") 
			return 
		} 
	} 

	if (navigator.userAgent.indexOf("Mozilla")>=0)
	{
		objXmlHttp				= new XMLHttpRequest()
		objXmlHttp.onload	= handler
		objXmlHttp.onerror	= handler 
		return objXmlHttp
	}
}

<!-- --------------------------------------------------------Hidden Status Bar -->
function hidestatus(){
window.status=''
return true
}

if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)

document.onmouseover	= hidestatus
document.onmouseout	= hidestatus

<!-- --------------------------------------------Flip Color when mouse Over -->
function mOvr(src,clrOver){ 
if (!src.contains(event.fromElement)){ 
src.style.cursor = 'hand'; 
src.bgColor = clrOver; 
} 
} 

<!-- ---------------------------------------------Flip Color when mouse Out -->
function mOut(src,clrIn){ 
if (!src.contains(event.toElement)){ 
src.style.cursor = 'default'; 
src.bgColor = clrIn; 
} 
} 

<!-- ------------------------------------------------------------Check Number -->
function Filter_Keyboard() {
  var keycode = window.event.keyCode;
  if( keycode >=37 && keycode <=40 ) 	return true;  // arrow left, up, right, down  
  if( keycode >=48 && keycode <=57 ) 	return true;  // key 0-9
  if( keycode >=96 && keycode <=105) 	return true;  // numpad 0-9
  if( keycode ==110 || keycode ==190) 	return true;  // dot
  if( keycode ==8) 									return true;  // backspace
  if( keycode ==9) 									return true;  // tab
  if( keycode ==45 ||  keycode ==46 || keycode ==35 || keycode ==36) return true;  // insert, del, end, home
  return false;
}
</script>
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

//function ·ÕèãªéáÊ´§ÇÑ¹·ÕèáººàµçÁ ãªéã¹ edocument
function daythai($temp){
if($temp != "0000-00-00"){

	$month 	= array("Á¡ÃÒ¤Á", "¡ØÁÀÒ¾Ñ¹¸ì", "ÁÕ¹Ò¤Á", "àÁÉÒÂ¹", "¾ÄÉÀÒ¤Á", "ÁÔ¶Ø¹ÒÂ¹", "¡Ã¡®Ò¤Á", "ÊÔ§ËÒ¤Á", "¡Ñ¹ÂÒÂ¹", "µØÅÒ¤Á", "¾ÄÈ¨Ô¡ÒÂ¹", "¸Ñ¹ÇÒ¤Á"); 
	$num 	= explode("-", $temp);			
	if($num[0] == "0000"){
	  $date 	= "äÁèÃÐºØ";
	} else {
	  $tyear = $num[0] +  543;
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}

} else {
	$date = "äÁèÃÐºØ";
}	
	return $date;
}

function shortday($temp){
if($temp != "0000-00-00"){

	$month 	= array("Á.¤.", "¡.¾.", "ÁÕ.¤.", "Á.Â.", "¾.¤.", "ÁÔ.Â.", "¡.¤.", "Ê.¤.", "¡.Â.", "µ.¤.", "¾.Â.", "¸.¤."); 
	$num 	= explode("-", $temp);			
	if($num[0] == "0000"){
	  $date 	= "äÁèÃÐºØ";
	} else {
	  $tyear = $num[0] +  543;
	  $date 	= remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp;".$tyear;	
	}

} else {
	$date = "äÁèÃÐºØ";
}	
	return $date;
}

//function ·ÕèãªéáÊ´§ÇÑ¹·ÕèáººàµçÁ
function fulldate($temp)
{
	$date = explode(" ", $temp);
	$temp = $date[0];
	$month = array("Á¡ÃÒ¤Á", "¡ØÁÀÒ¾Ñ¹¸ì", "ÁÕ¹Ò¤Á", "àÁÉÒÂ¹", "¾ÄÉÀÒ¤Á", "ÁÔ¶Ø¹ÒÂ¹", "¡Ã¡®Ò¤Á", "ÊÔ§ËÒ¤Á", "¡Ñ¹ÂÒÂ¹", "µØÅÒ¤Á", "¾ÄÈ¨Ô¡ÒÂ¹", "¸Ñ¹ÇÒ¤Á");
	$num = explode("-", $temp);		
	$day = $num[2];
	$tyear = $num[0] + 543;
	$date = "<font class=\"normal_black\">".$day."</font>&nbsp;".$month[$num[1] - 1 ]."&nbsp;¾.È.&nbsp;<font class=\"normal_black\">".$tyear."</font>";	
	return $date;
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

function upload($path, $file, $file_name, $type){
$file_ext 	= strtolower(getFileExtension($file_name));		
global $height;
global $width;

if($type == "all"){

	$approve = "y";
	
}elseif($type == "img"){

	$chk_img = ($file_ext != "jpg" and $file_ext != "gif" and $file_ext != "jpeg"  and $file_ext != "png") ? "n" : "y" ;
	if($chk_img == "y"){
	
		$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
		$height 		= (!isset($height) || $height == "") ? 801 : $height ; 
		$img_size 	= GetImageSize($file);  
		
		if(($img_size[0] >= $width) || ($img_size[1] >= $height)) {
			$approve 	= "n";
			$status[0]	= "error_scale";
		}else{
			$approve 	= "y";
		}
		
	} else {
		$approve 	= "n";
		$status[0]	= "error_img";
	}  
	
} elseif($type == "fla") {

		$approve 	= ($file_ext != "swf") ? "n" : "y" ;
	
} elseif($type == "doc") {

	$chk_doc = ($file_ext != "doc" and $file_ext != "xls" and $file_ext != "pdf" and $file_ext != "zip" and $file_ext != "rar") ? "n" : "y" ;
	if($chk_doc == "y"){
		$approve 	= "y";
	} else {
		$approve 	= "n";
		$status[0]	= "error_doc";
	}

} else {

	$approve 	= "n";
	$status[0]	= "error_type";
	
}

/* -------------------------------------------------------------Check file Exists  */
if($type == "doc"){	
	$file_n		= chk_file($file_name, $path);
	$filename	= $path.$file_n;
} elseif($type == "img" || $type == "fla" || $type == "all") {
	$file_n		= random(6).".".$file_ext;
	$filename 	= $path.$file_n;	
}
$status[1] = $file_n;

/* ---------------------------------------------------------Begin Uploading File */
if($approve == "y"){

	if($file_size >= "2000000") {
		$status[0] = "error_size";		
	} else {	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){	 
				$status[0] = "error_upload";
			} else {
				$status[0] = "complete";
			}
			unlink($file);  					
		} else { 	$status[0] = "error_cmod";	}	
	}
	
}	
return $status;

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

//Status of Uploading
function upload_status($temp){
global $height;
global $width;
$button 		= "<hr size=\"1\"><button name=\"button\" style=\"width:90px;\" onClick=\"history.go(-1);\">Back</button>";
$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
$height 		= (!isset($height) || $height == "") ? 801 : $height ; 

	if($temp == "error_scale"){	
		$msg = "<br><b class=\"warn\">Error</b> : ¢¹Ò´¢Í§ÀÒ¾à¡Ô¹¨Ò¡·Õè¡ÓË¹´äÇé<br>¢¹Ò´ÃÙ»ÀÒ¾µéÍ§äÁèà¡Ô¹ $height x $width<br>";		
	} elseif($temp == "error_img") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>ÃÙ»áºº¢Í§ file äÁè¶Ù¡µéÍ§<br>ÃÙ»ÀÒ¾µéÍ§ÁÕ¹ÒÁÊ¡ØÅà»ç¹ jpg, jpeg áÅÐ gif à·èÒ¹Ñé¹<br>";		
	} elseif($temp == "error_type") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>ÃÙ»áºº¢Í§ file ·Õè¹Óà¢éÒÁÒäÁè¶Ù¡µéÍ§<br>";		
	} elseif($temp == "error_size") 	{	
		$msg = "<br><b class=warn>Error</b><br>ÃÙ»¢¹Ò´¢Í§ file ÁÒ¡¡ÇèÒ·ÕèÃÐºº¡ÓË¹´<br>ä¿ÅìµéÍ§ÁÕ¢¹Ò´äÁèà¡Ô¹ 800 Kilo Bytes<br>";
	} elseif($temp == "error_upload") {	
		$msg = "<br><b class=\"warn\">Warning</b><br>¾º¢éÍ¼Ô´¾ÅÒ´ã¹¡ÒÃ Upload à¢éÒÊÙèèÃÐºº<br>â»Ã´µÔ´µèÍ¼Ùé´ÙáÅ<br>";			
	} elseif($temp == "error_cmod")	{	
		$msg = "<br><b class=\"warn\">Warning</b><br>¾º¢éÍ¼Ô´¾ÅÒ´ã¹¡ÒÃ Upload à¢éÒÊÙèèÃÐºº<br>â»Ã´µÃÇ¨ÊÍº CHMOD ¢Í§ Folder<br>";				
	} elseif($temp == "error_doc"){	
		$msg = "<br><b class=\"warn\">Warning</b><br>ÃÙ»áººä¿ÅìäÁè¶Ù¡µéÍ§<br>àÍ¡ÊÒÃµéÍ§ÁÕ¹ÒÁÊ¡ØÅà»ç¹ doc, xls áÅÐ pdf à·èÒ¹Ñé¹<br>";			
	} 
$msg	 = ($msg != "") ? $msg.$button : "" ;
return $msg;
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

// function ·ÕèãªéáÊ´§ÃÒÂÅÐàÍÕÂ´µèÒ§ æ ¢Í§ files ·Õè¨Ð·Ó¡ÒÃ upload
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

// ÊèÇ¹¢Í§¡ÒÃáÊ´§¢éÍÁÙÅ¡ÒÃáºè§Ë¹éÒ
function devide_page($all, $record, $kwd){
$per_page		= 11;
$page_all 		= ceil($all / $per_page);
global $page;

if($all >= 1){

	$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$table	= $table."<tr valign=\"top\" align=\"right\">";
	$table	= $table."<td width=\"80%\" align=\"left\">&nbsp;";
		
//first Eleven Page
if($page <= $per_page){

	$max		=	($all <= $per_page) ? $all : $per_page ; 			
	for($i=1;$i<=$max;$i++) 
	{
		if($i != $page){ 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$i.$kwd."\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}
		
	if($max < $all){ 	
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($i++).$kwd."\" style=\"text-decoration:none;\">></a>&nbsp;"; 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$all.$kwd."\" style=\"text-decoration:none;\">>></a>&nbsp;"; 
	}
	unset($max,$i);
	
} elseif($page > $per_page) {

	$min 	= $page - 5;		
	$max		= (($page + 5) >=  $all) ? $all : $page + 5 ;
	$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=1".$kwd."\" style=\"text-decoration:none;\"><b><<</b></a>&nbsp;";
	$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($min--).$kwd."\" style=\"text-decoration:none;\"><b><</b></a>&nbsp;";
	for($i=$min;$i<=$max;$i++) 
	{
		if($i != $page){ 
			$table	= $table."<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=$i$kwd\" style=\"text-decoration:none;\"><font color=\"blue\">".$i."</font></a>&nbsp;";  
		} else { 
			$table	= $table."<font color=\"red\">".$i."</font>&nbsp;";  
		}
	}	
	
	if($max < $all){
		$table	= $table."&nbsp;<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".($max++).$kwd."\" style=\"text-decoration:none;\"><b>></b></a>";
		$table	= $table."&nbsp;<a href=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&page=".$all.$kwd."\" style=\"text-decoration:none;\"><b>>></b></a>&nbsp;"; 
	}	
}                  
	if ($max > 1){ //¶éÒÁÒ¡¡ÇèÒ 1 Ë¹éÒ
		$table   = $table." <A HREF=\"?mode=$_GET[mode]&vmode=$_GET[vmode]&e=1000000$kwd\" >áÊ´§·Ñé§ËÁ´</A>";
	}

	$table	= $table."</td>";
	$table	= $table."<td width=\"10%\">".number_format($record, 0, "", ",")."&nbsp;ÃÒÂ¡ÒÃ&nbsp;</td>";
	$table	= $table."<td width=\"10%\">".number_format($all, 0, "", ",")."&nbsp;Ë¹éÒ&nbsp;</td>";
	$table	= $table."</tr>";
	$table	= $table."</table>";
}
 	return $table;
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

//Email function
function sendmail($mail_to, $mail_subject, $mail_msg, $mail_from){

	$to 			= $mail_to;
	$subject 	= $mail_subject;
	$msg 		= "
	<head>
	<title> HTML content</title>
	</head>
	<body>".$mail_msg."</body>
	</html>
	";
	$headers 	= "From: ".$mail_from."\n";
	$headers	.= "Reply-To: ".$mail_from."\n";
	$headers	.= "Content-Type: text/html; charset=tis-620"; 
	mail("$to", "$subject", "$msg", "$headers");

}

function showpic($getfile_att,$getproblem,$getproblem_result,$reportid){
	if($getfile_att){
		$msg1 = "<a href=\"daily_file_attach.php?id=$reportid\"><img src=\"images/attach16.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg1 ="";
	}	
	if($getproblem){
		$msg2 = "<a href=\"daily_report_detailview.php?id=$reportid\"><img src=\"../../images_sys/alert.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg2 ="";
	}
	if($getproblem_result){
		$msg3 = "<a href=\"daily_report_detailview.php?id=$reportid\"><img src=\"images/alert_red.gif\" width=\"14\" height=\"14\" border=0></a>";
	}else{
		$msg3 ="";
	}
	$picview = "$msg1|||$msg2|||$msg3";
	return $picview;
}
//-------------------------------------Addtrip
function swapdatedat($rs_time){
	$arrB = explode("-",$rs_time);
	$getdayB=$arrB[2]."/".$arrB[1]."/".$arrB[0];
	return $getdayB;
}

function getUserTrip($tripid=""){
	global $db_name;
	$sql="SELECT userid FROM `trip` WHERE `tripid`='".$tripid."' ";
	$query = mysql_db_query($db_name,$sql);
	$row = mysql_fetch_assoc($query);
	return $row['userid'];
	
}
//-------------------------------------Addtype_project
function thai2sortable($input) { 
$output = ''; 
$rightbuf = ''; 
$len = strlen($input); 

for ($i = 0; $i < $len; $i++) { 
if (is_vowel($input[$i]) && (($i + 1) != $len)) { 
if (!is_vowel($input[$i + 1]) && (!is_tone($input[$i +1]))) { 
$output .= $input[$i + 1]; 
$output .= $input[$i]; 
$i++; 
} 
} 
else if (is_tone($input[$i])) { 
$rightbuf.=sprintf("%02d", $len - $i); 
$rightbuf.=$input[$i]; 
} 
else { 
$output.=$input[$i]; 
} 
} 
return $output."00".$rightbuf; 
} 

function is_tone($c) { 
return ((chr(0xE6) <= ($c)) && (($c) <= chr(0xEC))); 
} 

function is_vowel($c) { 
return ((chr(0xE0) <= ($c)) && (($c) <= chr(0xE4))); 
} 

function th_sort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$i] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$i] = thai2sortable($arr1[$i]); $i++;
}
asort ($arr2); reset ($arr2); $i=0;
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$i++] = $arr1[$key];
}
}

function th_rsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$i] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$i] = thai2sortable($arr1[$i]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[]= $arr1[$key];
}
$thai_array = array_reverse($arr3);
}

function th_asort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($arr1[$key]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$key] = $arr1[$key];
}
}
function th_arsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($arr1[$key]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[$key]= $arr1[$key];
}
$thai_array = array_reverse($arr3,TRUE);
}

function th_ksort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($key); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$key] = $arr1[$key];
}
}

function th_krsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($key); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[$key]= $arr1[$key];
}
$thai_array = array_reverse($arr3,TRUE);
}
//-------------------------------------------ajax_project_type
//$arr_type = array("project"=>"â¤Ã§¡ÒÃ","presale"=>"Presale","office"=>"ÍÍ¿¿ÔÈ","marketing"=>"µÅÒ´","RD"=>"ÇÔ¨ÑÂ¾Ñ²¹Ò");
function LimitText($s, $n) {
    if (strlen($s) > $n) {
        $s = substr($s, 0, $n) . "...";
    }
    return $s;
}
//------------------------------------------calendar
/* ¿Ñ§¡ìªÑè¹ LastDay() ãªéÊÓËÃÑºËÒÇÑ¹·ÕèÊØ´·éÒÂ¢Í§à´×Í¹/»Õ·ÕèÃÐºØ ËÃ×Í¡ÅèÒÇÍÕ¡¹ÑÂË¹Öè§¤×ÍËÒÇèÒà´×Í¹/»Õ·ÕèÃÐºØ¹Ñé¹ÁÕ¡ÕèÇÑ¹ */
function LastDay($m, $y) {
  for ($i=29; $i<=32; $i++) {  if(checkdate($m, $i, $y) == 0) {   return $i - 1;  }  }
}
//-----------------------------------------checkfiles
function readFiles($path=""){
	$arr_file = array();
	if ($handle = opendir($path)) {
		
		while ($file = readdir($handle)) {
			$arr_file[] = $file;
		}
	
		closedir($handle);
	}
	return $arr_file;
}
//------------------------------------cost_add
function return_bytes($size_str) {
    switch (substr($size_str, -1)) {
        case 'M': case 'm': return (int) $size_str * 1048576;
        case 'K': case 'k': return (int) $size_str * 1024;
        case 'G': case 'g': return (int) $size_str * 1073741824;
        default: return $size_str;
    }
}
//--------------------------------costByProject
function nf($v) {
    return number_format($v, 2);
}

//print_r($_POST);
function dep($d) {
    $a = explode("/", $d);
    return $a[2] . '-' . $a[1] . '-' . $a[0];
}
function dslash($d){
    $a = explode("-", $d);
    return $a[2] . '/' . $a[1] . '/' . $a[0];
}
//-------------------------------report_staff
function convertdate($getdate){
global $mname; 
	$x = explode("-",$getdate);
	$m1 = $mname[intval($x[1])];
	$d1 = intval($x[2]);
	$xrs = " $d1 "." $m1 "." $x[0] ";
	return $xrs;
}

function getUser($tripid=''){
	$sql = "SELECT cos_user.name, 
				cos_user.surname,
				cos_user.userid 
				FROM cos_user INNER JOIN trip ON cos_user.userid = trip.userid 
				WHERE trip.tripid='{$tripid}'
				";
	$query = mysql_query($sql);	
	$row = mysql_fetch_assoc($query);
	return 	$row;	
}
//------------------------------report_trip_cost
function taskData($ProjectCode='', $filter=''){
	$cost_temp = 'cost_temp';
	$arrData = array();
	
	$connect = mysql_connect('192.168.2.13', 'sapphire', 'sprd!@#$%');
    if (!$connect) {
        die('<option value="e">Could not connect: ' . mysql_error() . '</option>');
    }

    $result = mysql_query("SET character_set_results=tis-620");
    $result = mysql_query("SET NAMES TIS620");
    mysql_select_db($cost_temp, $connect) or die('<option value="e">die2</option>');
	
	
	$sql = "SELECT  * FROM `daily_task_data_mini` WHERE ProjectCode='{$ProjectCode}' "; 
	$query = mysql_db_query($cost_temp, $sql);
	while($row = mysql_fetch_assoc($query)){
		$arrData[] = $row;
	}
	return $arrData;
}
//-----------------------------------------------config
function CloseDB()
{
    global $conn;
    mysql_close($conn);
}
function GetTripOwner($tid){
	$sql = "select concat(t2.name,' ',t2.surname) from trip t1 inner join cos_user t2 on t1.userid=t2.userid where t1.tripid='$tid';" ;
	$result = mysql_query($sql);
	$rs = mysql_fetch_array($result);
	return $rs[0];
}
function DateInput($d,$pre){
	global $monthname;
	if (!$d){
		$d = (intval(date("Y")) + 543) . "-" . date("m-d"); // default date is today
	}

	$d1=explode("-",$d);
?>
วันที่
<select name="<?=$pre?>_day" >
<?
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
</select>

เดือน 
<select name="<?=$pre?>_month" >
<?
for ($i=1;$i<=12;$i++){
	$xi = sprintf("%02d",$i);
	if (intval($d1[1])== $i){
//		echo "<option value='$xi' SELECTED>$xi</option>";
		echo "<option value='$xi' SELECTED>$monthname[$i]</option>";
	}else{
//		echo "<option value='$xi'>$xi</option>";
		echo "<option value='$xi'>$monthname[$i]</option>";
	}
}
?>
</select>

ปี พ.ศ. 
<select name="<?=$pre?>_year" >
<?
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option SELECTED>$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}
?>
</select>
<?
}
function MakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . $d1[0];
}
function DBThaiDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543);
}
function DBThaiLongDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}
function ThaiDate2DBDate($d){
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	
	$d1=explode("/",$d);
	return (intval($d1[2]) - 543) . "-" . $d1[1] . "-" . $d1[0];
}

?>
