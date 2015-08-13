<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");

//$date_list = $getyear.'-'.$getmonth.'-'.$getday;
if ($action == "delete"){
	$xsql = mysql_query("select attach from `list` where runno = '$runno'")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$xrs = mysql_fetch_assoc($xsql);
	if(file_exists($xrs[attach])){ unlink($xrs[attach]); }

	$sql = mysql_query("delete from list where runno = '$runno' ")or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
	$msg = "<b class='blue'>Complete</b><br>ลบข้อมูลเรียบร้อยแล้ว";
	echo $msg;
	include("msg_box.php");
	header("Location: list.php?tripid=$tripid");
	exit;
}

if(isset($_GET['sort'])){
	if($_GET['sort']=="asc"){
			$sort = "desc";
	}else{
			$sort = "asc";
	}
}else{
	$sort = "asc";
}

$getstr .= "sort=".$sort."&";
?>

<SCRIPT language=JavaScript 

src="bimg/swap.js"></SCRIPT>

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
.style2 {
	color: #000000;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}
.style9 {color: #000000}

-->

</style>
<script language="javascript"  src="libary/popcalendar.js"></script>
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

              <td width="">			  </td>
              </tr>

          </table>
            <span class="style4">รายงานแสดงข้อมูลตามหมวดค่าใช้จ่าย</span></td>

        </tr>

<!--        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='list.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>-->
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
                          </tr>
                        </table>
                          <br>
						  <form name="form1" method="post" action="?step=show&id_type_cost=<?=$id_type_cost?>&startday=<?=$startday?>&endday=<?=$endday?>">
                          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td>เลือกหมวดค่าใช้จ่าย</td>
                              <td><span class="style9">
                                <select name="id_type_cost" id="id_type_cost" >
                                  <option value=" "> </option>
                                  <?

		$select1  = mysql_query("select  * from type_cost;");

		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))

		{

		//if ($rs[id_type_cost] == $rselect1[id_type_cost]) // id_type_cost
		if ($id_type_cost == $rselect1[id_type_cost]) // id_type_cost		

		{ 			

			echo "<option value='$rselect1[id_type_cost]' SELECTED>$rselect1[type_cost]</option>";

		}else

			{

			echo "<option value='$rselect1[id_type_cost]' >$rselect1[type_cost]</option>";

			}

		}//end while

?>
                                </select>
                              </span></td>
                            </tr>
                            <tr>
                              <td>เลือกช่วงวันที่</td>
                              <td>
							  <span class="style2"><input type="text" name="startday" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<?=($startday)?$startday:date("d/m/").(date("Y") ); ?>" readonly>
	<script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.startday, \"dd/mm/yyyy\")' value=' เลือกวัน ' class='input'>")	}</script>
                                </span>
							  </td>
                            </tr>
                            <tr>
                              <td>ถึงวันที่</td>
                              <td>
							   <span class="style2"><input type="text" name="endday" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<?=($endday)?$endday:date("d/m/").(date("Y") ); ?>" readonly>
	<script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.endday, \"dd/mm/yyyy\")' value=' เลือกวัน ' class='input'>")	}</script>
                                </span>
							  </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>
                                <label>
                                  <input type="submit" name="Submit" value="แสดงผล">
                                </label>
                            
                              </td>
                            </tr>
                          </table>
					      </form>
                          <br>
                          <table width="90%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#A3B2CC">
                            <tr>
								<?
								$start = swapdate($startday);
								$end = swapdate($endday);
								if($start&&$end){ $cost_day=" and date_list between  '$start' and '$end' "; }								
								If ($step =="show")
								{
								$str = "select * from type_cost where id_type_cost = $id_type_cost $cost_day";
								$result = mysql_query($str);
								$rs = @mysql_fetch_assoc($result);
								}
								?>
                              <td width="30%" align="right"><strong><?=$rs[type_cost]?> ทั้งหมด </strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><span class="style2" id="total_exsum">
                                <?
				//$sqls = "select sum(cash+credit) as cash from list   where (id_type_cost = '$id_type_cost') $cost_day ";
				$sqls ="select sum(cash_total+credit_total) as cash  from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost where  (t1. id_type_cost='$id_type_cost') and date_list between  '$start' and '$end' order by date_list";						
				$res = mysql_query($sqls);
				$rss = mysql_fetch_assoc($res);
				echo number_format($rss[cash],2);
				?>
                              </span></td>
                              <td bgcolor="#A3B2CC"><strong>บาท </strong></td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>ตั้งแต่วันที่ </strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><?=$startday?></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30%" align="right"><strong>ถึงวันที่</strong></td>
                              <td width="25%" align="right" bgcolor="#FFFFFF"><?=$endday?></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                              <td width="30%" bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                          </table>
                          <br>
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="50%" height="25"><strong>หมวดค่าใช้จ่าย  &nbsp;&nbsp;
					          <?
							  
							  $sqls  = "select * from type_cost where id_type_cost = '$id_type_cost'  ";
							  $results = mysql_query($sqls);
							  $rss = mysql_fetch_assoc($results);
							  echo $rss[type_cost];
							  
							  ?>
							  </strong></td>
                            </tr>
                          </table>
                          <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                            <tr bgcolor="#A3B2CC" align="center">
                              <td width="5%" rowspan="2"><strong>ลำดับ</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=date_list&tripid=<?=$tripid?>&id_type_cost=<?=$id_type_cost?>">วันที่</a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong>ชื่อ</strong></td>
                              <td colspan="3" bgcolor="#A3B2CC"><strong>จำนวนเงิน</strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=id_type_project&tripid=<?=$tripid?>&id_type_cost=<?=$id_type_cost?>">โครงการ</a></strong></td>
                              <td rowspan="2" bgcolor="#A3B2CC"><strong><a href="?<?=$getstr?>sortfield=complete&tripid=<?=$tripid?>&id_type_cost=<?=$id_type_cost?>">BILL</a></strong></td>
                              <td bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC" align="center">
                              <td><strong>เงินสด</strong></td>
                              <td><strong>เครดิต</strong></td>
                              <td><strong>รวม</strong></td>
                              <td>&nbsp;</td>
                            </tr>
                            
    <?
	$i=0;
	$no=0;
	$start = swapdate($startday);
	$end = swapdate($endday);
	If ($pri =='100'|| $pri == '50')
	{
		If ($sortfield == "")
		{
		$str = "select *  from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost where  (t1. id_type_cost='$id_type_cost') and date_list between  '$start' and '$end' order by date_list  ";
		}
		else
		{
		$str = " select *  from list t1 left join type_cost t2 on t1.id_type_cost = t2.id_type_cost where  (t1. id_type_cost='$id_type_cost')  and date_list between  '$start' and '$end'  order by t1.$sortfield $sort   ";	
		}
	}// end if privilage
	if($debug=="ON"){	echo $str; }
	$result = mysql_query($str);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$sum_cash+=$rs[cash_total];
		$sum_credit+=$rs[credit_total];		
		$i++;
		$no++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
if($rs[attach] != ""){ $attach = "<a href=\"".$rs[attach]."\"><img src=\"bimg/attach.gif\" border=\"0\"></a>"; } else { $attach = "";}		
?>
                            <tr bgcolor="<?=$bg?>" align="center">
                              <td width="5%"><?=$no?></td>
                              <td bgcolor="<?=$bg?>"><?=daythai($rs[date_list])?></td>
                              <td align="left" bgcolor="<?=$bg?>"><?="&nbsp;".$attach.$rs[detail]?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[cash_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_total],2)?></td>
                              <td align="right" bgcolor="<?=$bg?>"><?=number_format($rs[credit_total],2)?></td>
                              <td bgcolor="<?=$bg?>"><?
							  $res = mysql_query("select * from type_project");
							  while ($rss = mysql_fetch_assoc($res))
							  {
							  If ($rs[id_type_project] == $rss[id_type_project])
							  	{
							  		echo "$rss[code_project]";
							  	}
							  }
							  
							  ?></td>
                              
                              <td bgcolor="<?=$bg?>">
							  			   <?
							  If ($rs[complete] =="y")
							  {
							  	echo "<img src=\"bimg/yy.png\" >";
							  }elseif ($rs[complete] =="n")
							  {
							  	echo  "<img src=\"bimg/alert.gif\" >";
							  }
							  ?></td>
                              <td bgcolor="<?=$bg?>">
							  <? If ($rs[close]=="y")
							  {
							  	echo "ไม่สามารถแก้ไขได้";
								}else
								{
								?> 
							  <a href="cost_add.php?runno=<?=$rs[runno]?>&tripid=<?=$tripid?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runno=<?=$rs[runno]?>&tripid=<?=$tripid?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> 
							  	<?
								}  //end if check close trip
								?>							  </td>
                              <?
	} //while

// List Template
// List Template
					if(mysql_num_rows($result)>0){
					?>
                           <tr bgcolor="#CCCCCC"" align="center">
                              <td colspan="3"><strong>รวม</strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_cash,2)?>
                              </strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_credit,2)?>
                              </strong></td>
                              <td align="right" ><strong>
                              <?=number_format($sum_cash+$sum_credit,2)?>
                              </strong></td>
                              <td colspan="3" ></td>                              
                            </tr>	
						<?
						}else{
						?>
                           <tr bgcolor="#CCCCCC" align="center">
                              <td colspan="9"><strong>ไม่มีข้อมูล</strong></td>                         
                            </tr>				
						<?					
						}
						?>	
                          </table>
						  <p>&nbsp;</p>
					    </td>

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
