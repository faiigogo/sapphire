<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.title_cost {
	font-family: "Times New Roman";
	font-size: xx-large;
	color: #FFFFFF;
}
.title_cost2 {
	color: #FFFFFF;
}
-->
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="60%" height="40" align="left" bgcolor="#B2B2B2"><img src="images/field_title.png" width="369" height="66"><!--<nobr>&nbsp;&nbsp;<span class="title_cost">Field Operation System</span></nobr><br>
    &nbsp;&nbsp; <span class="title_cost2">ระบบบันทึกค่าใช้จ่ายออกพื้นที่ </span>--></td>
    <td width="25%" align="right" bgcolor="#B2B2B2">
    <?php
	$sqlAvatar = "
				SELECT
				COUNT(avatar_user.avatar) AS count_avatar
				FROM
				cos_user
				Inner Join avatar_user ON cos_user.userid = avatar_user.avatar
				WHERE
				avatar_user.userid =  '$_SESSION[userid]' 
				";
	$query_result = mysql_query( $sqlAvatar );
	$rowAvatar = mysql_fetch_assoc($query_result);
			
	if($rowAvatar['count_avatar'] > 0 || $_SESSION['avatar_mode']){?>
    <a href="avatar_mode.php<?=($_SESSION['avatar_mode'] == "on")?"?action=clear":""?>"><img src="images/cqi/<?=($_SESSION['avatar_mode'] != "on")?"user.png":"Users_Group.png"?>" alt="<?=($_SESSION['avatar_mode'] != "on")?"AVATAR MODE":" กำลังใช้งาน AVATAR MODE"?>" width="48" height="48" border="0" style="cursor:pointer" title="<?=($_SESSION['avatar_mode'] != "on")?"AVATAR MODE":" กำลังใช้งานการจำลองเป็นAVATAR คลิ้กเพื่อยกเลิกการจำลอง "?>" ></a>
    <? 
	} 
	
	$sql_accounting = "SELECT accounting FROM `cos_user` where `userid` = '$_SESSION[userid]' ";
	$query_accounting = mysql_query( $sql_accounting );
	$row_accounting = mysql_fetch_assoc($query_accounting);
	
	if($row_accounting['accounting'] == 1 ){
	?>
    <a href="account/showtrip.php" target="_blank"><img src="images/cqi/book-gl.png"  width="48" height="48" border="0" style="cursor:pointer" ></a>
    <? 
	} 
	
	if(strpos($PHP_SELF , "list.php") != true && $tripid){
		$url_target = "list.php?tripid=$tripid&sname=$sname&ssurname=$ssurname";
	}else{
		$url_target = "addtrip.php";
	}	
	//echo $url_target;
	?>
    <a href="<?=$url_target?>"><img src="images/home2.png" title="กลับหน้าหลัก" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src='images/home.png'" onMouseOut="this.src='images/home2.png'"></a>
      <!--<img src="images/logo_sapp.jpg" width="160" height="50">-->
      <a href="logout.php"><img src="images/Stop2.png" title="ออกจากระบบ" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src='images/Stop.png'" onMouseOut="this.src='images/Stop2.png'" onClick="return confirm('ต้องการออกจากระบบ จริงหรือไม่!')"></a></td>
    <td width="15%" align="right" bgcolor="#B2B2B2"><img src="images/logo_<?=$_SESSION['application']?>.png" height="<?=$_SESSION['logo_size']?>">
    </td>
  </tr>
</table>

