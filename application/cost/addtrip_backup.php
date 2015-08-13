<?php
set_time_limit(0);
include ("checklogin.php");

include ("config/phpconfig.php");

include ("cost/function.php");

if($_GET['view']=="all"){				$_SESSION['view']="all";  $view="all";}
if($_GET['view']=="owner"){		$_SESSION['view']=""; 	$view=""; }
if($_GET['showall']=="y"){			$_SESSION['showall']="y";  $showall="y";}elseif($_GET['showall']==""){			$_SESSION['showall']="";  $showall="";}
if($_GET['nofin']=="Y"||$_GET['cleartrip']=="Y"||$_GET['close']=="Y"||$_GET['endtrip']=="Y"||$_GET['entry']=="Y"){$_SESSION['showall']="";$showall="";}

if ($_SERVER[REQUEST_METHOD] == "POST"){

			If ($tripname ==''){	exit();	}

			 if ($_POST[action]=="edit2"){
			 	
				

				$sql = "update trip set  tripname='$tripname' , note='$note' ,header_trip='$header_trip',downline_status='$downline_status',updatetime = now()

				 where tripid ='$tripid' ;";

				mysql_db_query($db_name,$sql);
				
				#Begin Update downline
				$update_downline_del = "UPDATE trip SET header_trip='' WHERE header_trip='".$tripid."'  ";
				mysql_db_query($db_name,$update_downline_del);
				foreach($_POST['header_user'] as $k=>$header_user){
					$update_downline = "UPDATE trip SET 
														header_trip='".$tripid."' 
														WHERE userid='".$header_user."' 
														AND tripid='".$_POST['trip_user'][$k]."' ";
					//echo "<br/>";
					mysql_db_query($db_name,$update_downline);
				}
				//exit();
				#End Update downline
										
				if( $getdayA || $getdayB ){
					
					$arr_A = explode("/",$getdayA);
					$getdayA2 = $arr_A[2]."-".$arr_A[1]."-".$arr_A[0];
					$arr_B = explode("/",$getdayB);
					$getdayB2 = $arr_B[2]."-".$arr_B[1]."-".$arr_B[0];
					
					//echo "<pre>"; print_r($_POST); echo "</pre>";
					
					if($trip_advance == "ON" || !$schedule_id ){
						
						$no_ref = $no_ref+1;
						
						$sql = "INSERT INTO `trip_schedule` 
									(`schedule_id`,`trip_id`,`start_date`,`end_date`,`no_ref`,`comment`,`timestamp`) 
									VALUES 
									(NULL,'$tripid','$getdayA2','$getdayB2','$no_ref','$comment',NOW())
								  ";	
						$result  = mysql_db_query($db_name,$sql);
						
					}else{
						
						$sql = "UPDATE `trip_schedule` SET
									`start_date` = '$getdayA2',
									`end_date` = '$getdayB2'
									WHERE schedule_id = '$schedule_id'
								  ";	
						$result  = mysql_db_query($db_name,$sql);
						
					}
				}

	  			echo "<script language='javascript'>alert('ได้ทำการปรับปรุงTripแล้ว!');</script>" ;
				
	  			echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;
					  
				die;

				if (mysql_errno())

				{

					$msg = "Cannot update parameter information.";

				}

				else

				{

					header("Location: ?id=$id&action=edit&refreshpage=1");

					exit;

				}
					  
			}else if($_POST[action]=="add"){

				    $sql = "INSERT INTO  trip (tripid,tripname,note,userid,header_trip,downline_status,updatetime)	VALUES ('$tripid','$tripname','$note','$_SESSION[userid]','$header_trip','$downline_status',now())";

					$result  = mysql_db_query($db_name,$sql);
					
							
					#Begin Update downline
					$update_downline_del = "UPDATE trip SET header_trip='' WHERE header_trip='".$tripid."'  ";
					mysql_db_query($db_name,$update_downline_del);
					foreach($_POST['header_user'] as $k=>$header_user){
						$update_downline = "UPDATE trip SET 
															header_trip='".$tripid."' 
															WHERE userid='".$header_user."' 
															AND tripid='".$_POST['trip_user'][$k]."' ";
						mysql_db_query($db_name,$update_downline);
					}
					
					#End Update downline	
										
					if( $getdayA || $getdayB ){
						
						$arr_A = explode("/",$getdayA);
						$getdayA2 = $arr_A[2]."-".$arr_A[1]."-".$arr_A[0];
						$arr_B = explode("/",$getdayB);
						$getdayB2 = $arr_B[2]."-".$arr_B[1]."-".$arr_B[0];
						
						$sql = "INSERT INTO `trip_schedule` 
									(`schedule_id`,`trip_id`,`start_date`,`end_date`,`no_ref`,`comment`,`timestamp`) 
									VALUES 
									(NULL,'$tripid','$getdayA2','$getdayB2','1','$comment',NOW())
								  ";	
						$result  = mysql_db_query($db_name,$sql);
						
						
					}
					
					if($result){

			  			echo "<script language='javascript'>alert('ได้ทำการบันทึกTripแล้ว!');</script>" ;

			  			echo "<meta http-equiv='refresh' content='0;url=addtrip.php'>" ;

						exit;

					}else{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}

				}

}else if ($_GET[action] == 'delete'){

		$sqlc = "select * from list where tripid = '$tripid'";

		$resultc = mysql_db_query($db_name,$sqlc);

		$rsc = mysql_num_rows($resultc);

		 if($rsc == "0")

		{

		mysql_db_query($db_name,"delete from trip where tripid = $tripid ");

		if (mysql_errno())

			{

			$msg = "Cannot delete parameter.";

			}else

			{

			header("Location: addtrip.php"); //header("Location: ?runid=$runid&action=edit&refreshpage=1");

			exit;

			}

		}else

		{

			$msg = "<b class='blue'>Complete</b><br>ไม่สามารถลบข้อมูลได้เนื่องจากมีข้อมูลภายใน Trip นี้";

	echo $msg;

	include("msg_box.php");

	header("Location: addtrip.php");

		}

	

}elseif($_GET['action']=='edit2'){		

	 	$sql = "select * from  trip   ;";

		$result = mysql_db_query($db_name,$sql);

		if ($result){

		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

		} else {

		$msg = "Cannot find parameter information.";

		echo $msg;

		}

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

-->

</style>
<script language="javascript">

function CreateXmlHttp(){
	//Creating object of XMLHTTP in IE
	try {	XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");	}
	catch(e){
		try{	XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");		} 
		catch(oc) {	XmlHttp = null;		}
	}
	//Creating object of XMLHTTP in Mozilla and Safari 
	if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
		XmlHttp = new XMLHttpRequest();
	}
}

function header_trip(){	
		CreateXmlHttp();
		begin_date = document.getElementById('getdayA').value;
		end_date = document.getElementById('getdayB').value;
		var params = "begin_date=" + begin_date +"&end_date=" + end_date + "&math=" + Math.random() ; 
		XmlHttp.open("get", "ajax_header_trip.php?"+params ,true);
		XmlHttp.onreadystatechange=function() {
			if (XmlHttp.readyState==4) {
				if (XmlHttp.status==200) {
					var res = XmlHttp.responseText;
					document.getElementById('div_headerid').innerHTML = res;
				}
			}
		}
		XmlHttp.send(null);		
}

function user_trip(div_id, name_list, user_id){	
		CreateXmlHttp();
		begin_date = document.getElementById('getdayA').value;
		end_date = document.getElementById('getdayB').value;
		var params = "name_list="+name_list+"&userid="+user_id+"&begin_date=" + begin_date +"&end_date=" + end_date + "&math=" + Math.random() ; 
		XmlHttp.open("get", "ajax_user_trip.php?"+params ,true);
		XmlHttp.onreadystatechange=function() {
			if (XmlHttp.readyState==4) {
				if (XmlHttp.status==200) {
					var res = XmlHttp.responseText;
					document.getElementById(div_id).innerHTML = res;
				}
			}
		}
		XmlHttp.send(null);		
}

function checkDownline(){
	if(document.getElementById('downline_status').checked==true){
		document.getElementById('downlineid').disabled = true;
		document.getElementById('sl_downline_trip').disabled = true;
		document.getElementById('b_add').disabled = true;
	}else{
		document.getElementById('downlineid').disabled = false;
		document.getElementById('sl_downline_trip').disabled = false;
		document.getElementById('b_add').disabled = false;
	}
}

function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=no,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}

var gFiles = 0;//add list school
	function addList() {
		var li = document.createElement('li');
		//remove ID
		var obj = document.getElementById('file-'+gFiles);
		var downlineid_index  = document.getElementById('downlineid').selectedIndex;
		var downlineid  = document.getElementById('downlineid').options;
		var sl_downline_trip_index  = document.getElementById('sl_downline_trip').selectedIndex;
		var sl_downline_trip  = document.getElementById('sl_downline_trip').options;
		
		var userid_downline = downlineid[downlineid_index].value;
		var user_name_downline = downlineid[downlineid_index].text;
		var tripid_downline = sl_downline_trip[sl_downline_trip_index].value;
		var trip_name_downline = sl_downline_trip[sl_downline_trip_index].text;
		
		li.setAttribute('id', 'file-'+gFiles);
		var str_text = ""; 
		str_text += '<table cellpadding="1" cellspacing="1" ><tr>';
		str_text+= '<td width="150" align="left">';
		str_text+= user_name_downline;
		str_text+= '<input type="hidden" name="header_user[]" value="'+userid_downline+'"/>';//hidden
        str_text+= '<input type="hidden" name="trip_user[]" value="'+tripid_downline+'"/>';
		str_text+= '</td>';
		str_text+= '<td align="left">';
		str_text+= trip_name_downline;
		str_text+= '</td>';
		str_text+= '<td>';
		str_text+= '<a href="javascript:removeFile('+gFiles+');"><img src="images/delete.png"  aling="absmiddle" width="18" border="0"></a>';
		str_text+= '</td>';
		str_text+= '</tr></table>';
		li.innerHTML = str_text;
		
		document.getElementById('files-root').appendChild(li);
		document.getElementById('downlineid').value = "";
		document.getElementById('sl_downline_trip').value = "";
		gFiles++;
	}


	function removeFile(gFiles){
		var obj = document.getElementById('file-'+gFiles);
		if(confirm('ต้องการลบรายการนี้ใช่หรือไม่')==true){
			obj.parentNode.removeChild(obj);
		}
	}
</script>


<SCRIPT LANGUAGE="JavaScript">

<!--

	function ch1(){

		var f1=document.form1;

		if (!f1.tripname.value){

		alert("กรุณาระบุชื่อTrip");

			return false;

		}else if ( f1.getdayA.value == "" || f1.getdayB.value == "" ){

		alert("กรุณาระบุชื่อช่วงวันเดินทาง");

			return false;

		}

	}


	function show_time(x){
		var xno=document.getElementById('no_ref').value
		var xdiv=document.getElementById(x).style.display;
		var xform=document.getElementById('trip_advance').checked;
		if(xno>0){
			if( xform == true ) {	
				document.getElementById(x).style.display = "block";
			}else{
				document.getElementById(x).style.display = "none";	
			}
		}
	}

//-->

</SCRIPT>
<script language="javascript"  src="libary/popcalendar.js"></script>
<link href="css/redmon_theme/redmon.custom.css" rel="stylesheet" type="text/css">
</head>



<body >

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">

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
		
<!--		<?
		if ($pri =='100'){

		?>

          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D3D3D3">

            <tr>

              <td width="0%">&nbsp;</td>

              <td width="23%" height="24" class="caption">&nbsp;</td>

              <td width="21%" class="caption">&nbsp;</td>

              <td width="27%" class="caption">&nbsp;</td>

              <td width="13%" align="center" class="caption">&nbsp;</td>

              <td width="16%" class="caption"><img src="bimg/report.gif" width="16" height="16"></td>

            </tr>

          </table>

		  <?

		  }

		  ?>-->


            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">



              <tr>

                <td width="10%" align="right" bgcolor="#2A007C"><strong class="style4">Staff Name: </strong></td>

                <td bgcolor="#CCCCCC"><strong>

				&nbsp;

				<?=GetTripOwner($tripid)?>

                  <?=$_SESSION[name]?>

                  &nbsp;&nbsp;

                  <?=$_SESSION[surname]?>

				  <?=($_SESSION['avatar_mode'] == "on")?"<img src=\"images/16x16/video_camera.png\" width=\"16\" height=\"16\" ALT=\"AVATAR MODE\" TITLE=\"AVATAR MODE\">":""?>
				  
                </strong>
                
				<? $user_id = $_SESSION[userid_origin] ? $_SESSION[userid_origin] : $_SESSION[userid]?>
                
    			<a href="<?=($pri =='100' && ($user_id!='103' && $user_id!='140'))?"list_user.php":"add_user.php?action=edit&id=$user_id"?>" target="_blank"><img src="images/16x16/toolbox.png" width="16" height="16" border="0" alt="<?=($pri =='100')?"ปรับปรุง รายชื่อ User":"ปรับปรุง User "?>"></a>
                <?
                if($pri =='100'){
				?>
    			<a href="alert_report.php" target="_blank"><img src="images/16x16/sms.png" width="16" height="16" border="0" alt="รายชื่อผู้ปิดทริปช้า"></a>
    			<? }?>
                </td>

              </tr>

            </table>

              <? if ($pri =='100' || $pri =='80' || $pri =='50'){?>
            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
<!--            <tr><td align="right"><a href="list_user.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0"><strong>usermanager</strong></a></td></tr>-->
            </table>  
            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td  align="left" style="background-color:#FFFFFF; display:<?=(($pri =='100' || $pri =='80')?"":"none")?>; "><nobr><a href="addtrip.php<?=$view != "all" ? "?view=all" : "?view=owner"?>"><img src="images/16x16/monitor.png" width="16" height="16" border="0">รายงาน<?=$view != "all" ? "ทั้งหมดทุกคน" : "ส่วนบุคคล"?></a></td>
                <td  align="left" style="background-color:#FFFFFF"><nobr><a href="listallproject.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0">รายงานจำแนกโครงการทั้งหมด</a></td>
                <td  align="left" style="background-color:#FFFFFF"><nobr><a href="listalltypecost.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0">รายงานหมวดค่าใช้จ่าย</a></td>
                <td  align="left" style="background-color:#FFFFFF"><nobr><a href="report_staff.php" target="_blank"><img src="images/16x16/monitor.png" width="16" height="16" border="0">รายงานหมวดค่าใช้จ่ายตามช่วงเวลา</a></td>
                <td  align="left" style="background-color:#FFFFFF"><nobr><a href="listprojectyear.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0">รายงานสรุปการเดินทาง</a></td>
                <td  align="left" style="background-color:#FFFFFF; display:<?=(($pri =='100')?"":"none")?>;"><nobr><a href="addtype_project.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0">เพิ่มโครงการ</a></td>
                <td  align="left" style="background-color:#FFFFFF; display:<?=(($pri =='100')?"":"none")?>;"><nobr><a href="setproject.php"><img src="images/16x16/monitor.png" width="16" height="16" border="0">ปรับโครงการทั้งหมด</a><a href="listallproject.php"></a></td>
              </tr>
            </table>
              <? }
			   if (!$_GET[action]){
			  ?>
			  			
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
              <tr>  
                <td align="center" class="sample">
				<!------------------------------------------------------------------>				
				<table width="90%" border="0" cellspacing="0" cellpadding="0" class="sample">
				  <tr>
					<td>

				<table width="95%" border="0" align="center" cellpadding="1" cellspacing="5">
                  <tr>
                    <td colspan="2" align="left" class="style4">&nbsp;&nbsp;หมวดรายการค่าใช้จ่าย</td>
                    </tr>
                  <tr>
                    <td width="5%" align="center"><img src="images/webcam.png" title="แสดงทั้งหมด" width="24" height="24"></td>
                    <td width="45%" style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?showall=y&year_r=<?=$year_r?>&view=<?=$view?>">แสดงทั้งหมด<?=$view != "all" ? "ของ $_SESSION[name] $_SESSION[surname]" : "ของทุกคนในระบบ"?></a>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center"><img src="images/pie_chart2.png" title="เฉพาะที่ยังดำเนินการ" width="24" height="24"></td>
                    <td style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?nonfin=y&showall=&year_r=<?=$year_r?>&view=<?=$view?>">เฉพาะที่ยังดำเนินการ</a>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center"><img src="images/promo_violet.png" title="สรุปค่าใช้จ่ายเสร็จสิ้น" width="24" height="24"></td>
                    <td style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?cleartrip=y&showall=&year_r=<?=$year_r?>&view=<?=$view?>">สรุปค่าใช้จ่ายเสร็จสิ้น</a>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center"><img src="images/promo_green.png" title="ผ่านการตรวจรับเอกสารรอการอนุมัติ" width="24" height="24"></td>
                    <td style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?close=y&showall=&year_r=<?=$year_r?>&view=<?=$view?>">ผ่านการตรวจรับเอกสาร รอการอนุมัติ</a>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center"><img src="images/promo_orange.png" title="บันทึกรายการค่าใช้จ่ายเสร็จสิ้น" width="24" height="24"></td>
                    <td style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?endtrip=y&showall=&year_r=<?=$year_r?>&view=<?=$view?>">บันทึกรายการค่าใช้จ่ายเสร็จสิ้น</a>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center"><img src="images/promo_red.png" title="อยู่ในระหว่างการป้อนรายการ" width="24" height="24"></td>
                    <td style="background-color:#FFFFFF"><nobr>&nbsp;<a href="?entry=y&showall=&year_r=<?=$year_r?>&view=<?=$view?>">อยู่ในระหว่างการป้อนรายการ</a>&nbsp;</td>
                    </tr>
                </table>
				
				</td>
				  </tr>
				</table>
				<!------------------------------------------------------------------>				
				</td>
              </tr>
            </table>

            <?
			// หาปี 					

						$previous_url = " <div align=right> &nbsp;     ";   

						$next_url = " <div align=left>&nbsp;   ";

						

						$sql_yy = "  select min(substring(tripid,1,4)) as minYY,max(substring(tripid,1,4)) as maxYY  from trip  " ; 

						$query_result = mysql_db_query($db_name,$sql_yy);

						$result_yy = mysql_fetch_assoc($query_result) ;	

						

						$maxYY1 = $result_yy[maxYY]  ;   $minYY1 = $result_yy[minYY]  ;

						if ($year_r == "" ) {	$year_r =  $maxYY1 ;   }											

						if ($maxYY1 > $year_r ){

								$next_year =$year_r + 1 ;  		$previous_year = $year_r  - 1 ; 		

								$next_url = "<a href='?showall=y&year_r=".$next_year."'><img src=\"images/next.png\" border=\"0\"></a> ";  

						}

						if ($minYY1 < $year_r ){

								$previous_year = $year_r - 1 ; 		$next_year =$year_r + 1 ; 			

								$previous_url = "<a href='?showall=y&year_r=" . $previous_year ."&view=$view'><img src=\"images/back.png\" border=\"0\"></a> ";  

						}

						

					//====================================================================================

//===================================================================== 

?>

            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="16%" align="left" valign="top">
                
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;<?=$previous_url?></td>
                    <td><strong>พ.ศ.<?=$year_r?></strong></td>
                    <td><?=$next_url?>&nbsp;</td>
                  </tr>
                </table></td>
                <td width="68%" align="center">&nbsp;</td>

                <td width="16%" align="right"><a href="?action=add"><img src="images/add.png" width="24" height="24" border="0">เพิ่มรายการ Trip</a>&nbsp;&nbsp;</td>

              </tr>

            </table>
			<div>
            <table width="98%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#666666">

              <tr bgcolor="#A3B2CC">

                <td width="4%" height="25" align="center" bgcolor="#2A007C" class="style4"><b>ลำดับ</b></td>

                <td width="4%" height="25" align="center" bgcolor="#2A007C" class="style4">&nbsp;</td>

                <td width="9%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>รหัสTrip</strong></td>

                <td width="30%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>ชื่อTrip</strong></td>

                <?

			if($pri =='100' || $pri =='80'){
			echo "<td align=\"center\" height=\"25\" align=\"center\" bgcolor=\"#2A007C\" class=\"style4\"><strong>ชื่อStaff</strong></td>";
			}
			?>
                <td width="33%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>หมายเหตุ</strong></td>
			<?
			if($pri =='100' || $pri =='80'){
			echo "<td align=\"center\" height=\"25\" align=\"center\" bgcolor=\"#2A007C\" class=\"style4\"><nobr>&nbsp;ทำรายการ&nbsp;</nobr>อนุมัติ</td>";
			echo "<td align=\"center\" height=\"25\" align=\"center\" bgcolor=\"#2A007C\" class=\"style4\">ออกรายงาน GL</td>";
			}
			?>

                <td width="12%" height="25" align="center" bgcolor="#2A007C" class="style4"><strong>เครื่องมือ</strong></td>
				<? if($pri == "100"){?>
                <td width="8%" align="center" bgcolor="#2A007C" class="style4"><strong>ล้างสถานะ</strong></td>
				<? } ?>
              </tr>

       <?php

		$i = 0;
		$no=0;
		$max=0;
		if($close=="y"){
			$cond = " AND trip.trip_status = '3' ";
		}else if($endtrip=="y"){
			$cond = " AND trip.trip_status = '2' ";
		}else if($cleartrip=="y"){
			$cond = " AND trip.trip_status = '4' ";
		}else  if($entry=="y"){
			$cond = " AND trip.trip_status = '1' ";
		}else  if($showall=="y"){
			//$cond = " AND trip.trip_status <= '4' ";
		}else  if($nonfin=="y"){	
			$cond = " AND trip.trip_status < '4' ";
		}else{ // กรณี DEFAULF ที่ ยังไม่เสร็จสิ้น 
			$cond = " AND trip.trip_status < '4' ";		
		}

		$inner_code=$inner_code?$inner_code:""; // Inner JOIN list  ON  trip.tripid =  list.tripid   พยายาม หลีกเลี่ยง การใช้ LEFT แล้ว
		if(($pri == '100' || $pri == '80') && $view == "all"){	
		$str1 = "
			select trip.tripid,trip.tripname,trip.note  ,trip.trip_status
			from   trip $inner_code 
			where substring(trip.tripid,1,4) = '$year_r'  
			$cond 
			group by trip.tripid order by trip.tripid ;
			";
		//echo $str1 ;
			$result = mysql_db_query($db_name,$str1);
		}else{
		$str1 = "		
			select  trip.tripid,trip.tripname,trip.note ,trip.trip_status
				from   trip $inner_code  
				where (trip.userid = '$_SESSION[userid]') 
				and substring(trip.tripid,1,4) = '$year_r'   
				$cond  
				group by  trip.tripid order by  trip.tripid ;
			";	
			$result = mysql_db_query($db_name,$str1);				
		}
		//echo "$str1";
		if($debug=="ON"){ echo "<pre> XD : ".$str1." <hr> $close . $endtrip . $cleartrip . $entry . $showall . $nonfin :</pre>"; }
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){		
		
			$str1 = "
			select  t2.userid,t2.name,t2.surname,t1.close  
			from  trip t1 LEFT join cos_user t2 on  t1.userid = t2.userid 
			where t1.tripid = '$rs[tripid]' 
			";
			$resx = mysql_db_query($db_name,$str1);
			$rsx = mysql_fetch_assoc($resx);
			$i++;
			$no++;

			if ($rs[tripid] > $max) $max=$rs[tripid];
			if ($i % 2) {
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}

			//echo "<pre>";	print_r($rs);	echo "</pre>";
		?>
              <tr bgcolor="<?=$bg?>">
                <td height="25" align="center"><?=$no?></td>
				<td height="25" align="center">
				<?

				if ($rs["trip_status"] == "1" ){
						echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
				}else if ($rs["trip_status"] == "4" ){
						echo "<img src=\"images/promo_violet.png\" alt=\"สรุปค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
				}else if ($rs["trip_status"] == "3" ){
						echo "<img src=\"images/promo_green.png\" alt=\"ผ่านการตรวจรับเอกสารรอการอนุมัติ\" width=\"24\" height=\"24\">";
				}else if ($rs["trip_status"] == "2" ){
						echo "<img src=\"images/promo_orange.png\" alt=\"บันทึกรายการค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
				}else{
						echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
				}
				?>
				</td>

			<td height="25" align="left"><a href="list.php?tripid=<?=$rs[tripid]?>&sname=<?=$rsx[name]?>&ssurname=<?=$rsx[surname]?>"><?=$rs[tripid]?></a></td>   
                <td height="25" align="left"><?=$rs[tripname]?>                </td>
					<?
				// echo Staff name
			if($pri =='100' || $pri =='80'){
			$resx = mysql_db_query($db_name,"select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where t1.tripid = '$rs[tripid]' ");
			$rsx = mysql_fetch_assoc($resx);
		//	$_SESSION[userid] = $rsx[userid] ;
			echo "<td  align=\"center\">$rsx[name] &nbsp; &nbsp; $rsx[surname] </td>";
			}
			?>
            <td height="25"><?=$rs[note]?></td>
			<?
			if($pri =='100' || $pri =='80'){
			echo "<td align=\"center\"><strong><a href=\"closetrip.php?tripid=$rs[tripid]\">Approve</a></strong></td>";
			echo "<td align=\"center\"><strong><a href=\"account/listprojectgl.php?tripid=$rs[tripid]\" target=\"_blank\">Click</a></strong></td>";
			}
			?>
                <td height="25"  align="center"><nobr><p>
                <a href="trip_detail.php?tripid=<?=$rs[tripid]?>"><img src="images/16x16/id_card.png" width="16" height="16" border="0" title="รายงานการเดินทางเพื่อออกปฏิบัติหน้าที่ในต่างจังหวัด" align="absmiddle"></a>&nbsp;&nbsp;
                <?php
                $strCashHeader = "SELECT COUNT(tripid) AS count_trip
									FROM  trip 
									WHERE trip.header_trip = '".$rs[tripid]."'
									GROUP BY tripid";//AND t2.id_type_cost ='31'	
							$resultCashHeader = mysql_db_query($db_name,$strCashHeader);
							$row_header= mysql_fetch_assoc($resultCashHeader);
							if($row_header['count_trip']>0){

							  ?>
                              <a href="report_cost_downline.php?tripid=<?=$rs[tripid]?>&userid=<?=$rs['userid']?>">
                <img src="images/ico_register.gif" border="0" width="16" title="รายการค่าใช้จ่ายของลูกทีม" align="absmiddle"/></a>	&nbsp;&nbsp;
				<?php } ?>	
                <a href="?tripid=<?=$rs[tripid]?>&action=edit2"><img src="images/16x16/tools.png" width="16" height="16" border="0" title="Edit" align="absmiddle"></a> &nbsp;
                <a href="upload.php?tripid=<?=$rs[tripid]?>"><img src="images/16x16/attachment.png" alt="จัดการไฟล์แนบ" width="16" height="16" border="0" align="absmiddle"></a>
				<?
				$sqlcheck = "
				select tripid from list  where tripid='$rs[tripid]'
				UNION 
				select tripid from tripvalue where tripid = '$rs[tripid]'
				";
				$resultcheck1 = mysql_db_query($db_name,$sqlcheck);
				$resultnum1 = @mysql_num_rows($resultcheck1);				
				
				//if($debug=="ON"){echo "<pre> ".intval($resultnum1)." : "; print_r($sqlcheck); echo "</pre>"; }
				
				if( intval($resultnum1) == '0' && $pri== "100"){
				?>
				<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&tripid=<?=$rs[tripid]?>';" >
				<img src="images/16x16/delete.png" width="16" height="16" border="0" title="Delete"></a>
				<? } ?>
				</td>
				<? if($pri == "100"){ ?>
                <td  align="center"><? 
				$sql_uncheck = "
						select tripid  from list  where tripid='$rs[tripid]' and (close='y' or endtrip ='y' or cleartrip = 'y')
						UNION
						select tripid  from tripvalue  where tripid='$rs[tripid]' and (close='y' or endtrip ='y' or cleartrip = 'y')
						"; 
				//echo "<pre>$sql_uncheck </pre>";
					
				$result_unc = mysql_db_query($db_name,$sql_uncheck);  
				$num_unc = mysql_num_rows($result_unc);
				if($num_unc > 0 ){?><img src="images/16x16/lock.png" width="16" height="16" border="0" alt="ล้างค่าสถานะ" style="cursor:pointer" onClick="if(confirm('ต้องการปลดล๊อกจริงหรือไม่')==true){popWindow('clear_status.php?tripid=<?=$rs[tripid]?>&action=clear_value','450','200'); }"><? }?></td>
				<? } ?>
              </tr>
              <?
		}
		
		$sql_header = " SELECT header_trip, userid FROM `trip` WHERE `header_trip`!='0' AND downline_status='1' ";
		$query_header = mysql_db_query($db_name,$sql_header);	
		$arr_user = array();
		while ($row_header = mysql_fetch_assoc($query_header)){	
			$header_user_id = getUserTrip($row_header['header_trip']);
			//User ที่เพิ่มที่หลัง นาย ธนพัฒน์
			if($header_user_id >= 44){
				$arr_user[] = $header_user_id;
			}
		}
		
		
		#ให้แสดงรายการเฉพาะพี่จักร
		
		if($_SESSION['userid']==9){
		$in_userid = implode("','",$arr_user);
		/*
			เพิ่ม
			45 พีระเชษฐ์
			81 นพรัตน์
			89 ฉัตรชัย
			91 เอกพงศ์
			137 วชิรจักร
			
		*/
		$str_staff = "		
			SELECT  trip.tripid,trip.tripname,trip.note ,trip.trip_status,trip.userid
				FROM   trip $inner_code  
				WHERE trip.userid IN('".$in_userid."','45','81','89','91','137') 
				AND trip.trip_status = '1'
				AND substring(trip.tripid,1,4) = '$year_r'   
				GROUP BY  trip.tripid ORDER BY  trip.tripid ;
			";	
		$query_staff = mysql_db_query($db_name,$str_staff);	
		while ($rowstaff = mysql_fetch_assoc($query_staff)){	
			$bg = ($no%2)?"#FFFFFF":"#F0F0F0";
			$no++;
		?>
        	<TR bgcolor="<?=$bg?>">
            	<td align="center"><?=$no?></td>
            	<td align="center">
                <?

				if ($rowstaff["trip_status"] == "1" ){
						echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
				}else if ($rowstaff["trip_status"] == "4" ){
						echo "<img src=\"images/promo_violet.png\" alt=\"สรุปค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
				}else if ($rowstaff["trip_status"] == "3" ){
						echo "<img src=\"images/promo_green.png\" alt=\"ผ่านการตรวจรับเอกสารรอการอนุมัติ\" width=\"24\" height=\"24\">";
				}else if ($rowstaff["trip_status"] == "2" ){
						echo "<img src=\"images/promo_orange.png\" alt=\"บันทึกรายการค่าใช้จ่ายเสร็จสิ้น\" width=\"24\" height=\"24\">";
				}else{
						echo "<img src=\"images/promo_red.png\" alt=\"อยู่ในระหว่างการป้อนรายการ\" width=\"24\" height=\"24\">";
				}
				?>
                </td>
                <td>
				<?=$rowstaff['tripid'];?>
                <?php
				$sql_user = "SELECT * FROM `cos_user` WHERE `userid`='".$rowstaff['userid']."' ";
				$query_user = mysql_query($sql_user);
				$user = mysql_fetch_assoc($query_user);
                ?>
                <br/>
				<strong>(<?php echo  $user["name"]."  ".$user["surname"];?>)</strong>
                </td>
            	<td><?=$rowstaff['tripname']?></td>
                <td><?=$rowstaff['note']?></td>
            	<td align="center">
                 <?php
                $strCashHeader = "SELECT COUNT(tripid) AS count_trip
									FROM  trip 
									WHERE trip.header_trip = '".$rs[tripid]."'
									GROUP BY tripid";//AND t2.id_type_cost ='31'	
							$resultCashHeader = mysql_db_query($db_name,$strCashHeader);
							$row_header= mysql_fetch_assoc($resultCashHeader);
							if($row_header['count_trip']>0){

							  ?>
                              <a href="report_cost_downline.php?tripid=<?=$rowstaff[tripid]?>&userid=<?=$rowstaff['userid']?>">
                <img src="images/ico_register.gif" border="0" width="16" title="รายการค่าใช้จ่ายของลูกทีม" align="absmiddle"/></a>	&nbsp;&nbsp;
				<?php } ?>	
                </td>
            </TR>
         <?php 
		 		}
			}
		  ?>
            </table>

            
            </div>
            <br>
            <p>

              <?

}


if ($_GET[action]=="edit2"){

		$sql = "select * from trip where tripid='$tripid'  ;";

		$result = mysql_db_query($db_name,$sql);

		if ($result)

		{

		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

		}





}

?>

            </p>

			<? if ($_GET[action]){ ?>

            <form  name="form1" method = POST  action = "<?  echo $PHP_SELF ; ?>" onSubmit="return ch1();">

              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">

              <a name="adddata" id="adddata"></a>

              
			  
			  
			  <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">

                <tr>

                  <td colspan=3 align="left" valign="top" bgcolor="#888888"><B class="gcaption">

                    <?=($rs[tripid]!=0?"แก้ไข":"เพิ่ม")?>

                    Trip</B></td>

                </tr>

                <tr>

                  <td align="right" valign="middle"><strong>รหัสTrip</strong></td>

                  <td align="left" valign="top">

				  <?

					 if ($_GET[action]=="edit2"){
						 
					  $disabled = ($pri =='80' && $rs['userid'] != $_SESSION[userid])?'disabled':'';	
				  	  echo  $rs[tripid] ;

					 }else{

					$sqlid =  "SELECT MAX(SUBSTRING(tripid,7)) AS tripid  FROM trip WHERE tripid LIKE('".(date("Y")+543)."%') ";

					 $resultid  = mysql_db_query($db_name,$sqlid);

					 $rsid = mysql_num_rows($resultid);
					 $rowid = mysql_fetch_assoc($resultid);

					 /*while ($rsid = mysql_fetch_assoc($resultid)){	

				 		$id = substr($rsid[tripid],6);

					}*/
					$id = $rowid['tripid'];
					 $id = intval($id) + 1;

				$year = date("Y")+543;

				$yearid  = $year.date("m");

				$tripid = sprintf("%s%04d",$yearid,$id);

				echo  $tripid;
				

				}

				  

				  ?>

				  <INPUT NAME="tripid" TYPE="hidden" id="tripid" VALUE="<?=$tripid?>"></td>

                </tr>



                <tr>

                  <td align="right" valign="middle" width="20%"><strong>ชื่อTrip</strong></td>

                  <td align="left" valign="top" width="60%"><input name="tripname" type="text" class="input_text" id="tripname" value="<?=$rs[tripname]?>" size="50" <?=$disabled?> ></td>

                </tr>

                <tr>

                  <td align="right" valign="top"><strong>หมายเหตุ</strong></td>

                  <td align="left" valign="top"><textarea name="note" cols="70" rows="5" class="input_text" id="note" <?=$disabled?>><?=$rs[note]?></textarea></td>

                </tr>

                <tr>
                  <td align="right" valign="top"><strong>ช่วงเวลา</strong></td>
                  <td align="left" valign="top">
				    <?
					  $strSQL =" SELECT * FROM `trip_schedule` WHERE (`trip_id`='$tripid') order by no_ref asc  ";
					 $resultid_time  = mysql_db_query($db_name,$strSQL);
					 while ($rs_time = mysql_fetch_assoc($resultid_time)){	
						$timeA[]=$rs_time[start_date];
						$timeB[]=$rs_time[end_date];
						
						$arrA=explode("-",$rs_time[start_date]);
						$getdayA=$arrA[2]."/".$arrA[1]."/".$arrA[0];						
						$arrB=explode("-",$rs_time[end_date]);
						$getdayB=$arrB[2]."/".$arrB[1]."/".$arrB[0];
						
						$schedule_id = $rs_time[schedule_id];
						$no_ref =  $rs_time[no_ref];
						$time_ref =  $rs_time[timestamp];
					 }			
					 if(@mysql_num_rows($resultid_time)>1){
						 $strSQL =" SELECT * FROM `trip_schedule` WHERE (`trip_id`='$tripid') AND schedule_id <> $schedule_id  order by no_ref asc  ";
						 $resultid_time  = mysql_db_query($db_name,$strSQL);
						 while ($rs_time = mysql_fetch_assoc($resultid_time)){	
							echo "<div><strong>ครั้งที่ $rs_time[no_ref]</strong> ตั้งแต่วันที่ ".swapdatedat($rs_time[start_date])."  ถึง ".swapdatedat($rs_time[end_date])." &nbsp;&nbsp;&nbsp;&nbsp; บันทึกเมื่อเวลา $rs_time[timestamp]</div>"; 
						 }
						 echo "<strong><i>ครั้งล่าสุด</i></storng>";
					 }else{
						 if(@mysql_num_rows($resultid_time)==0){
							$add_news = "true";		 
						 }
					 }
					 
					 if(@mysql_num_rows($resultid_time)>0){
						echo "<div id='late_date' style='display:none'><strong>ครั้งที่ $no_ref</strong> ตั้งแต่วันที่ $getdayA  ถึง $getdayB &nbsp;&nbsp;&nbsp;&nbsp; บันทึกเมื่อเวลา $time_ref</div>"; 	 
					 }					 
                      ?>

                  	  <input type="text" name="getdayA" id="getdayA" readonly value="<?=$getdayA?>">
                  	  <input type='button' onClick="popUpCalendar(this, form1.getdayA, 'dd/mm/yyyy')" value=' เลือกวัน ' class='input' onFocus="header_trip();" <?=$disabled?>>
                   		ถึง
                      <input type="text" name="getdayB" id="getdayB" readonly value="<?=$getdayB?>" onFocus="header_trip();">
               	    <input type='button' onClick="popUpCalendar(this, form1.getdayB, 'dd/mm/yyyy')" value=' เลือกวัน ' class='input' <?=$disabled?>>
					  <? if ($_GET[action]=="edit2"){ ?>
                      <br />
                  	  <INPUT NAME="schedule_id" TYPE="hidden" id="schedule_id" VALUE="<?=$schedule_id?>">
                      <INPUT NAME="no_ref" TYPE="hidden" id="no_ref" VALUE="<?=$no_ref?>">
                      <input name="trip_advance" id="trip_advance" type="checkbox" value="ON" <?=$add_news=="true"?"checked":""?> onClick="show_time('late_date')" <?=$disabled?>/> ระบุเป็นช่วงเวลาต่อเนื่องหรือเพิ่มเติม
                      <? } ?>
                      </td>
                </tr>
                <tr>
                	<td align="right"  valign="top"><strong>สถานะ</strong></td>
                	<td align="left"><input type="checkbox" name="downline_status" id="downline_status" value="1" onClick="checkDownline();" <?php echo ($rs['downline_status']==1)?"checked":"";?> <?=$disabled?>>&nbsp;เป็นลูกทีม</td>
                 </tr>
                 <?php
				 $headeruser = getUserTrip($rs['header_trip']);
				 if($headeruser!=""){
					 $sql_headeru = "SELECT * FROM `cos_user` WHERE userid='".$headeruser."' ";
					 $query_headeru = mysql_db_query($db_name,$sql_headeru);
					 $rs_hu = mysql_fetch_assoc($query_headeru); 
                 ?>
                 <tr>
                	<td align="right"  valign="top"><strong>หัวหน้าทีม</strong></td>
                	<td align="left">คุณ<?=$rs_hu['name']."  ".$rs_hu['surname'];?></td>
                 </tr>
               <?php
				 }
			   $sql_downline = "SELECT trip.tripid, 
													trip.tripname, 
													trip.header_trip, 
													cos_user.userid,
													cos_user.name, 
													cos_user.surname
												FROM trip INNER JOIN cos_user ON trip.userid = cos_user.userid
												WHERE trip.header_trip='".$rs['tripid']."'
												AND trip.header_trip IS NOT NULL 
												AND trip.header_trip!=''
												ORDER BY cos_user.name ASC
												";
				$q_downline = mysql_db_query($db_name,$sql_downline);
				$num_downline = mysql_num_rows($q_downline);
               ?>
                
                <tr>
                	<td align="right"  valign="top"><strong>หัวหน้าเลือกลูกทีม</strong></td>
                	<td align="left">
                    <table>
                    	<tr>
                        <td>
                        <span id="div_headerid">
                        <select name="downlineid" id="downlineid" onChange="user_trip('downline_trip','sl_downline_trip',this.value);" <?=($rs['header_trip']>0 || $rs['downline_status']==1)?"disabled":"";?> >
                        <option value="">เลือกลูกทีม</option>
                        <?php
						$begin_date = $getdayA; 
						$end_date = $getdayB;
						$arr_begin_date = explode("/",$begin_date);
						$arr_end_date = explode("/",$end_date);
						$begin_date = ($arr_begin_date[2])."-".$arr_begin_date[1]."-".$arr_begin_date[0]; 
						$end_date = ($arr_end_date[2])."-".$arr_end_date[1]."-".$arr_end_date[0]; 
						$begin_datedown = strtotime("-15 day", strtotime($begin_date));
						$end_dateup = strtotime("+15 day", strtotime($end_date));
					
						if($getdayA!="" && $getdayB!=""){
							$where_date = " AND trip_schedule.start_date BETWEEN '".date("Y-m-d",$begin_datedown)."' AND '".date("Y-m-d",$end_dateup)."' ";
						}else{
							$where_date = "";
						}
						$sql_userm = " SELECT cos_user.userid, 
													cos_user.name, 
													cos_user.surname,
													trip.tripid, 
													trip_schedule.start_date, 
													trip_schedule.end_date
												FROM cos_user 
													 INNER JOIN trip ON cos_user.userid = trip.userid
													 INNER JOIN trip_schedule ON trip.tripid = trip_schedule.trip_id
												WHERE pri!='0' 
												".$where_date."
												AND trip.trip_status = '1'
												AND downline_status='1'
												GROUP BY cos_user.userid
												ORDER BY cos_user.name ASC
												 ";
										 
						$query_userm  = mysql_db_query($db_name,$sql_userm);
					 	while ($row_userm = mysql_fetch_assoc($query_userm)){	
							echo '<option value="'.$row_userm['userid'].'" >คุณ'.$row_userm['name']."  ".$row_userm['surname'].'</option>';
					 	}
                        ?>
                        </select>
                        </span>
                        <?php
						if($_GET['debug']=='on'){
							echo $sql_userm;
						}		
                        ?>
                        </td>
                        <td>
                        <span id="downline_trip">
                        	<select name="sl_downline_trip" id="sl_downline_trip" <?=($rs['header_trip']>0 || $rs['downline_status']==1)?"disabled":"";?>>
							  <option value="">เลือกทิป</option>
                            </select>
                         </span>   
                         </td>
                         <td><input type="button" name="b_add"  id="b_add" value=" เพิ่มลูกทีม " onClick="addList();" <?=($rs['header_trip']>0 || $rs['downline_status']==1)?"disabled":"";?>/></td>
                        </tr>
                    </table>
                    <ol id="files-root">
			
                        <?php
						
						 $intFiles = 0;
						 while($downline = mysql_fetch_assoc($q_downline)){
							 echo '<li id="file-'.$intFiles.'">';
							 echo '<table cellpadding="1" cellspacing="1" ><tr>';
							 echo '<td width="150" align="left">';
							 echo "คุณ".$downline['name']."  ".$downline['surname'];
							 echo '<input type="hidden" name="header_user[]" value="'.$downline['userid'].'"/>
                        			<input type="hidden" name="trip_user[]" value="'.$downline['tripid'].'"/>';
							 echo '</td>';
							 echo '<td align="left">';
							 echo $downline['tripid'].":".$downline['tripname'];
							 echo '</td>';
							 echo '<td align="left">';
							 echo '<a href="javascript:removeFile(\''.$intFiles.'\');"><img src="images/delete.png" aling="absmiddle" width="18" border="0"></a>';
							 echo '</td>';
							 echo '</tr></table>';
							 echo '</li>';
							 $intFiles++;
						}
                        ?>
                        </ol>
                        
                    </td>
                <tr/>
                <tr>
                  <td align="right" valign="top" width="20%">&nbsp;</td>
                  <td align="left" valign="top" width="60%"><input type="submit" name="Submit" value=" บันทึก "  <?=$disabled?>>
                      <input type="reset" name="Submit2" value="Reset" <?=$disabled?>>
                      <input type="reset" name="Submit3" value="ยกเลิก" ONCLICK="<? if ($_GET[action] == "edit2") echo "location.href='?';"; else echo "window.close();"; ?>">
                    
                    </td>

                </tr>

              </table>
			<table  style="margin-left:150px;">
            <tr><td>
            <strong>หมายเหตุ</strong>
            <br/>
            ลูกทีมคือ บุคคลที่ไม่สามารถเบิกค่าใช่จ่ายได้ด้วยตัวเอง  โดยหัวหน้าทีมจะทำการเลือกลูกทีมที่อยู่ในความดูแลของตัวเอง
            <p/>&nbsp;
            </td></tr>
            </table>
          </form>          
		  
		  <? }?>
          
		  
		  </td>

      </tr>

    </table>
    
    </td>

  </tr>

</table>

</body>

</html>
<? if($debug == "ON"){ echo "<pre>"; print_r($_SESSION); echo "</pre>"; }?>
