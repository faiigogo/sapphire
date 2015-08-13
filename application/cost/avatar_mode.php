<?php
set_time_limit(0);
include ("checklogin.php");
include ("config/phpconfig.php");



if($_SESSION['avatar_mode'] == "on" && $action == "clear"){
		echo "<meta http-equiv='refresh' content='0;url=avatar_entry.php?action=clear'>" ;
		die;
}
?>

<html>

<head>

<title>รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</title>

<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="cost.css" type="text/css" rel="stylesheet">

<style type="text/css">

<!--

body {  margin: 0px  0px; padding: 0px  0px}

a:link { color: #005CA2; text-decoration: none}

a:visited { color: #005CA2; text-decoration: none}

a:active { color: #0099FF; text-decoration: underline}

a:hover { color: #0099FF; text-decoration: underline}
.style1 {color: #005CA2}

.tran_table {
background-color: #EBEBEB;
opacity: .7;
filter: alpha(opacity=85);
-moz-opacity: .7;
}	   
.tran_table2 {
background-color: #EBEBEB;
opacity: .7;
filter: alpha(opacity=95);
-moz-opacity: .7;
}	
-->

</style>
<script language="javascript">
function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=no,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}
</script>


<SCRIPT LANGUAGE="JavaScript">

<!--

	function ch1(){

		var f1=document.form1;

		if (!f1.tripname.value){

		alert("กรุณาระบุชื่อTrip");

			return false;

		}

	}

//-->

</SCRIPT>

</head>



<body >

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="center" valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td valign="top" bgcolor="#D3D3D3" >
		
		<?
	include("header_cost.php"); // หัวโปรแกรม
		?>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
          <tr>
            <td height="30" colspan="2"><B class="pheader">&nbsp;รายการ Trip รหัสการเดินทาง </B></td>

          </tr>

        </table>

            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">



              <tr>

                <td width="10%" align="right" bgcolor="#2A007C"><strong class="style4">Staff Name: </strong></td>

                <td bgcolor="#CCCCCC"><strong>

				&nbsp;

				<?=GetTripOwner($tripid)?>

                  <?=$_SESSION[name]?>

                  &nbsp;&nbsp;

                  <?=$_SESSION[surname]?>

				  

                </strong></td>

              </tr>

            </table>
		  </td>
      </tr>
    </table>
    
    <? if($_SESSION['avatar_mode'] == "on"){
		echo "<br><br><br><br><center><b><img src=\"images/cqi/screen-hand-no.png\" width=\"48\" height=\"48\"><br>  คุณกำลัง ใช้งาน MODE AVATRA เป็น ".$_SESSION[name]." ".$_SESSION[surname] ." <br>กรุณาออกจาก AVARTA ที่ใช้งานก่อนโดย <a href=\"?action=clear\">คลิ้กที่นี่</a></b></center>";
	die;
	}?>
    
    
      <table width="72%" border="0" cellspacing="0" cellpadding="0" class="sample">
        <tr>
          <td><table width="95%" border="0" align="center" cellpadding="1" cellspacing="5">
            <tr>
              <td colspan="2" align="left" class="style4">AVATAR LIST</td>
            </tr>
            <?
			$strSQL = "
				SELECT
				cos_user.userid,
				cos_user.name,
				cos_user.surname,
				cos_user.pri,
				avatar_user.avatar
				FROM
				cos_user
				Inner Join avatar_user ON cos_user.userid = avatar_user.avatar
				WHERE
				avatar_user.userid =  '$_SESSION[userid]' " ; 
			$query_result = mysql_query( $strSQL ) ;
			while($Rs_Row=mysql_fetch_assoc($query_result)){
			?>
            <tr>
              <td width="15%" align="center"><img src="images/cqi/<?=($Rs_Row[pri]=="100")?"x-js-com_juser.png":"x-js-com_jcs.png"?>" title="แสดงทั้งหมด"width="32"height="32"></td>
              <td width="85%" style="background-color:#FFFFFF">
               &nbsp;&nbsp;
              <nobr><a href="avatar_entry.php?avatarid=<?=$Rs_Row[userid]?>&action=entry"><?=$Rs_Row[name]." ".$Rs_Row[surname]?></a>
              </td>
            </tr>
            <? } ?>
          </table></td>
        </tr>
    </table></td>

  </tr>

</table>

</body>

</html>

