<?php
session_start();
//ini_set("display_errors","1");
include ("../phpconfig.php");
include ("../libary/function.php");

$date_list = $getyear.'-'.$getmonth.'-'.$getday;
if ($_SERVER[REQUEST_METHOD] == "POST" && $send > ""){
//if Action is edit and file is send remove old file and replace with new one
if($action == "edit2"){
	if($file_name != ""){
		$xsql = mysql_query("select attach from `list` where runno = '$runno'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
		$xrs = mysql_fetch_assoc($xsql);
		if(file_exists($xrs[attach])){ unlink($xrs[attach]); }
	}
}

//echo "<br>".$file_name;
//echo "<br>".$file_size;
//echo "<br>".$file_type;
//Check file befor attach to server

if($file_name != "" ){

$filechk = "../attach/".$file_name;
if(file_exists($filechk)){ 

	$fn = split('[.]', $file_name);
	$f_name = $fn[0];	
	$f_ext = getFileExtension($file_name);
	$filename = "../attach/".$f_name."(1).".$f_ext;
	
} else {

	$filename = "../attach/".$file_name;
	
}

	if($file_size >= "1200000"){
	
		$msg = "<b class=warn>Warning</b><br>ขนาดของ file เกินจากที่กำหนดไว้ครับ<div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
		include("msg_box.php");		
		exit() ;
		
	} else {
	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){
	 
				$msg = "ไม่สมารถ upload ขึ้น server ได้<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
				include('msg_box.php');
				exit();		
			}
		unlink($file);  
		
		} else {
	
			$msg = "<font class=\"brown\">Can't upload this file</font><br>Folder ที่จะทำการบันทึกข้อมูลอาจจะยังไม่ได้กำหนดคุณลักษณะ<br>กรุณาตรวจสอบ CMOD ของ Folder<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";
			include('msg_box.php');
			exit();
		
		}
	}

}
$date_list = swapdate($getday);
		 if ($action == "edit2")
		 {
if($file_name == ""){
	$sql = "update list set  date_list =  '$date_list' , no_ap = '$no_ap' , detail = '$detail' , cash = '$cash' , credit = '$credit' , id_type_credit = '$id_type_credit' , complete = '$complete' , id_type_cost = '$id_type_cost' , id_type_project = '$id_type_project' ,  note ='$note' , date = now() , cash_vat = '$cash_vat' , cash_total = '$cash_total' , credit_vat= '$credit_vat' , credit_total = '$credit_total' ,cash_check =  '$cash_check' , credit_check = '$credit_check' ,id_saving = '$id_saving', id_tax_type = '$id_tax_type',vat5='$vat5',vat5_check = '$vat5_check'   where runno = '$runno' ";
} else {
	$sql = "update list set  date_list =  '$date_list' , no_ap = '$no_ap' , detail = '$detail' , cash = '$cash' , credit = '$credit' , id_type_credit = '$id_type_credit' , complete = '$complete' , id_type_cost = '$id_type_cost' , id_type_project = '$id_type_project' ,  note ='$note' , date = now() , cash_vat = '$cash_vat' , cash_total = '$cash_total' , credit_vat= '$credit_vat' , credit_total = '$credit_total',cash_check =  '$cash_check' , credit_check = '$credit_check' , attach = '$filename',id_saving = '$id_saving', id_tax_type = '$id_tax_type' ,vat5 = '$vat5' , vat5_check = '$vat5_check' where runno = '$runno' ";
}		

				@mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
                    ?>
                    <script>
                     window.location = "list.php?tripid=<?php echo $tripid; ?>";
                    </script>
                    <?php
                    // pok-edit
					// header("Location: list.php?tripid=$tripid");
				}
			}
			else
			{
$sql = "INSERT INTO  list  (attach, date_list,no_ap,detail,cash,credit,id_type_credit,complete,id_type_cost,id_type_project,note,cash_vat,cash_total,credit_vat,credit_total,date,tripid,userid,cash_check,credit_check) VALUES  ('$filename', '$date_list','$no_ap','$detail' , '$cash' , '$credit' , '$id_type_credit' , '$complete' , '$id_type_cost' , '$id_type_project' , '$note' , '$cash_vat','$cash_total','$credit_vat','$credit_total', now() ,'$tripid','$userid','$cash_check','$credit_check')";
			//	echo $sql;
				$result  = mysql_query($sql);
				if($result)
				{
				header("Location: list.php?tripid=$tripid");
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="center">
			<span class="style2">	ระบบได้ทำการบันทึกข้อมูลของท่านแล้ว และจะทำการติดต่อกลับเพื่อยืนยันโดยเจ้าหน้าที่รับลงทะเบียน ตามหมายเลข &nbsp; <?=$off_tel;?> และอีเมลล์ &nbsp; <?=$off_mail?>  </span>
				</tr>
				<tr align="center" >
				<input name="" type="button" value = "   ปิด  "onClick=window.close();> &nbsp;&nbsp;
				<input name="" type="reset"  value = "กลับหน้าหลัก"  onClick="location.href='index.php';">
				<tr>
				</table>
				<?
					exit;
				}
				else
				{	
					echo "ไม่สามารถบันทึกข้อมูลได้ ";
				}
			}
	} 
	$sql = "select * from  register   where  id='$id' ;";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "ไม่พบข้อมูลที่ต้องการ";
	}
?>
<SCRIPT language=JavaScript 
src="../bimg/swap.js"></SCRIPT>
<html>
<head>
<title>รายงานค่าใช้จ่ายในการออกปฏิบัติงานการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="../cost.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #000000}
.style4 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<!-- check การระบุค่า  -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function ch1(){

	var f1 = document.form1;		
	if(f1.id_tax_type.selectedIndex == 0){
		alert("กรุณาระบุชื่อหมวดประเภทภาษี");		
		return false;
	} else if (f1.id_type_cost.selectedIndex == 0){
		alert("กรุณาระบุชื่อหมวดค่าใช้จ่าย");		
		return false;
	} else if (f1.id_type_project.selectedIndex == 0){
		alert("กรุณาระบุโครงการ");
		return false;		
	} else if(f1.cash_check.checked == true){
		if(f1.id_saving.selectedIndex == 0){
		alert("กรุณาระบุชื่อหมวดประเภทภาษี");		
		return false;
		}		
		return true;
	}
	return true;
}
//window.top.leftFrame.document.menu.SetVariable("logmenu.id","<?=$id?>");

//	window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");
	function checkid(){  //รวบรวมสร้าง id 
		f1 = document.form1;
		f1.id.value = f1.id1.value + f1.id2.value + f1.id3.value + f1.id4.value + f1.id5.value;
	}
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
	var keyCode = (isNN) ? e.which : e.keyCode; 
	var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
	if(input.value.length >= len && !containsElement(filter,keyCode)) {
		input.value = input.value.slice(0, len);
		input.form[(getIndex(input)+1) % input.form.length].focus();
	}

	function containsElement(arr, ele) {
	var found = false, index = 0;
		while(!found && index < arr.length)
			if(arr[index] == ele)
				found = true;
			else
				index++;
		return found;
	}

	function getIndex(input) {
		var index = -1, i = 0, found = false;
		while (i < input.form.length && index == -1)
			if (input.form[i] == input)
				index = i;
			else 
				i++;
			return index;
	}

	// add to id
	checkid();
	return true;
}

var isMain = true;

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script language="javascript"  src="../libary/popcalendar.js"></script>
</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom "><?
/*

if ($msg){

		echo "<h1>$msg</h1>";

		exit;

}

*/

?>
      <!-- main Table  -->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width=""></td>
              </tr>
            </table>
              <span class="style4">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</span></td>
        </tr>
        <tr bgcolor="#CACACA">
          <td width="862" bgcolor="#888888">&nbsp;</td>
          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 50;" class="xbutton" value="Exit" onClick="location.href='list.php?tripid=<?=$tripid?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><form  name ="form1" method = POST  action = "?" enctype="multipart/form-data"  onSubmit="return ch1();"><?
							If ($_GET[action]=="edit2")
{
		$sql = "select * from list where  runno='$runno'  ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}



}


if ($_POST[runno] > ""){
	$rs = $_POST;
	//print_r($rs);
}

?>
                            <INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>">
                            <INPUT TYPE="hidden" NAME="runno" VALUE="<?=$rs[runno]?>">
                            <INPUT TYPE="hidden" NAME="tripid" VALUE="<?=$tripid?>">
                            <INPUT TYPE="hidden" NAME="no_ap" VALUE="<?=$rs[no_ap]?>">
                            <INPUT TYPE="hidden" NAME="detail" VALUE="<?=$rs[detail]?>">
                            <INPUT TYPE="hidden" NAME="cash" VALUE="<?=$rs[cash]?>">
                            <INPUT TYPE="hidden" NAME="cash_vat" VALUE="<?=$rs[cash_vat]?>">
                            <INPUT TYPE="hidden" NAME="cash_total" VALUE="<?=$rs[cash_total]?>">
                            <INPUT TYPE="hidden" NAME="credit" VALUE="<?=$rs[credit]?>">
                            <INPUT TYPE="hidden" NAME="credit_vat" VALUE="<?=$rs[credit_vat]?>">
                            <INPUT TYPE="hidden" NAME="credit_total" VALUE="<?=$rs[credit_total]?>">
                            <br>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('basicdata','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b class="gcaption"><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlbasicdata" width="9" height="9" border="0" id="ctrlbasicdata" >&nbsp;&nbsp; รายการเบิกค่าใช้จ่าย </font></b></td>
                              </tr>
                              <tr>
                                <td><DIV id=swapbasicdata>
                                  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="60%">&nbsp;</td>
                                      <td width="15%"><div align="center">วันที่ทำรายการ</div></td>
                                      <td><?=DBThaiLongDate(date("Y-m-d"));?></td>
                                    </tr>
                                  </table>
                                  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="textp">
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">Trip</span></td>
                                      <td height="25" valign="top"><span class="style2">
                                  
                                          <?
										  $sqltrip = "select  * from trip where tripid = '$tripid' ";
										  $resulttrip = mysql_query($sqltrip);
										  $rstrip = mysql_fetch_array($resulttrip);
										  echo $rstrip[tripid];
										  echo "&nbsp; - &nbsp;";
										  echo  $rstrip[tripname];
										  
										  $display = ($pri =='80' && $rstrip['userid'] != $_SESSION[userid])?true:false;

?>
                                       
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td width="5%" align="center" valign="top">&nbsp;</td>
                                      <td width="20%" height="25" valign="top"><span class="style2 style2">วันที่</span>
                                      <?
						   $d2=explode("-",$rs[date_list]);			   
						   ?></td>
                                      <td height="25" valign="top">
                                      <?php
									  if($display==true){
										  echo swapdate($rs[date_list]); 
										}else{
                                      ?>
                                      <span class="style2"><input type="text" name="getday" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<? if($rs[date_list] == ""){ echo date("d/m/").(date("Y") ); }else{ echo swapdate($rs[date_list]); }?>" readonly>
	<script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.getday, \"dd/mm/yyyy\")' value=' เลือกวัน ' class='input'>")	}</script>
                                      </span>
                                      <? } ?>
                                      </td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2 style2">เลขที่ใบเสร็จ</span></td>

                                      <td height="25" valign="top">
									  <?
									  if($display==true){
									  
									  	echo $rs[no_ap];
									}else
									{
									?>
									  <input name="no_ap" type="text" class="input_text " id="no_ap" value="<?=$rs[no_ap]?>" size="20">
									  								  <?
									  }
									  ?>									  </td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2 style2">รายการ</span></td>

                                      <td height="25" valign="top">
									 <?
									   if($display==true){
									  	echo $rs[detail];
									}else
									{
									?>
									  <input name="detail" type="text" class="input_text " id="detail" value="<?=$rs[detail]?>" size="120">
									  <?
									  }
									  ?>									  </td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2 style2">จำนวนเงิน</span></td>

                                      <td height="25" valign="top"><span class="style2">
                                        <input name="cash_check" type="checkbox" id="cash_check" VALUE="1" <?if($rs[cash_check] == 1) echo "CHECKED";?>>
                                      เงินสด 
                                      <select name="id_saving" id="id_saving" >
                                        <option value="">ไม่ระบุ</option>
                                        <?

		$select1  = mysql_query("select  * from saving_type;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		if ($rs[id_saving] == $rselect1[id_saving])

		{ 			

			echo "<option value='$rselect1[id_saving]' SELECTED>$rselect1[saving_name]</option>";

		}else

			{

			echo "<option value='$rselect1[id_saving]' >$rselect1[saving_name]</option>";

			}

		}//end while

?>
                                      </select>
                                      </span></td>
                                    </tr>

                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;มูลค่า</span></td>
                                      <td height="25" valign="top"><span class="style2">
									  <?
									
									  if($display==true){
									  	echo $rs[cash];
									}else
									{
									
									?> 
                                        <input name="cash" type="text" class="input_text" id="cash" value="<?=$rs[cash]?>" size="20">
                                        บาท
                                      </span>
									  
									  <?
									  }
									  ?>									  </td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;Vat 7% </span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <?
										
									  if($display==true){
									  	echo $rs[cash_vat];
									}else
									{
									
									?>
                                        <input name="cash_vat" type="text" class="input_text" id="cash_vat" value="<?=$rs[cash_vat]?>" size="20">
บาท 
<?
									  }
									  ?>
&nbsp;&nbsp;</span></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;รวม</span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <?
										
									   if($display==true){
									  	echo $rs[cash_total];
									}else
									{
									
									?>
                                        <input name="cash_total" type="text" class="input_text" id="cash_total" value="<?=$rs[cash_total]?>" size="20">
บาท 
<?
									  }
									  ?>
                                      </span></td>
                                    </tr>
                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">
                                        <label></label>
                                        <input name="credit_check" type="checkbox" id="credit_check" VALUE="1" <?if($rs[credit_check] == 1) echo "CHECKED";?>>
                                        &nbsp;:&nbsp;&nbsp;เครดิต 
                                      <label>ประเภทบัตรเครดิต     
                                      <select name="id_type_credit" id="id_type_credit"  >
                                        <option value="">ไม่ระบุ</option>
                                        <?

		$select1  = mysql_query("select  *  from type_credit;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		if ($rs[id_type_credit] == $rselect1[id_type_credit])

		{ 			

			echo "<option value='$rselect1[id_type_credit]' SELECTED>$rselect1[type_credit]</option>";

		}else

			{

			echo "<option value='$rselect1[id_type_credit]' >$rselect1[type_credit]</option>";

			}

		}//end while

?>
                                      </select>
                                      </label>
                                      <label></label>
                                      <label>
                                      <input type="button" name="btnNewcredit" value=" + " onClick="MM_openBrWindow('../addtype_credit.php','','width=800,height=500')">
                                      </label>
                                      </span></td>
                                    </tr>

                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;มูลค่า</span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <label></label><label></label>
                                        <?
										
									   if($display==true){
									  	echo $rs[credit];
									}else
									{
									
									?>
                                        <input name="credit" type="text" class="input_text" id="credit" value="<?=$rs[credit]?>" size="20">
บาท
<?
								  }
									  ?>
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;Vat 7% </span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <?
									
									   if($display==true){
									  	echo $rs[credit_vat];
									}else
									{
									
									?>
                                        <input name="credit_vat" type="text" class="input_text" id="credit_vat" value="<?=$rs[credit_vat]?>" size="20">
บาท
<?
								  }
									  ?>
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;รวม</span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <?
										
									   if($display==true){
									  	echo $rs[credit_total];
									}else
									{
									
									?>
                                        <input name="credit_total" type="text" class="input_text" id="credit_total" value="<?=$rs[credit_total]?>" size="20">
บาท
<?
									  }
									  ?>
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">
                                        <input name="vat5_check" type="checkbox" id="vat5_check" VALUE="1" <?if($rs[vat5_check] == 1) echo "CHECKED";?>>
                                      </span> ภาษีหัก ณ ที่จ่าย 5 % </td>
                                      <td height="25" valign="top"><span class="style2">
                                        <input name="vat5" type="text" class="input_text" id="vat5" value="<?=$rs[vat5]?>" size="20" <?= ( $display==true)?'disabled':'';?>>
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">ประเภทภาษี</span></td>
                                      <td height="25" valign="top"><span class="style2">
                                        <select name="id_tax_type" id="id_tax_type"  >
                                          <option value="">ไม่ระบุ</option>
                                          <?

		$select1  = mysql_query("select  *  from tax_type;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		if ($rs[id_tax_type] == $rselect1[id_tax_type])

		{ 			

			echo "<option value='$rselect1[id_tax_type]' SELECTED>$rselect1[tax_type]</option>";

		}else

			{

			echo "<option value='$rselect1[id_tax_type]' >$rselect1[tax_type]</option>";

			}

		}//end while

?>
                                        </select>
                                      </span></td>
                                    </tr>
                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2 style2">ความสมบูรณ์ของเอกสาร</span></td>

                                      <td height="25" valign="top"><label>
                                            <input name="complete" type="radio" value="y"  <? if ($rs[complete] == "y") { echo "checked=\"checked\" "; } ?> >
                                        ครบ
                                        <input name="complete" type="radio" value="n" <? if ($rs[complete] == "n") { echo "checked=\"checked\" "; } ?> >
                                        ไม่ครบ </label></td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2">หมวดค่าใช้จ่าย</span></td>

                                      <td height="25" valign="top"><span class="style2">
                                        <select name="id_type_cost" id="id_type_cost" <?= ( $display==true)?'disabled':'';?>>
                                          <option value="">ไม่ระบุ</option>
                                          <?

		$select1  = mysql_query("select  * from type_cost;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		if ($rs[id_type_cost] == $rselect1[id_type_cost])

		{ 			

			echo "<option value='$rselect1[id_type_cost]' SELECTED>$rselect1[type_cost]</option>";

		}else

			{

			echo "<option value='$rselect1[id_type_cost]' >$rselect1[type_cost]</option>";

			}

		}//end while

?>
                                        </select>
                                        <input type="button" name="btnNewtype" value=" + " onClick="MM_openBrWindow('../addtype_cost.php','','width=800,height=500')">
                                      </span></td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2">โครงการ</span></td>

                                      <td height="25" valign="top"><span class="style2">
                                        <select name="id_type_project" id="id_type_project" <?= ( $display==true)?'disabled':'';?>>
                                          <option value="">ไม่ระบุ</option>
                                          <?

		$select1  = mysql_query("select  * from type_project;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		if ($rs[id_type_project] == $rselect1[id_type_project])

		{ 			

			echo "<option value='$rselect1[id_type_project]' SELECTED>$rselect1[code_project]</option>";

		}else

			{

			echo "<option value='$rselect1[id_type_project]' >$rselect1[code_project]</option>";

			}

		}//end while

?>
                                        </select>
                                        <input type="button" name="btnNewproject" value=" + " onClick="MM_openBrWindow('../addtype_project.php','','scrollbars=yes,width=800,height=500')">
                                      </span></td>
                                    </tr>

                                    <tr>

                                      <td align="center" valign="top">&nbsp;</td>

                                      <td height="25" valign="top"><span class="style2">หมายเหตุ</span></td>

                                      <td height="25" valign="top"><input name="note" type="text" class="input_text " id="note" value="<?=$rs[note]?>" size="50" <?= ( $display==true)?'disabled':'';?>></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td height="25" valign="top"><span class="style2">แนบไฟล์</span></td>
                                      <td height="25" valign="top"><input type="file" name="file" size="50" class="input" style="background-color:#ffffff;" value="<?=$rs[attach]?>" <?= ( $display==true)?'disabled':'';?>></td>
                                    </tr>
                                  </table>

                                  <br>

                                </DIV></td>

                              </tr>

                          </table>
						<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                          <tr valign="middle">
                            <td align="right" width="290" height="32">&nbsp;&nbsp;</td>
                            <td align="right" width="300" height="32"><input type="submit" name="send" value="  บันทึก  " <?= ( $display==true)?'disabled':'';?>>                              &nbsp; &nbsp;&nbsp;

                            <input type="reset" name="Reset" value="ยกเลิก" onClick=window.close();>
							</td>
                          </tr>
                        </table>


                        </form   ></td>

                      </tr>

                  </table></td>

                </tr>

              </table>

</td>

        </tr>

      </table>

    </td>

  </tr>

</table>

</body>

</html>

