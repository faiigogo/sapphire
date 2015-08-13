<?php
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
-->
</style>
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
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
              <td>&nbsp;</td>
              <td><img src="bimg/report.gif" width="16" height="16"><a href="listallproject.php">รายงานจำแนกตามโครงการทั้งหมด</a></td>
              <td><img src="bimg/report.gif" width="16" height="16"><a href="listalltypecost.php">รายงานแสดงตามหมวดค่าใช้จ่าย</a></td>
              <td><img src="bimg/report.gif" width="16" height="16">รายงานแสดงตามชื่อบุคคลากร</td>
              <td>&nbsp;</td>
            </tr>
          </table>
		  <?
		  }
		  ?>
          <br>
            <table width="95%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">

              <tr>
                <td width="20%" align="left" bgcolor="#A3B2CC"><strong>Staff Name: </strong></td>
                <td width="30%" align="center" bgcolor="#FFFFFF"><strong>
				<?=GetTripOwner($tripid)?>
				
                  <?=$_SESSION[name]?>
                  &nbsp;&nbsp;
                  <?=$_SESSION[surname]?>
				  
                </strong></td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table>
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="80%">&nbsp;</td>
                <td align="center"><a href="#adddata">เพิ่มรายการ Trip </a></td>
              </tr>
            </table>
<?
	// หาปี 					
						$previous_url = " <div align=right> &nbsp;     ";   
						$next_url = " <div align=left>&nbsp;   ";
						
						$sql_yy = "  SELECT Max(yy) AS maxYY, Min(yy) AS minYY   FROM    basic_support  " ; 	  		
						$query_result_yy = mysql_db_query($dbname,$sql_yy) ; 
						$result_yy = mysql_fetch_assoc($query_result_yy)  ;			
						
						$maxYY1 = $result_yy[maxYY]  ;   $minYY1 = $result_yy[minYY]  ;
						if ($year_r == "" ) {	$year_r =  $maxYY1 ;   }											
						if ($maxYY1 > $year_r ){
								$next_year =$year_r + 1 ;  		$previous_year = $year_r  - 1 ; 		
								$next_url = "<a href='?year_r=".$next_year."'><img src=\"../../images_sys/next.jpg\" width=\"20\" height=\"20\" border=\"0\"></a> ";  
						}
						if ($minYY1 < $year_r ){
								$previous_year = $year_r - 1 ; 		$next_year =$year_r + 1 ; 			
								$previous_url = "<a href='?year_r=" . $previous_year ."'><img src=\"../../images_sys/back.jpg\" width=\"20\" height=\"20\" border=\"0\"> </a> ";  
						}
						
					//====================================================================================
//===================================================================== 
?>
            <table width="95%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
              <tr bgcolor="#A3B2CC">
                <td height="25" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="16%" align="left"><strong>
                      <?=$previous_url?>
                    </strong></td>
                    <td width="68%" align="center"><strong> ปีพ.ศ.
                      <?
					  //=$year_r
					  echo Year(now());
					   ?>
                    </strong></td>
                    <td width="16%" align="right"><strong>
                      <?
					  //=$next_url
					  echo Year(now());
					  ?>
                    </strong> </td>
                  </tr>
                </table></td>
              </tr>
              <tr bgcolor="#A3B2CC">
                <td height="25"><div align="center"><b>ลำดับ</b></div></td>
                <td height="25">&nbsp;</td>
                <td height="25"><div align="center"><strong>รหัสTrip</strong></div></td>
                <td height="25"><div align="center"><strong>ชื่อTrip</strong></div></td>
			<?
			If ($pri =='100')
			{
			echo "<td align=\"center\"><strong>ชื่อStaff</strong></td>";
			}
			?>
                
                <td height="25" align="center"><strong>หมายเหตุ</strong></td>
				<?
			If ($pri =='100')
			{
			echo "<td align=\"center\">ทำรายการอนุมัติ</td>";
			echo "<td align=\"center\">ออกรายงาน GL</td>";
			}
			?>
                <td height="25" align="center"><strong>เครื่องมือ</strong></td>
              </tr>
              <?php
		$i = 0;
		$no=0;
		$max=0;
		If  ($pri == '100')
		{
		$result = mysql_query("select tripid,tripname from   trip   group by tripid order by tripid;");
		}else
		{
		$result = mysql_query("select tripid,tripname from   trip  where (userid = '$_SESSION[userid]')  group by tripid order by tripid;");		
		}
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
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
                <td height="25" align="center"><?=$no?>                </td>
				<td height="25" align="left">
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
				if ($resultnum == "0")
				{
					echo "<img src=\"bimg/start.gif\" width=\"15\" height=\"15\">";
				}else
				{
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
				?>				</td>
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
			If ($pri =='100')
			{
			$resx = mysql_query("select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where t1.tripid = '$rs[tripid]' ");
			$rsx = mysql_fetch_assoc($resx);
		//	$_SESSION[userid] = $rsx[userid] ;
			echo "<td  align=\"center\">$rsx[name] &nbsp; &nbsp; $rsx[surname] </td>";
			}
			?>
                
                <td height="25"  align="center"><?=$rs[note]?></td>
								<?
			If ($pri =='100')
			{
			echo "<td align=\"center\"><strong><a href=\"closetrip.php?tripid=$rs[tripid]\">Approve</a></strong></td>";
			echo "<td align=\"center\"><strong><a href=\"account/listprojectgl.php?tripid=$rs[tripid]\" target=\"_blank\">Click</a></strong></td>";
			}
			?>
                <td height="25"  align="center"><p><a href="?tripid=<?=$rs[tripid]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&tripid=<?=$rs[tripid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </p>                </td>
              </tr>
              
              <?
		}
		?>
            </table>
            <br>
            <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
              <tr>
                <td width="20">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="20"><img src="bimg/finish.gif" width="15" height="15"></td>
                <td>สรุปค่าใช้จ่ายเสร็จสิ้น</td>
              </tr>
              <tr>
                <td width="20"><img src="bimg/close.gif" width="15" height="15"></td>
                <td>ผ่านการตรวจรับเอกสาร รอการอนุมัติ </td>
              </tr>
              <tr>
                <td width="20"><img src="bimg/clear.gif" width="15" height="15"></td>
                <td>บันทึกรายการค่าใช้จ่ายเสร็จสิ้น</td>
              </tr>
              <tr>
                <td width="20"><img src="bimg/start.gif" width="15" height="15"></td>
                <td>อยู่ในระหว่างการป้อนรายการ</td>
              </tr>
            </table>
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
              <table width="80%" border="0" cellspacing="1" cellpadding="2" align="center">
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
