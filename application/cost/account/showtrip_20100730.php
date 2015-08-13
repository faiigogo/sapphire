<?php
include ("../checklogin.php");
include ("../phpconfig.php");


if ($_SERVER[REQUEST_METHOD] == "POST"){
			 if ($_POST[action]=="edit2")
			 {
				$sql = "update trip set  tripname='$tripname' , note='$note'
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
				$sql = "INSERT INTO  trip (tripid,tripname,note,userid)	VALUES ('$tripid','$tripname','$note','$_SESSION[userid]')";
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
<link href="../cost.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>

<?
//refresh openner
if ($refreshpage){
?>	
<SCRIPT LANGUAGE="JavaScript">
<!--
opener.document.forms[0].submit();
//-->
</SCRIPT>

<?
}
?>
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
              <input name="Button25"  title="ยกเลิก" type="button"  style="width: 50;" class="xbutton" value="Exit" onClick="location.href='../logout.php';" >
              &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
          </tr>
        </table>
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
                <td align="center" bgcolor="#FFFFFF">
				<?
				echo  "<a href=\"cleartrip.php\" target=\"_blank\">ทำการปิดรายการในแต่ละทริป</a>";
				?>
				</td>
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
								$next_url = "<a href='?year_r=".$next_year."'><img src=\"../bimg/next.jpg\" width=\"20\" height=\"20\" border=\"0\"></a> ";  
						}
						if ($minYY1 < $year_r ){
								$previous_year = $year_r - 1 ; 		$next_year =$year_r + 1 ; 			
								$previous_url = "<a href='?year_r=" . $previous_year ."'><img src=\"../bimg/back.jpg\" width=\"20\" height=\"20\" border=\"0\"> </a> ";  
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
                <td><div align="center"><b>ลำดับ</b></div></td>
                <td>&nbsp;</td>
                <td><div align="center"><strong>รหัสTrip</strong></div></td>
                <td><div align="center"><strong>ชื่อTrip</strong></div></td>
			<td align="center"><strong>ชื่อStaff</strong></td>
                <td align="center">ปิดรายการทางบัญชี</td>
                <td align="center">ออกรายงาน GL </td>
                <td align="center"><strong>หมายเหตุ</strong></td>
				<?
			If ($pri =='100')
			{
			echo "<td align=\"center\">ทำรายการอนุมัติ</td>";
			}
			?>
              </tr>
              <?php
		$i = 0;
		$no=0;
		$max=0;
		$result = mysql_query("select tripid,tripname from   trip  where substring(tripid,1,4) = '$year_r'   group by tripid order by tripid;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$resx = mysql_query("select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where  t1.tripid = '$rs[tripid]' ");
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
                <td align="center"><?=$no?>                </td>
				<td align="left">
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
					echo "<img src=\"../bimg/start.gif\" width=\"15\" height=\"15\">";
				}else
				{
					if ($closed){
						echo "<img src=\"../bimg/finish.gif\" width=\"15\" height=\"15\">";
					}else if ($cleared){
						echo "<img src=\"../bimg/close.gif\" width=\"15\" height=\"15\">";
					}else if ($ended){
						echo "<img src=\"../bimg/clear.gif\" width=\"15\" height=\"15\">";
					}else{
						echo "<img src=\"../bimg/start.gif\" width=\"15\" height=\"15\">";
					}
				}
				?>				</td>
			<td align="left"><a href="list.php?tripid=<?=$rs[tripid]?>&sname=<?=$rsx[name]?>&ssurname=<?=$rsx[surname]?>" ><?=$rs[tripid]?></a></td>   
                <td align="left"><?=$rs[tripname]?>                </td>
			<?
			$resx = mysql_query("select  t2.userid,t2.name,t2.surname  from  trip t1 left join cos_user t2 on  t1.userid = t2.userid where t1.tripid = '$rs[tripid]' ");
			$rsx = mysql_fetch_assoc($resx);
			?>
                <td  align="center"><?=$rsx[name]?> &nbsp; &nbsp; <?=$rsx[surname]?> </td>
                <td  align="center">
				<?
				if ($resultnum == "0")
				{
					echo "ยังไม่มีการบันทึกค่าใช้จ่าย";
				}elseif ($closed) 
				{
					echo "สิ้นสุดการตรวจสอบ";
				}else
				{
				?>
				<a href="cleartrip.php?tripid=<?=$rs[tripid]?>" >Click</a>
				<?
				}
				?>				</td>
                <td  align="center"><?
				/*
				if ($resultnum == "0")
				{
					echo "ยังไม่มีการบันทึกค่าใช้จ่าย";
				}elseif ($closed) 
				{
					echo "สิ้นสุดการตรวจสอบ";
				}else
				{
					*/
				?>
			
                  <a href="listprojectgl.php?tripid=<?=$rs[tripid]?>" target="_blank">Click</a>
                  <?
				  /*
				}
				*/?></td>
                <td  align="center"><?=$rs[note]?></td>
								<?
			If ($pri =='100')
			{
			echo "<td align=\"center\"><strong><a href=\"closetrip.php?tripid=$rs[tripid]\">Approve</a></strong></td>";
			}
			?>
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
                <td width="20"><img src="../bimg/finish.gif" width="15" height="15"></td>
                <td>สรุปค่าใช้จ่ายเสร็จสิ้น</td>
              </tr>
              <tr>
                <td width="20"><img src="../bimg/close.gif" width="15" height="15"></td>
                <td>ผ่านการตรวจรับเอกสาร รอการอนุมัติ </td>
              </tr>
              <tr>
                <td width="20"><img src="../bimg/clear.gif" width="15" height="15"></td>
                <td>บันทึกรายการค่าใช้จ่ายเสร็จสิ้น</td>
              </tr>
              <tr>
                <td width="20"><img src="../bimg/start.gif" width="15" height="15"></td>
                <td>อยู่ในระหว่างการป้อนรายการ</td>
              </tr>
            </table>
            <p>&nbsp;</p>

            <form  method = POST  action = "<?  echo $PHP_SELF ; ?>" >
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
            </form>          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
