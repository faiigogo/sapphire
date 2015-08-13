<?php
session_start();

//ini_set("display_errors","1");

include ("config/phpconfig.php");

include ("libary/function.php");

include ("cost/function.php");

if ($_GET['projectcode']) {
    $_POST['projectcode'] = $_GET['projectcode'];
}


if (!($_POST['datepicker_start'] and $_POST['datepicker_end'])) {
    $datelist = mysql_fetch_assoc(mysql_query("select min(t1.date_list) as mindate,max(t1.date_list) as maxdate from list t1 inner join type_project t2 on t1.id_type_project=t2.id_type_project where t2.code_project='" . $_POST['projectcode'] . "' "));
    //print_r($datelist);
    $_POST['datepicker_start'] = dslash($datelist['mindate']);
    $_POST['datepicker_end'] = dslash($datelist['maxdate']);
}

if ($_GET['datepicker_start']) {
    $_POST['datepicker_start'] = $_GET['datepicker_start'];
}
if ($_GET['datepicker_end']) {
    $_POST['datepicker_end'] = $_GET['datepicker_end'];
}

$cond = $cond2 = "1";
if ($_POST['datepicker_start'] and $_POST['datepicker_end']) {

    $cond = "t1.date_list between '" . dep($_POST['datepicker_start']) . "' and '" . dep($_POST['datepicker_end']) . "'";
    $cond2 = "temp_" . $_POST['projectcode'] . ".date_list between '" . dep($_POST['datepicker_start']) . "' and '" . dep($_POST['datepicker_end']) . "'";
} else {
    if ($_POST['datepicker_start']) {
        $cond = "t1.date_list >= '" . dep($_POST['datepicker_start']) . "'";
        $cond2 = "temp_" . $_POST['projectcode'] . ".date_list >= '" . dep($_POST['datepicker_start']) . "'";
    }
    if ($_POST['datepicker_end']) {
        $cond = "t1.date_list <= '" . dep($_POST['datepicker_end']) . "'";
        $cond2 = "temp_" . $_POST['projectcode'] . ".date_list <= '" . dep($_POST['datepicker_end']) . "'";
    }
}

$drop = mysql_query("DROP TABLE IF EXISTS temp_" . $_POST['projectcode']);

$sql = "CREATE TABLE temp_" . $_POST['projectcode'] . " ENGINE='memory' 
    SELECT
    t4.ProjectCode,
    t4.CostId,
    t4.CostName,
    t3.date_list,
    t3.cash_total,
    t3.credit_total,
    t3.total
    FROM 
    dailyreport101.Daily_Cost_Data t4
    LEFT JOIN
    (SELECT 
    t2.code_project, 
    t1.date_list,
    t1.cost_id, 
    sum(t1.cash_total) as cash_total, 
    sum(t1.credit_total) as credit_total,
    sum((t1.cash_total+t1.credit_total)) as total

    FROM " . $db_name . ".list t1 INNER JOIN " . $db_name . ".type_project t2 ON t1.id_type_project = t2.id_type_project
    WHERE t2.code_project='" . $_POST['projectcode'] . "' 

    GROUP BY t1.cost_id,t1.date_list) t3 
    ON t4.ProjectCode=t3.code_project and t4.CostId=t3.cost_id
    WHERE t4.ProjectCode='" . $_POST['projectcode'] . "' 
    GROUP BY t4.CostId,t3.date_list
    ORDER BY t4.CostId ASC";
// echo "<pre>";
// echo $sql;

$result = mysql_query($sql);
?>
<html>
    <head>
        <script language="javascript"  src="libary/popcalendar.js"></script>

        <title>รายงานสรุปค่าใช้จ่ายจำแนกรายโครงการ</title>

        <meta http-equiv="Content-Type" content="text/html; charset=tis-620">

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
                                                                                                        <a href="costByProject.php"><img src="images/home2.png" title="costByProject" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src = 'images/home.png'" onMouseOut="this.src = 'images/home2.png'"></a>

                                                                                                        <a href="logout.php"><img src="images/Stop2.png" title="logout" width="48" height="48" border="0" style="cursor:pointer" onMouseOver="this.src = 'images/Stop.png'" onMouseOut="this.src = 'images/Stop2.png'" onClick="return confirm('ต้องการออกจากระบบใช่หรือไม่')"></a></td>
                                                                                                    <td width="15%" align="right" bgcolor="#B2B2B2"><img src="images/<?php echo ($_SESSION['application'] == "sapphire") ? 'logo_sapphire.png' : 'logo_gnis.png'; ?>" height="<?php echo $_SESSION["logo_size"]; ?>">
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
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="text" id="datepicker_start" name="datepicker_start" maxlength="10" style="width:120px;" onClick="popUpCalendar(this, form1.datepicker_start, 'dd/mm/yyyy')" value="<?= $_POST['datepicker_start'] ?>" /></td>            
                                                                                        <td width="10%" align="right" bgcolor="#A3B2CC">ถึง</td>
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="text" id="datepicker_end" name="datepicker_end" maxlength="10" style="width:120px;" onClick="popUpCalendar(this, form1.datepicker_end, 'dd/mm/yyyy')" value="<?= $_POST['datepicker_end'] ?>" /></td>
                                                                                        <td width="10%" align="left" bgcolor="#A3B2CC"><input type="submit" value="ตกลง"></td>
                                                                                <input type="hidden" name="projectcode" value="<?= $_POST['projectcode'] ?>"/>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </form>

                                                                        <?
                                                                        $sql = "
    SELECT
	sum(t3.total)as total   
	FROM 

    (SELECT 
    t2.code_project, 

    t1.date_list,
    t1.cost_id, 
    sum(t1.cash_total) as cash_total, 
    sum(t1.credit_total) as credit_total,
    sum((t1.cash_total+t1.credit_total)) as total

    FROM " . $db_name . ".list t1 INNER JOIN " . $db_name . ".type_project t2 ON t1.id_type_project = t2.id_type_project
    WHERE t2.code_project='" . $_POST['projectcode'] . "' 

    GROUP BY t1.cost_id,t1.date_list) t3 

	WHERE t3.cost_id in(select CostID from dailyreport101.Daily_Cost_Data where ProjectCode='" . $_POST['projectcode'] . "')

";
//echo $sql."<br>";
                                                                        $result1 = mysql_query($sql);
                                                                        $arr1 = mysql_fetch_assoc($result1);
                                                                        $sql = "
    SELECT
	sum(t3.total)as total   
	FROM 

    (SELECT 
    t2.code_project, 

    t1.date_list,
    t1.cost_id, 
    sum(t1.cash_total) as cash_total, 
    sum(t1.credit_total) as credit_total,
    sum((t1.cash_total+t1.credit_total)) as total

    FROM " . $db_name . ".list t1 INNER JOIN " . $db_name . ".type_project t2 ON t1.id_type_project = t2.id_type_project
    WHERE t2.code_project='" . $_POST['projectcode'] . "' 

    GROUP BY t1.cost_id,t1.date_list) t3 

	WHERE t3.cost_id not in(select CostID from dailyreport101.Daily_Cost_Data where ProjectCode='" . $_POST['projectcode'] . "') or t3.cost_id is null

";
//echo $sql."<br>";
                                                                        $result2 = mysql_query($sql);
                                                                        $arr2 = mysql_fetch_assoc($result2);

                                                                        $pjname = mysql_fetch_assoc(mysql_query("select name_project from type_project where code_project='" . $_POST['projectcode'] . "'"));
                                                                        ?>
                                                                        <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#A3B2CC">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="*" align="left" rowspan="4" bgcolor="#EEEEEE"><strong>[<?= $_POST['projectcode'] ?>] <?= $pjname['name_project'] ?></strong></td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%" align="right"><strong>ค่าใช้จ่ายที่มีหมวดต้นทุนถูกต้อง</strong></td>
                                                                                    <td width="10%" align="right" bgcolor="#A3B2CC"><?= nf($arr1['total']) ?></td>
                                                                                    <td width="10%" align="center" bgcolor="#A3B2CC"><strong>บาท</strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right"><strong>ค่าใช้จ่ายที่หมวดต้นทุนไม่ถูกต้อง</strong></td>
                                                                                    <td align="right" bgcolor="#A3B2CC"><a href="costByProjectNotCostID.php?projectcode=<?= $_POST['projectcode'] ?>"><?= nf($arr2['total']) ?></a></td>
                                                                                    <td align="center" bgcolor="#A3B2CC"><strong>บาท</strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right"><strong>รวม</strong></td>
                                                                                    <td align="right" bgcolor="#A3B2CC"><?= nf($arr1['total'] + $arr2['total']) ?></td>
                                                                                    <td align="center" bgcolor="#A3B2CC"><strong>บาท</strong></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <br>
                                                                        <?php
                                                                        $totala = 0;

                                                                        $totalbydatea = 0;



                                                                        $sql = "SELECT 
		t1.CostID,
        t1.CostName ,
        sum(t1.total) as total,
		(select sum(total) from temp_" . $_POST['projectcode'] . " where (CostID like concat(t1.CostID,'.','%') or CostID like t1.CostID) ) as allcost,
		sum(if( $cond ,t1.total,0)) as totalbydate,
		(select sum(total) from temp_" . $_POST['projectcode'] . " where (CostID like concat(t1.CostID,'.','%') or CostID like t1.CostID) and $cond2 ) as allcostbydate       
FROM
temp_" . $_POST['projectcode'] . " t1
GROUP BY t1.CostID
";
//                                                                      echo "<pre>";
//                                                                        echo $sql;
                                                                        $result = mysql_query($sql) or die(mysql_error());
                                                                        ?>
                                                                        <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
                                                                            <tbody><tr>
                                                                                    <td colspan="0" width="5%"  align="center" bgcolor="#A3B2CC" rowspan="2"><strong>หมวดต้นทุน</strong></td>
                                                                                    <td colspan="0" width="*" align="center" bgcolor="#A3B2CC" rowspan="2"><strong>รายการ</strong></td>

                                                                                    <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าใช้จ่ายทั้งหมด</strong></td>
                                                                                    <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าใช้จ่ายตั้งแต่<br/>วันที่ <?= $_POST['datepicker_start'] ?> ถึง <?= $_POST['datepicker_end'] ?></strong></td>
                                                                                </tr>
                                                                                <tr bgcolor="#EFEFEF">
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ใช้ในรายการ</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>

                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ใช้ในรายการ</strong></td>
                                                                                    <td width="5%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>

                                                                                </tr>
                                                                                <?php
                                                                                // @modify 2014-03-06 เรียงลำดับของเลข Cost ID สำหรับแสดงผล
                                                                                $result_set_sort = array();
                                                                                while ($arr = mysql_fetch_assoc($result)) {
                                                                                    $result_set_sort[$arr['CostID']] = $arr;
                                                                                }

                                                                                $result_set_sort_temp = array();
                                                                                $str_number = array();
                                                                                $str_number_key = array();

                                                                                foreach ($result_set_sort AS $key => $value) {
                                                                                    $number_array = explode('.', $key);
                                                                                    foreach ($number_array AS $index => $sub_number) {
                                                                                        if (strlen($sub_number) == 1) {
                                                                                            $number_array[$index] = '0' . $sub_number;
                                                                                        }
                                                                                    }
                                                                                    $str_number[] = implode('.', $number_array);
                                                                                    $str_number_key[implode('.', $number_array)] = $key;
                                                                                }

                                                                                sort($str_number, SORT_STRING);

                                                                                foreach ($str_number AS $a_number_sort) {
                                                                                    $result_set_sort_temp[] = $result_set_sort[$str_number_key[$a_number_sort]];
                                                                                }

                                                                                $result_set_sort = $result_set_sort_temp;
                                                                                unset($result_set_sort_temp);


                                                                                foreach ($result_set_sort AS $arr) {
                                                                                    ?>
                                                                                    <tr bgcolor="#EFEFEF">
                                                                                        <td align="center" bgcolor="#FFFFFF"><?= $arr['CostID'] ?></td>
                                                                                        <td align="left" bgcolor="#FFFFFF"><?= $arr['CostName'] ?></td>

                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['total']) ?></td>
                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['allcost']) ?></td>

                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['totalbydate']) ?></td>
                                                                                        <td align="right" bgcolor="#FFFFFF"><?= nf($arr['allcostbydate']) ?></td>
                                                                                        <?
                                                                                        $totala+=$arr['total'];

                                                                                        $totalbydatea+=$arr['totalbydate'];
                                                                                        ?>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <tr bgcolor="#EFEFEF">
                                                                                    <td align="center" bgcolor="#FFFFFF" colspan="2"><strong>รวม</strong></td>


                                                                                    <td align="right" bgcolor="#FFFFFF" colspan="2"><strong><?= nf($totala) ?></strong></td>


                                                                                    <td align="right" bgcolor="#FFFFFF" colspan="2"><strong><?= nf($totalbydatea) ?></strong></td>



                                                                                </tr>
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
<?
//เคลียร์ ตาราง temp
$drop = mysql_query("DROP TABLE IF EXISTS temp_" . $_POST['projectcode']);
CloseDB();
?>
