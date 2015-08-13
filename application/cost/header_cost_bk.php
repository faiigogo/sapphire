<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="cost.css" type="text/css" rel="stylesheet">
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
</head>
<body >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="60%" height="40" align="left" bgcolor="#B2B2B2"><img src="images/field_title.png" width="369" height="66"><!--<nobr>&nbsp;&nbsp;<span class="title_cost">Field Operation System</span></nobr><br>
    &nbsp;&nbsp; <span class="title_cost2">ระบบบันทึกค่าใช้จ่ายออกพื้นที่ </span>--></td>
    <td width="25%" align="right" bgcolor="#B2B2B2">
    <? if($pri == "30"){?>
    <a href="avatar_mode.php<?=($_SESSION['avatar_mode'] == "on")?"?action=clear":""?>"><img src="images/cqi/<?=($_SESSION['avatar_mode'] != "on")?"user.png":"Users_Group.png"?>" alt="<?=($_SESSION['avatar_mode'] != "on")?"AVATAR MODE":" กำลังใช้งาน AVATAR MODE"?>" width="48" height="48" border="0" style="cursor:pointer" title="<?=($_SESSION['avatar_mode'] != "on")?"AVATAR MODE":" กำลังใช้งานการจำลองเป็นAVATAR คลิ้กเพื่อยกเลิกการจำลอง "?>" ></a>
    <? } ?>

    <a href="addtrip.php"><img src="images/home2.png" title="กลับหน้าหลัก" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src='images/home.png'" onMouseOut="this.src='images/home2.png'"></a>
      <!--<img src="images/logo_sapp.jpg" width="160" height="50">-->
      <a href="logout.php"><img src="images/Stop2.png" title="ออกจากระบบ" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src='images/Stop.png'" onMouseOut="this.src='images/Stop2.png'" onClick="return confirm('ต้องการออกจากระบบ จริงหรือไม่!')"></a></td>
    <td width="15%" align="right" bgcolor="#B2B2B2"><img src="images/sapphire_logo.png">
    </td>
  </tr>
</table>
</body>
</html>

