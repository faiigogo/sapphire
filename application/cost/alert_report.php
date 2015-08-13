<?php
set_time_limit(0);
include ("checklogin.php");

include ("config/phpconfig.php");

include ("cost/function.php");

?>

<html>

<head>

<title>รายการแจ้งเตือนผู้ปิด TRIP ช้า </title>

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

div.tree div {
 padding-left:16px;
}
div.tree div.parent div {
 display:none;
 cursor:default;
}
div.tree div.parent {
 cursor:pointer !important;
 background:transparent url(plus.gif) no-repeat top left;
}
div.tree div.expanded {
 background:transparent url(minus.gif) no-repeat top left;
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

	function hiden_other(x){
			
			var divname= x.id;
			//alert(divname);
			//document.getElementById(divname).style.display = "none" ;

	}

</script>
<style>
table.detail, table.detail td, table.detail th {
	border-collapse:collapse;
	border:1px solid black;
}
table.detail tr.parent {
	font-weight:bold;
}

</style>

<script type="text/javascript" src="js/jquery-1.3.2.js"></script>

<script language="javascript"  src="libary/popcalendar.js"></script>

<link href="css/redmon_theme/redmon.custom.css" rel="stylesheet" type="text/css">

</head>

<body >
<form name="form1"  method = GET  action = "<?=$PHP_SELF?>" enctype="multipart/form-data"  >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>
        <td valign="middle" bgcolor="#D3D3D3" class="ui-state-active" style="height:36px" ><img src="images/dollar_currency_sign.png" width="24" height="24"><span style="font-size:14px"><strong>รายการแจ้งเตือนผู้ปิด TRIP ช้า </strong></span></td>
        <td valign="middle" bgcolor="#D3D3D3" class="ui-state-active" style="height:36px" >

        <span style="font-size:14px"><strong>
        <?
		$mm = $mm ? $mm : date("m");
		$yy = $yy ? $yy : date("Y");
		?>
        เดือน 
        <select name="mm" id="mm">
        	<? 
			for($i=1;$i<=12;$i++) { ?>
        	<option value="<?=$i?>" <?=($i==$mm)?"selected":""?> ><?=$i?></option>
            <? }?>
        </select>
        ปี
        <select name="yy" id="yy">
			<? 
		$str1 = "
			SELECT
			MOUNT(alert_list.`timestamp`) AS MM
			YEAR(alert_list.`timestamp`) AS YY
			FROM
			alert_list
			Inner Join trip ON alert_list.trip_id = trip.tripid
			Inner Join cos_user ON trip.userid = cos_user.userid
			WHERE 
			status_alert = 'complete'
			GROUP BY YY
			";
			$result = mysql_query($str1);
			if(@mysql_num_rows()){
			while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){?>
        	<option value="<?=$rs[YY]?>" <?=$rs[YY]==$yy?"selected":""?>><?=$rs[YY]+543?></option>
            <? }
			}else{
			?>
            <option value="<?=date(Y)?>" ><?=date(Y)+543?></option>
            <? }?>
        </select>
        <input name="" value="เรียกดูข้อมูล" type="submit">
        </strong></span>

        </td>
      </tr>
      <tr>

        <td colspan="2" valign="top" bgcolor="#D3D3D3" >

		<div>           
            
  <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#666666"  id="detail_table" class="detail">

		<thead>

              <tr bgcolor="#A3B2CC">

                <td width="3%" height="25" align="center" bgcolor="#2A007C" class="style4"><b>ลำดับ</b></td>

                <td width="8%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>รหัสTrip</strong></td>

                <td width="18%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>ชื่อTrip</strong></td>

                <td width="18%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>เจ้าของTRIP</strong></td>

                <td width="30%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>ชนิดการเตือน</strong></td>
                <td width="11%" align="center" bgcolor="#2A007C" class="style4"><strong>จำนวนครั้ง</strong>ครั้งที่เตือน</td>

                <td width="12%" align="center" bgcolor="#2A007C" class="style4"><strong>วันล่าสุดที่เตือน</strong></td>

              </tr>
		</thead>

       <?php

		$i = 0;
		$no=0;
		$max=0;
		$str1 = "
				SELECT
				trip.tripid,
				trip.tripname,
				cos_user.name,
				cos_user.surname,
				alert_list.alert_way AS 'WAY',
				COUNT(alert_list.no_alert) AS no_lert,
				MAX(alert_list.`timestamp`) AS last_time
				FROM
				alert_list
				Inner Join trip ON alert_list.trip_id = trip.tripid
				Inner Join cos_user ON trip.userid = cos_user.userid
				WHERE 
				status_alert = 'complete'
				AND MONTH(alert_list.`timestamp`) = '$mm'
				AND YEAR(alert_list.`timestamp`) = '$yy'
				GROUP BY trip.tripid , alert_list.alert_way
				ORDER BY trip.tripid /*alert_list.alert_way*/
			";
			$result = mysql_query($str1);
			if($debug=="ON"){echo "<pre>$str1</pre>";}
		
			while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){		
			
				$str1 = "
				select  t2.userid,t2.name,t2.surname,t1.close  
				from  trip t1 LEFT join cos_user t2 on  t1.userid = t2.userid 
				where t1.tripid = '$rs[tripid]' 
				";
				$resx = mysql_query($str1);
				$rsx = mysql_fetch_assoc($resx);
				$i++;
				$no++;
	
				if ($rs[tripid] > $max) $max=$rs[tripid];
				if ($i % 2) {	$bg="#FFFFFF";	}else{	$bg="#F0F0F0";	}
				
			  $staff_name = "$rs[name] &nbsp; &nbsp; $rs[surname] ";


          	  ?>
              <tbody>
              <tr bgcolor="<?=$bg?>"  id="r<?=$rs[tripid]?>" onClick="hiden_other(this)" class="parent-r<?=$rs[tripid]?>">              
              <td height="25" align="center"><?=$no?></td>              
              <td height="25" align="left"><?=$rs[tripid]?></td>   
              <td height="25" align="left"><?=$rs[tripname]?></td>              
              <td height="25"><?=$staff_name?></td>
              <td height="25"  align="center" valign="middle"><strong><?=$rs[WAY]=="sms"?"<img src=\"images/cqi/screen-price.png\">:SMS":"<img src=\"images/cqi/screen-email.png\">:MAIL"?></strong></td>
              <td  align="center"><?=$rs[no_lert]?></td>
              <td  align="center"><?=substr($rs[last_time],0,8)." ".substr($rs[last_time],8)?></td>
              </tr>
<?php /*?>				  <?
                  for($i=1;$i<3;$i++){
                  ?>
                  <tr bgcolor="<?=$bg?>"  id="row_<?=$rs[tripid]?>" onClick="hiden_other(this)" class="child-r<?=$rs[tripid]?>">              
                  <td height="25" align="center" colspan="4">&nbsp;</td>                     
                  <td height="25"  align="center"><?=$rs[WAY]?></td>
                  <td  align="center"><?=$rs[no_lert]?></td>
                  <td  align="center"><?=$rs[last_time]?></td>
                  </tr>
                  <?
                  }
                  ?><?php */?>
	          </tbody>
			  <?
		}
		?>

            </table>            
            </div>
            <br>
		  
		  </td>

      </tr>

    </table>
    </td>

  </tr>

</table>



</form>
</body>

</html>
<? if($debug == "ON"){ echo "<pre>"; print_r($_SESSION); echo "</pre>"; }?>
