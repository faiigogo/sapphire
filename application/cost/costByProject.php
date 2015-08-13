<?php
session_start();

//ini_set("display_errors","1");

include ("config/phpconfig.php");

include ("libary/function.php");

include ("cost/function.php");


if(!($_POST['datepicker_start'] and $_POST['datepicker_end'])){
    $datelist = mysql_fetch_assoc(mysql_query("select min(date_list) as mindate,max(date_list) as maxdate from list"));
    //print_r($datelist);
    $_POST['datepicker_start'] = dslash($datelist['mindate']);
    $_POST['datepicker_end'] = dslash($datelist['maxdate']);
}



$cond = "0";
if ($_POST['datepicker_start'] and $_POST['datepicker_end']) {

    $cond = "sum(IF(t1.date_list between '" . dep($_POST['datepicker_start']) . "' and '" . dep($_POST['datepicker_end']) . "',(t1.cash_total+t1.credit_total),0))";
} else {
    if ($_POST['datepicker_start']) {
        $cond = "sum(IF(t1.date_list >= '" . dep($_POST['datepicker_start']) . "',(t1.cash_total+t1.credit_total),0))";
    }
    if ($_POST['datepicker_end']) {
        $cond = "sum(IF(t1.date_list <= '" . dep($_POST['datepicker_end']) . "',(t1.cash_total+t1.credit_total),0))";
    }
}
?>
<html>
    <head>
        <script language="javascript"  src="libary/popcalendar.js"></script>

        <title>รายงานสรุปค่าใช้จ่ายจำแนกรายโครงการ <?php echo $_SESSION['application']; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=TIS-620">

        <link href="cost.css" type="text/css" rel="stylesheet">

        <script>
        </script>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                    <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom "> 
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">
                            <tbody><tr>
                                    <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                            <tbody><tr>

                                                    <td width="">			  </td>
                                                </tr>

                                            </tbody></table>
                                        <span class="style4">รายงานสรุปค่าใช้จ่ายจำแนกรายโครงการ</span></td>
                                </tr>

                            </tbody></table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody><tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody><tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody><tr>
                                                                    <td align="left" valign="top">
                                                                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                            <tbody><tr>
                                                                                    <td align="center">
                                                                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                            <tbody><tr>
                                                                                                    <td width="60%" height="40" align="left" bgcolor="#B2B2B2"><img src="images/field_title.png" width="369" height="66"></td>
                                                                                                    <td width="25%" align="right" bgcolor="#B2B2B2">
                                                                                                        <a href="addtrip.php"><img src="images/home2.png" title="xx" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src = 'images/home.png'" onMouseOut="this.src = 'images/home2.png'"></a>

                                                                                                        <a href="logout.php"><img src="images/Stop2.png" title="xx" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src = 'images/Stop.png'" onMouseOut="this.src = 'images/Stop2.png'" onClick="return confirm('ต้องการออกจากระบบใช่หรือไม่')"></a></td>
                                                                                                    <td width="15%" align="right" bgcolor="#B2B2B2"><img src="images/<?php echo ($_SESSION['application']=="sapphire")?'logo_sapphire.png':'logo_gnis.png'; ?>" height="<?php echo $_SESSION["logo_size"]; ?>">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody></table>

                                                                                    </td>
                                                                                </tr>
                                                                            </tbody></table>
                                                                        <br>
                                                                        <form  name="form1" method="post"  action = "?" enctype="multipart/form-data">
                                                                            <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#A3B2CC">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td width="*" align="right"><strong>กำหนดช่วงวันที่</strong></td>
                                                                                        <td width="10%" align="right" bgcolor="#A3B2CC">ตั้งแต่</td>
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="text" id="datepicker_start" name="datepicker_start" maxlength="10" style="width:120px;" onClick="popUpCalendar(this, form1.datepicker_start, 'dd/mm/yyyy')" value="<?=$_POST['datepicker_start']?>" /></td>            
                                                                                        <td width="10%" align="right" bgcolor="#A3B2CC">ถึง</td>
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="text" id="datepicker_end" name="datepicker_end" maxlength="10" style="width:120px;" onClick="popUpCalendar(this, form1.datepicker_end, 'dd/mm/yyyy')" value="<?=$_POST['datepicker_end']?>" /></td>
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="submit" value="ตกลง"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                        </form>
                                                                        <br>
                                                                        <?php
                                                                        $sql = "SELECT t2.code_project, 
	t2.presale_code, 
	t2.name_project,
	t2.`value`, 
	#t1.date_list, 
	#t1.cost_id, 
	#t1.task_id, 
	#sum(t1.cash_total) as cash_total, 
	#sum(t1.credit_total) as credit_total,
	sum((t1.cash_total+t1.credit_total)) as total,
	$cond as tt

FROM list t1 INNER JOIN type_project t2 ON t1.id_type_project = t2.id_type_project

#WHERE t2.start_project >= '2012-01-01'
#and t1.date_list <= '2013-09-04'
GROUP BY t2.code_project

ORDER BY t2.end_project DESC";
//echo $sql;
                                                                        $result = mysql_query($sql);
                                                                        ?>
                                                                        <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
                                                                            <tbody><tr>
                                                                                    <td colspan="0" width="5%"  align="center" bgcolor="#A3B2CC" rowspan="2"><strong>รหัสโครงการ</strong></td>
                                                                                    <td colspan="0" width="*" align="center" bgcolor="#A3B2CC" rowspan="2"><strong>ชื่อโครงการ</strong></td>
                                                                                    <td colspan="0" width="10%"  align="center" bgcolor="#A3B2CC" rowspan="2"><strong>มูลค่า</strong></td>
                                                                                    <!--td colspan="0" width="8%" align="center" bgcolor="#A3B2CC" rowspan="2"><strong>ต้นทุน</strong></td -->
                                                                                    <td colspan="0" width="10%" align="center" bgcolor="#A3B2CC" rowspan="2"><strong>ค่าใช้จ่ายทั้งหมด</strong></td>
                                                                                    <td colspan="0" width="10%" align="center" bgcolor="#A3B2CC" rowspan="2"><strong>ค่าใช้จ่ายตั้งแต่<br/>วันที่ <?=$_POST['datepicker_start']?> ถึง <?=$_POST['datepicker_end']?></strong></td>
                                                                                </tr>
                                                                                <tr bgcolor="#EFEFEF">
                                                                                    <!--td width="5%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คงเหลือ</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ร้อยละ</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>คงเหลือ</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ร้อยละ</strong></td-->
                                                                                </tr>
                                                                                <?php
                                                                                while ($arr = mysql_fetch_assoc($result)) {
                                                                                    ?>
                                                                                    <tr bgcolor="#EFEFEF">
                                                                                        <td align="center" bgcolor="#FFFFFF"><?= $arr['code_project'] ?></td>
                                                                                        <td align="left" bgcolor="#FFFFFF"><a href='costByProjectCostID.php?projectcode=<?= $arr['code_project'] ?>&datepicker_start=<?=$_POST['datepicker_start']?>&datepicker_end=<?=$_POST['datepicker_end']?>'><?= $arr['name_project'] ?></a></td>
                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['value']) ?></td>
                                                                                        <!--td align="right" bgcolor="#FFFFFF"></td-->
                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['total']) ?></td>
                                                                                        <!--td align="right" bgcolor="#FFFFFF"></td>
                                                                                        <td align="right" bgcolor="#FFFFFF"></td-->
                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['tt']) ?></td>
                                                                                        <!--td align="right" bgcolor="#FFFFFF"></td>
                                                                                        <td align="right" bgcolor="#FFFFFF"></td-->

                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </tbody></table>
                                                                    </td>
                                                                </tr>

                                                            </tbody></table></td>
                                                </tr>

                                            </tbody></table></td>
                                </tr>
                            </tbody></table>    </td>
                </tr>
            </tbody></table>




    </body></html>
<?php CloseDB(); ?>
