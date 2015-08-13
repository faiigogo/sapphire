<?php
session_start();
//ini_set("display_errors","1");
include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");


$sql_user = "SELECT * FROM `cos_user` WHERE `userid`='".$_GET['userid']."' ";
$query_user = mysql_query($sql_user);
$user = mysql_fetch_assoc($query_user);
 $ubid = base64_encode($_SESSION['userid']);
?>

<html>

<head>

<title>รายการค่าใช้จ่ายของลูกทีม</title>

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


</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom ">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                      <td align="center"><? include("header_cost.php"); // หัวโปรแกรม ?></td>
             </tr>
        </table>
      <!-- main Table  -->
      <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E" align="center">
        <tr>
          <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td width="">			  </td>
              </tr>

          </table>
            <span class="style4">รายการค่าใช้จ่ายของลูกทีม</span></td>

        </tr>

        <tr bgcolor="#CACACA">

          <td width="862" bgcolor="#888888">&nbsp;</td>

          <td width="108" align="right" bgcolor="#888888"><a href="general.php"></a><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
            <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" onClick="location.href='list.php?tripid=<?=$tripid?>&sname=<?=$sname?>&ssurname=<?=$ssurname?>';" >
            &nbsp;</font>&nbsp;&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                          <br>
                          <DIV style="margin-left:100px;">
                         <strong>Staff:</strong> <?php echo  $user["name"]."  ".$user["surname"];?>
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <strong>TRIPID:</strong> <a href="listtypecost_downline.php?tripid=<?php echo $_GET['tripid'];?>&ubid=<?=$ubid?>" target="_blank"><?php echo $_GET['tripid']?></a>
                         <table align="center" width="65%" bgcolor="#A3B2CC">
                         <tr bgcolor="#A3B2CC" ><td align="left" colspan="4">
                         <?php
                         	$trip_name = "SELECT * FROM trip WHERE tripid='$tripid' ";
				  			$query = mysql_query($trip_name);
				  			$row = mysql_fetch_assoc($query);
						 	echo "<strong>Trip Name: </strong>".$row['tripname'];
                         ?>
                         </td></tr>
                         <tr bgcolor="#A3B2CC">
                              <td width="40%" align="left"><strong>งบประมาณที่ได้รับอนุมัติ</strong></td>
                              <td width="20%" align="right" bgcolor="#FFFFFF"><strong>
                              <?php
							  	$sqls = "select sum(appbudget) as app from tripvalue  where (tripid = '$tripid') ";
								$res = mysql_query($sqls);
								$rss = mysql_fetch_assoc($res);
								$cast_app = $rss[app];
								echo number_format($cast_app,2);
                              ?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td  bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC">
                              <td align="left"><strong>ค่าใช้จ่ายที่ใช้ไปจริงของ Staff</strong></td>
                              <td align="right" bgcolor="#FFFFFF"><strong>
                              <?php
								$sqls	= " SELECT SUM(cash_total) AS cash_total,SUM(credit_total) AS credit_total  
											FROM list  WHERE tripid = '$tripid'; ";
								$res= mysql_query($sqls);
								$resc= mysql_fetch_assoc($res);
								$cash_total= $resc[cash_total] + $resc[credit_total];
								echo number_format($cash_total,2);
								?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td  bgcolor="#A3B2CC">(
							  <?php
							  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '$tripid' ";
							  $resultd = mysql_query($sqld);
							  $rsd = mysql_fetch_assoc($resultd);
							  if (is_null($rsd[maxdate]))
							  {
							  echo "-";
							  }else
							  {
						       echo daythai($rsd[mindate]);
							   echo "&nbsp; - &nbsp;";
   						       echo daythai($rsd[maxdate]);		  			  
							   }   
							  ?>
                              )
                              </td>
                            </tr>
                            <tr bgcolor="#A3B2CC">
                              <td align="left"><strong>ค่าใช้จ่ายที่ใช้จริงของทีมงาน</strong></td>
                              <td align="right" bgcolor="#FFFFFF"><strong>
                              <?php
							  	$budgetHeader = getBudgetHeader($tripid);
								echo number_format($budgetHeader,2);
                              ?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td  bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            <tr bgcolor="#A3B2CC">
                              <td align="left"><strong>คงเหลือจำนวนเงิน</strong></td>
                              <td align="right" bgcolor="#FFFFFF"><strong>
                              <?php
							  	$sqls = "select sum(appbudget) as app from tripvalue  where (tripid = '$tripid') ";
								$res = mysql_query($sqls);
								$rss = mysql_fetch_assoc($res);
								echo number_format($cast_app-($cash_total+$budgetHeader),2);
                              ?>
                              </strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong></td>
                              <td  bgcolor="#A3B2CC">&nbsp;</td>
                            </tr>
                            </table>
                            <p/>&nbsp;
                            <p/>&nbsp;
                           	<strong>ทีมงานประกอบด้วย</strong>
                            <table align="center" width="65%" bgcolor="#A3B2CC">
                            <?php
							$sql_downline = "SELECT trip.tripid, 
													trip.tripname, 
													trip.header_trip, 
													cos_user.userid,
													cos_user.name, 
													cos_user.surname
												FROM trip INNER JOIN cos_user ON trip.userid = cos_user.userid
												WHERE trip.header_trip='".$tripid."'
												AND trip.header_trip IS NOT NULL 
												AND trip.header_trip!=''
												ORDER BY cos_user.name ASC
												";
							$q_downline = mysql_query($sql_downline);
							$intUser = 0;
							$sum_cash = 0;
						 	while($downline = mysql_fetch_assoc($q_downline)){
								$intUser++;
                            ?>
                         	<tr bgcolor="#A3B2CC">
                              <td width="20%" align="left">
							  <?=$intUser?>. <?php echo $downline['name']."  ".$downline['surname']?>
                              </td>
                              <td align="left" width="20%">
                              TRIPID: <a href="listtypecost_downline.php?tripid=<?php echo $downline['tripid'];?>&id_type_cost=31&ubid=<?=$ubid?>" target="_blank"><?php echo $downline['tripid'];?></a>
                              </td>
                              <td width="20%" align="left" bgcolor="#A3B2CC">ค่าใช้จ่ายที่ใช้จริง</td>
                              <td align="right" bgcolor="#FFFFFF"><?php
								$sql_dl	= " SELECT SUM(cash_total) AS cash_total,SUM(credit_total) AS credit_total  
											FROM list  WHERE tripid = '".$downline['tripid']."'; ";
								$res_dl= mysql_query($sql_dl);
								$resc_dl= mysql_fetch_assoc($res_dl);
								$cash_total_dl = $resc_dl[cash_total] + $resc_dl[credit_total];
								$sum_cash += $cash_total_dl;
								echo number_format($cash_total_dl,2);
								?></td>
                              <td  bgcolor="#A3B2CC">บาท&nbsp;&nbsp;</td>
                              <td>(
							  <?php
							  $sqld = "select max(date_list) as maxdate,min(date_list) as mindate from list where tripid = '".$downline['tripid']."' ";
							  $resultd = mysql_query($sqld);
							  $rsd = mysql_fetch_assoc($resultd);
							  if (is_null($rsd[maxdate]))
							  {
							  echo "-";
							  }else
							  {
						       echo daythai($rsd[mindate]);
							   echo "&nbsp; - &nbsp;";
   						       echo daythai($rsd[maxdate]);		  			  
							   }   
							  ?>
                              )</td>
                            </tr>
                            <?php } ?>
                            <tr bgcolor="#A3B2CC">
                              <td></td>
                              <td></td>
                              <td align="left"><strong>จำนวนเงินรวม</strong></td>
                              <td bgcolor="#FFFFFF" align="right"><strong><?php echo number_format($sum_cash,2);?></strong></td>
                              <td bgcolor="#A3B2CC"><strong>บาท&nbsp;</strong>&nbsp;</td>
                              <td></td>
                            </tr>
                            </table>
                         </DIV>
						 <p>&nbsp;  </p>
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

