<?php
set_time_limit(0);
include ("checklogin.php");

include ("config/phpconfig.php");





if ($_SERVER[REQUEST_METHOD] == "POST"){

			If ($tripname =='')

			{

			exit();

			}

			 if ($_POST[action]=="edit2")

			 {

				$sql = "update trip set  tripname='$tripname' , note='$note' ,updatetime = now()

				 where tripid ='$tripid' ;";

				mysql_query($sql);

				if (mysql_errno())

				{

					$msg = "Cannot update parameter information.";

				}

				else

				{

					header("Location: ?id=$id&action=edit&refreshpage=1");

					exit;

				}

			}else

				{

				$sql = "INSERT INTO  trip (tripid,tripname,note,userid,updatetime)	VALUES ('$tripid','$tripname','$note','$_SESSION[userid]',now())";

					$result  = mysql_query($sql);

					if($result)

					{

						header("Location: ?id=$id&action=edit&refreshpage=1");

						exit;

					}else

					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}

				}

}else if ($_GET[action] == 'delete')

	{

		$sqlc = "select * from list where tripid = '$tripid'";

		$resultc = mysql_query($sqlc);

		$rsc = mysql_num_rows($resultc);

		If ($rsc == "0")

		{

		mysql_query("delete from trip where tripid = $tripid ");

		if (mysql_errno())

			{

			$msg = "Cannot delete parameter.";

			}else

			{

			header("Location: ?runid=$runid&action=edit&refreshpage=1");

			exit;

			}

		}else

		{

			$msg = "<b class='blue'>Complete</b><br>ไม่สามารถลบข้อมูลได้เนื่องจากมีข้อมูลภายใน Trip นี้";

	echo $msg;

	include("msg_box.php");

	header("Location: addtrip.php");

		}

	

}else

		{		

	 	$sql = "select * from  trip   ;";

		$result = mysql_query($sql);

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

    <td valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>

        <?

 if ($_GET[action]!="edit2")

 {

?>

        <td valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">

          <tr>

            <td height="30" colspan="2"><B class="pheader">

              เลือกTrip การเดินทาง </B></td>

          </tr>

          <tr bgcolor="#CACACA">

            <td width="862" bgcolor="#888888">&nbsp;</td>

            <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">

              <input name="Button25"  title="ยกเลิก" type="button"  style="width: 50;" class="xbutton" value="Exit" onClick="location.href='logout.php';" >

              &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>

          </tr>

        </table>

		<?

		If ($pri =='100')

		{

		?>

          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

            <tr>

              <td width="0%">&nbsp;</td>

              <td width="23%"><img src="bimg/report.gif" width="16" height="16"><a href="listallproject.php">รายงานจำแนกตามโครงการทั้งหมด</a></td>

              <td width="21%"><img src="bimg/report.gif" width="16" height="16"><a href="listalltypecost.php">รายงานแสดงตามหมวดค่าใช้จ่าย</a></td>

              <td width="27%"><img src="bimg/report.gif" width="16" height="16"><a href="report_staff.php" target="_blank">รายงานแสดงตามหมวดค่าใช้จ่ายตามช่วงเวลา</a></td>

              <td width="13%" align="center"><img src="bimg/report.gif" width="16" height="16"><a href="addtype_project.php">เพิ่มโครงการ</a></td>

              <td width="16%"><img src="bimg/report.gif" width="16" height="16"><a href="setproject.php">ปรับโครงการทั้งหมด</a></td>

            </tr>

          </table>

		  <?

		  }

		  ?>

          <br>

            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">



              <tr>

                <td width="20%" align="right" bgcolor="#A3B2CC"><strong>Staff Name: </strong></td>

                <td bgcolor="#CCCCCC"><strong>

				&nbsp;

				<?=GetTripOwner($tripid)?>

				

                  <?=$_SESSION[name]?>

                  &nbsp;&nbsp;

                  <?=$_SESSION[surname]?>

				  

                </strong></td>

              </tr>

            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="73%">&nbsp;</td>

                <td width="27%" align="center"><a href="#adddata">เพิ่มรายการ Trip </a></td>
              </tr>
              <tr>
                <td colspan="2"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
                  <tr>
                    <td align="center"><img src="bimg/close.gif" width="15" height="15">&nbsp;<img src="bimg/clear.gif" width="15" height="15">&nbsp;<img src="bimg/start.gif" width="15" height="15">&nbsp;<img src="bimg/finish.gif" width="15" height="15"></td>
                    <td><a href="?showall=y">แสดงทั้งหมด</a></td>
                  </tr>
                  <tr>
                    <td width="114" align="center"><img src="bimg/close.gif" width="15" height="15">&nbsp;<img src="bimg/clear.gif" width="15" height="15">&nbsp;<img src="bimg/start.gif" width="15" height="15"></td>
                    <td width="1113"><a href="?">เฉพาะที่ยังดำเนินการ</a></td>
                  </tr>
                  <tr>
                    <td width="114" align="center"><img src="bimg/finish.gif" width="15" height="15"></td>
                    <td><a href="?cleartrip=y">สรุปค่าใช้จ่ายเสร็จสิ้น</a></td>
                  </tr>
                  <tr>
                    <td width="114" align="center"><img src="bimg/close.gif" width="15" height="15"></td>
                    <td><a href="?close=y">ผ่านการตรวจรับเอกสาร รอการอนุมัติ </a></td>
                  </tr>
                  <tr>
                    <td width="114" align="center"><img src="bimg/clear.gif" width="15" height="15"></td>
                    <td><a href="?endtrip=y">บันทึกรายการค่าใช้จ่ายเสร็จสิ้น</a></td>
                  </tr>
                  <tr>
                    <td width="114" align="center"><img src="bimg/start.gif" width="15" height="15"></td>
                    <td><a href="?entry=y">อยู่ในระหว่างการป้อนรายการ</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>

            <?

	// หาปี 					

						$previous_url = " <div align=right> &nbsp;     ";   

						$next_url = " <div align=left>&nbsp;   ";

						

						$sql_yy = "  select min(substring(tripid,1,4)) as minYY,max(substring(tripid,1,4)) as maxYY  from trip  " ; 

						$query_result = mysql_query($sql_yy);

						$result_yy = mysql_fetch_assoc($query_result) ;	

						

						$maxYY1 = $result_yy[maxYY]  ;   $minYY1 = $result_yy[minYY]  ;

						if ($year_r == "" ) {	$year_r =  $maxYY1 ;   }											

						if ($maxYY1 > $year_r ){

								$next_year =$year_r + 1 ;  		$previous_year = $year_r  - 1 ; 		

								$next_url = "<a href='?year_r=".$next_year."'><img src=\"bimg/next.jpg\" width=\"20\" height=\"20\" border=\"0\"></a> ";  

						}

						if ($minYY1 < $year_r ){

								$previous_year = $year_r - 1 ; 		$next_year =$year_r + 1 ; 			

								$previous_url = "<a href='?year_r=" . $previous_year ."'><img src=\"bimg/back.jpg\" width=\"20\" height=\"20\" border=\"0\"> </a> ";  

						}

						

					//====================================================================================

//===================================================================== 

?>

            <br>

            <br>

            <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="16%" align="left"><strong>

                  <?=$previous_url?>

                </strong></td>

                <td width="68%" align="center"><strong> ปีพ.ศ.

                    <?=$year_r?>

                </strong></td>

                <td width="16%" align="right"><strong>

                  <?=$next_url

?>

                </strong> </td>

              </tr>

            </table>

            <table width="95%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">

              <tr bgcolor="#A3B2CC">

                <td width="4%" height="25" align="center"><b>ลำดับ</b></td>

                <td width="4%" height="25" align="center">&nbsp;</td>

                <td width="9%" height="25" align="center"><strong>รหัสTrip</strong></td>

                <td width="30%" height="25" align="center"><strong>ชื่อTrip</strong></td>

                <?

			if($pri =='100'){
			echo "<td align=\"center\"><strong>ชื่อStaff</strong></td>";
			}
			?>
                <td width="33%" height="25" align="center"><strong>หมายเหตุ</strong></td>
			<?
			if($pri =='100'){
			echo "<td align=\"center\">ทำรายการอนุมัติ</td>";
			echo "<td align=\"center\">ออกรายงาน GL</td>";
			}
			?>

                <td width="12%" height="25" align="center"><strong>เครื่องมือ</strong></td>
				<? if($pri == "100"){?>
                <td width="8%" align="center"><strong>ล้างสถานะ</strong></td>
				<? } ?>
              </tr>

       <?php

		$i = 0;
		$no=0;
		$max=0;
		if($close=="y"){
			$cond = " AND list.endtrip  = 'y' AND list.close = ''   AND list.cleartrip  = 'y' ";
		}else if($endtrip=="y"){
			$cond = " AND list.endtrip  = 'y' AND list.close = ''   AND list.cleartrip  = '' ";
		}else if($cleartrip=="y"){
			$cond = " AND list.endtrip  = 'y' AND list.close = 'y'   AND list.cleartrip  = 'y' ";
		}else  if($entry=="y"){
			$cond = "AND list.close = ''   AND list.cleartrip  = ''  AND list.endtrip  = '' ";
		}else  if($showall=="y"){
			$cond = " ";
		}else{
			$cond = "AND list.close = ''   AND ( list.cleartrip  = '' OR  list.cleartrip  = 'y'  ) AND ( list.endtrip  = ''  OR list.endtrip  = 'y'  )";
		}		

		if($pri == '100'){
		
		$str1 = "select trip.tripid,trip.tripname,trip.note from   trip LEFT JOIN list  ON  trip.tripid =  list.tripid  where substring(trip.tripid,1,4) = '$year_r'  $cond group by trip.tripid order by trip.tripid ;" ;
		//echo $str1 ;
			$result = mysql_query($str1);
		}else{
			$result = mysql_query("select  trip.tripid,trip.tripname,trip.note from   trip LEFT JOIN list  ON  trip.tripid =  list.tripid  where (trip.userid = '$_SESSION[userid]') and substring(trip.tripid,1,4) = '$year_r'   $cond  group by  trip.tripid order by  trip.tripid ;");				
		}
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){		
		
			$resx = mysql_query("select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where t1.tripid = '$rs[tripid]' ");
			$rsx = mysql_fetch_assoc($resx);
			$i++;
			$no++;

			if ($rs[tripid] > $max) $max=$rs[tripid];
			if ($i % 2) {
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}

		?>
              <tr bgcolor="<?=$bg?>">
                <td height="25" align="center"><?=$no?></td>
				<td height="25" align="center">
				<?
				$trip = 0;
				$closed = $ended = $cleared = true;
				$sqlcheck = "select * from list  where tripid='$rs[tripid]' ; ";
				$resultcheck = mysql_query($sqlcheck);
				$resultnum = mysql_num_rows($resultcheck);
				while ($rscheck=mysql_fetch_array($resultcheck,MYSQL_ASSOC)) {
					if ($rscheck["close"] != "y")  $closed = false;
					if ($rscheck["endtrip"] != "y")  $ended = false;
					if ($rscheck["cleartrip"] != "y")  $cleared = false;
				}
				
				if ($resultnum == "0"){
					echo "<img src=\"bimg/start.gif\" width=\"15\" height=\"15\">";
				}else{
					if ($closed){
						echo "<img src=\"bimg/finish.gif\" width=\"15\" height=\"15\">";
					}else if ($cleared){
						echo "<img src=\"bimg/close.gif\" width=\"15\" height=\"15\">";
					}else if ($ended){
						echo "<img src=\"bimg/clear.gif\" width=\"15\" height=\"15\">";
					}else{
						echo "<img src=\"bimg/start.gif\" width=\"15\" height=\"15\">";
					}
				}
				?>
				</td>
				<?

				/*

				If ($pri=="100")

				{

				echo  "

                <td align=\"left\"><a href=\"list.php?tripid=<?=$rs[tripid]?>&sname=<?=$rsx[name]?>&ssurname=<?=$rsx[surname]?>\"><?=$rs[tripid]?></a></td>  " ;

				}else

				{

				echo "<td align=\"left\"><a href=\"list.php?tripid=<?=$rs[tripid]?>\"><?=$rs[tripid]?></a></td>  " ; 

				}

				*/

				

				?>

			<td height="25" align="left"><a href="list.php?tripid=<?=$rs[tripid]?>&sname=<?=$rsx[name]?>&ssurname=<?=$rsx[surname]?>"><?=$rs[tripid]?></a></td>   
                <td height="25" align="left"><?=$rs[tripname]?>                </td>
					<?
				// echo Staff name
			if($pri =='100'){
			$resx = mysql_query("select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where t1.tripid = '$rs[tripid]' ");
			$rsx = mysql_fetch_assoc($resx);
		//	$_SESSION[userid] = $rsx[userid] ;
			echo "<td  align=\"center\">$rsx[name] &nbsp; &nbsp; $rsx[surname] </td>";
			}
			?>
            <td height="25"><?=$rs[note]?></td>
			<?
			if($pri =='100'){
			echo "<td align=\"center\"><strong><a href=\"closetrip.php?tripid=$rs[tripid]\">Approve</a></strong></td>";
			echo "<td align=\"center\"><strong><a href=\"account/listprojectgl.php?tripid=$rs[tripid]\" target=\"_blank\">Click</a></strong></td>";
			}
			?>
                <td height="25"  align="center"><p><a href="?tripid=<?=$rs[tripid]?>&action=edit2">
				<img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp;
				<a href="upload.php?tripid=<?=$rs[tripid]?>">
				<img src="bimg/attach.gif" alt="จัดการไฟล์แนบ" width="13" height="12" border="0"></a>
				<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&tripid=<?=$rs[tripid]?>';" >
				<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </p>				</td>
				<? if($pri == "100"){ ?>
                <td  align="center"><? 
				$sql_uncheck = "select * from list  where tripid='$rs[tripid]' and (close='y' or endtrip ='y' or cleartrip = 'y')"; 
				$result_unc = mysql_query($sql_uncheck);  
				$num_unc = mysql_num_rows($result_unc);
				if($num_unc > 0 ){?><a href="#" onClick="popWindow('clear_status.php?tripid=<?=$rs[tripid]?>&action=clear_value','450','200')"><img src="images/lock-clipart1.gif" width="18" height="18" border="0" alt="ล้างค่าสถานะ"></a><? }?></td>
				<? } ?>
              </tr>
              <?
		}
		?>
            </table>

            <br>
            <p>

              <?

}

else if ($_GET[action]=="edit2")

{

		$sql = "select * from trip where tripid='$tripid'  ;";

		$result = mysql_query($sql);

		if ($result)

		{

		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

		}





}

?>

            </p>



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

                  <td align="right" valign="middle">รหัสTrip</td>

                  <td align="left" valign="top">

				  <?

					 if ($_GET[action]=="edit2")

					{

				  	  echo  $rs[tripid] ;

					 }else

					 {

					 $sqlid =  "select tripid  from trip ";

					 $resultid  = mysql_query($sqlid);

				 $rsid = mysql_num_rows($resultid);

				 while ($rsid = mysql_fetch_assoc($resultid))

				 {	

				 	$id = substr($rsid[tripid],7,4);

				}

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

                  <td align="right" valign="middle" width="20%">ชื่อTrip</td>

                  <td align="left" valign="top" width="60%"><input name="tripname" type="text" class="input_text" id="tripname" value="<?=$rs[tripname]?>" size="50">                  </td>

                </tr>

                <tr>

                  <td align="right" valign="top">หมายเหตุ</td>

                  <td align="left" valign="top"><textarea name="note" cols="70" rows="5" class="input_text" id="note"><?=$rs[note]?>

                  </textarea></td>

                </tr>

                <tr>

                  <td align="right" valign="top" width="20%">&nbsp;</td>

                  <td align="left" valign="top" width="60%"><input type="submit" name="Submit" value=" บันทึก ">

                      <input type="reset" name="Submit2" value="Reset">

                      <input type="reset" name="Submit3" value="ยกเลิก" ONCLICK="<? if ($_GET[action] == "edit2") echo "location.href='?';"; else echo "window.close();"; ?>">                  </td>

                </tr>

              </table>

            </form>          </td>

      </tr>

    </table></td>

  </tr>

</table>

</body>

</html>

