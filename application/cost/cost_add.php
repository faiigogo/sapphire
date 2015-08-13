<?php
session_start();

//ini_set("display_errors","1");

include ("config/phpconfig.php");

include ("libary/function.php");

include ("cost/function.php");

$arr_type = array("project" => "โครงการ", "presale" => "Presale", "office" => "ออฟฟิศ", "marketing" => "ตลาด", "RD" => "วิจัยพัฒนา", 'MA' => 'โครงการที่อยู่ระหว่างประกัน');

$date_list = $getyear . '-' . $getmonth . '-' . $getday;




if ($_SERVER[REQUEST_METHOD] == "POST" && $send > "") {

//if Action is edit and file is send remove old file and replace with new one

    if ($action == "edit2") {

        if ($file_name != "") {

            $xsql = mysql_query("select attach from `list` where runno = '$runno'") or die("Query line " . __LINE__ . " error<hr>" . mysql_error());

            $xrs = mysql_fetch_assoc($xsql);

            if (file_exists($xrs[attach])) {
                unlink($xrs[attach]);
            }
        }
    }



//echo "<br>".$file_name;
//echo "<br>".$file_size;
//echo "<br>".$file_type;
//Check file befor attach to server



    if ($file_name != "") {



        $runno = (!isset($runno) || $runno == "") ? random(4) : $runno;

        $fn = split('[.]', $file_name);

        $f_name = $fn[0];

        $f_ext = getFileExtension($file_name);

        $filename = "attach/" . $tripid . "_" . $runno . "." . $f_ext;

        $filesize = $_FILES[file][size];

        $maxfilesize = return_bytes(ini_get('upload_max_filesize'));

        if ($filesize >= $maxfilesize || ( $filename && $filesize == 0 )) {



            $msg = "<b class=warn>Warning</b><br>ขนาดของ file เกินจากที่กำหนดไว้ครับ (" . ini_get('upload_max_filesize') . "b)<div align=right><a href=# ";

            $msg = $msg . "onclick=history.back(); style=\"text-decoration:none\"><font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";

            include("msg_box.php");

            exit;
        } else {



            if (is_uploaded_file($file)) {



                if (!copy($file, $filename)) {

                    $msg = "ไม่สมารถ upload ขึ้น server ได้<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\">";

                    $msg = $msg . "<font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";

                    include('msg_box.php');

                    exit;
                }

                unlink($file);
            } else {



                $msg = "<font class=\"brown\">Can't upload this file</font><br>Folder ที่จะทำการบันทึกข้อมูลอาจจะยังไม่ได้กำหนดคุณลักษณะ<br>";

                $msg = $msg . "กรุณาตรวจสอบ CMOD ของ Folder<br><div align=right><a href=# onclick=history.back(); style=\"text-decoration:none\">";

                $msg = $msg . "<font class=\"blue_dark\">กลับไปแก้ไข</font></a></div>";

                include('msg_box.php');

                exit;
            }
        }
    }



    $date_list = swapdate($getday);

    if ($action == "edit2") {

        if ($file_name == "") {

            $sql = " update list set tor_id = '$tor_id', task_id = '$task_id',cost_id = '$cost_id', date_list =  '$date_list' , no_ap = '$no_ap' , detail = '$detail' , cash='$cash' , credit='$credit' , id_type_credit='$id_type_credit' ,";

            $sql = $sql . " complete = '$complete' , id_type_cost = '$id_type_cost' , id_type_project = '$id_type_project' ,  note ='$note' , date = now() , ";

            $sql = $sql . " cash_vat = '$cash_vat' , cash_total = '$cash_total' , credit_vat= '$credit_vat' , credit_total = '$credit_total'  ,cash_check =  '$cash_check' ,";

            $sql = $sql . " credit_check = '$credit_check'  where runno = '$runno' ";
        } else {

            $sql = " update list set tor_id = '$tor_id', task_id = '$task_id',cost_id = '$cost_id', date_list='$date_list' , no_ap='$no_ap' , detail = '$detail' , cash = '$cash' , credit = '$credit' , id_type_credit = '$id_type_credit',";

            $sql = $sql . " complete = '$complete' , id_type_cost = '$id_type_cost' , id_type_project = '$id_type_project' ,  note ='$note' , date = now() , ";

            $sql = $sql . " cash_vat = '$cash_vat' , cash_total = '$cash_total' , credit_vat= '$credit_vat' , credit_total = '$credit_total', attach = '$filename' ";

            $sql = $sql . " where runno = '$runno' ";
        }



        @mysql_query($sql);

        if (mysql_errno()) {

            $msg = "ไม่สามารถบันทึกข้อมูลได้";
        } else {

            //header("Location: listtrip.php?tripid=$tripid");

            echo "<meta http-equiv='refresh' content='0;url=listtrip.php?tripid=$tripid'>";

            exit;
        }
    } else {



//	$query	= mysql_query(" select date_list from list where date_list='$date_list' and ; ")



        $sql = " INSERT INTO  list  (cost_id,task_id,tor_id,attach,date_list,no_ap,detail,cash,credit,id_type_credit,complete,id_type_cost, ";

        $sql = $sql . " id_type_project,note,cash_vat,cash_total,credit_vat,credit_total,date,tripid,userid,cash_check,credit_check) VALUES  ";

        $sql = $sql . " ('$cost_id','$task_id','$tor_id','$filename', '$date_list','$no_ap','$detail' , '$cash' , '$credit' , '$id_type_credit' , '$complete' , '$id_type_cost' , '$id_type_project' , ";
        if ($pri == '100') {
            $sql_trip = " SELECT userid FROM `trip` WHERE `tripid` = '" . $tripid . "'  ";
            $result_trip = mysql_query($sql_trip);
            $row_trip = mysql_fetch_assoc($result_trip);
            $userid = $row_trip['userid'];
        } else {
            $userid = $_SESSION['userid'];
        }

        $sql = $sql . " '$note' , '$cash_vat','$cash_total','$credit_vat','$credit_total', now() ,'$tripid','$userid','$cash_check','$credit_check') ";

        $result = mysql_query($sql);

        if ($result) {



            $select_x = mysql_query("select  *  from type_project WHERE id_type_project = '$id_type_project' ; ");

            $rselect_x = mysql_fetch_array($select_x);

            $getprojectcode = "$rselect_x[code_project]";



            //include ("_functionSentdata2EPM.inc.php"); // Call Send mail to Executive



            if ($id_type_cost == 7) {

                //header("Location: list.php?tripid=$tripid&sendmail2staff=1");
                echo "<meta http-equiv='refresh' content='0;url=list.php?tripid=$tripid&sendmail2staff=1'>";
            } else {

                //header("Location: list.php?tripid=$tripid");
                echo "<meta http-equiv='refresh' content='0;url=list.php?tripid=$tripid'>";
                die;
            }
            ?>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr align="center">

                    <td>

                        <span class="style2">	

                            ระบบได้ทำการบันทึกข้อมูลของท่านแล้ว และจะทำการติดต่อกลับเพื่อยืนยันโดยเจ้าหน้าที่รับลงทะเบียน ตามหมายเลข &nbsp; <?= $off_tel; ?> และอีเมลล์ 

                            &nbsp; <?= $off_mail ?>  

                        </span>

                    </td>

                </tr>

                <tr align="center" >

                    <td>

                        <input name="" type="button" value = "   ปิด  "onClick=window.close();> &nbsp;&nbsp;

                        <input name="" type="reset"  value = "กลับหน้าหลัก"  onClick="location.href = 'index.php';">

                    </td>

                <tr>

            </table>

            <?
            exit;
        } else {

            echo "ไม่สามารถบันทึกข้อมูลได้ ";
        }
    }
}



$sql = "select * from  register   where  id='$id' ;";

$result = mysql_query($sql);

if ($result) {

    $rs = mysql_fetch_array($result, MYSQL_ASSOC);
} else {

    $msg = "ไม่พบข้อมูลที่ต้องการ";
}
?>

<SCRIPT language=JavaScript 

src="bimg/swap.js"></SCRIPT>

<html>

    <head>

        <title>รายงานค่าใช้จ่ายในการออกปฏิบัติงานการ</title>

        <meta http-equiv="Content-Type" content="text/html; charset=tis-620">

        <link href="cost.css" type="text/css" rel="stylesheet">

        <style type="text/css">

            <!--

            body {  		margin: 0px  0px;	padding: 0px  0px}

            a:link { 		color: #005CA2; 	text-decoration: none}

            a:visited { 	color: #005CA2; 	text-decoration: none}

            a:active { 	color: #0099FF; 	text-decoration: underline}

            a:hover { 	color: #0099FF; 	text-decoration: underline}

            .style2 {		color: #000000}

            .style4 {		color: #FFFFFF;		font-weight: bold;}

            span.requiredfield{ color:red; font-weight:bold; }
            input.requiredinput, select.requiredinput{ outline:1px solid red; }
            -->

        </style>

        <!-- check การระบุค่า  -->
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <script src="./SMLcore/TheirParty/js/jquery-1.10.1.min.js"></script>


        <script language="javascript">

                            function ch1() {
                                var f1 = document.form1;

                                if (f1.day_replace.value != "true") {
                                    alert("วันตามที่ระบุ ซ้ำกับที่เคยบันทึกในระบบ");
                                    return false;
                                } else if (f1.id_type_cost.selectedIndex == 0 && document.getElementById('id_type_cost').value == "") {
                                    $('select#id_type_cost').addClass('requiredinput').focus();
                                    alert("กรุณาระบุชื่อหมวดค่าใช้จ่าย");
                                    return false;
                                }
                                else if ($('select#type_p').val() == '0') {
                                    $('select#type_p').addClass('requiredinput').focus();
                                    alert('กรุณาระบุประเภทโครงการ');
                                    return false;
                                }
                                else if (document.getElementById('id_type_project').value == "" || document.getElementById('id_type_project').value == 0) {
                                    $('select#id_type_project').addClass('requiredinput').focus();
                                    alert("กรุณาระบุโครงการ");
                                    return false;
                                } else if (f1.cash_check.checked == true) {
                                    var v_cash = $('input#cash').val();
                                    var v_cash_vat = $('input#cash_vat').val();
                                    var v_cash_total = $('input#cash_total').val();
                                    if (v_cash == '' || v_cash <= 0) {
                                        $('input#cash').addClass('requiredinput').focus();
                                        alert('กรุณากรอกข้อมูลในส่วนของเงินสด (มูลค่า)');
                                        return false;
                                    }
                                } else if (f1.credit_check.checked == true) {
                                    var v_credit = $('input#credit').val();
                                    var v_credit_vat = $('input#credit_vat').val();
                                    var v_credit_total = $('input#credit_total').val();
                                    if (v_credit == '' || v_credit <= 0) {
                                        $('input#credit').addClass('requiredinput').focus();
                                        alert('กรุณากรอกข้อมูลในส่วนของเครดิต (มูลค่า)');
                                        return false;
                                    }
                                }
                                else if ($('input#cash_check').attr('checked') != true && $('input#credit_check').attr('checked') != true) {
                                    $('input#cash_check').addClass('requiredinput').focus();
                                    $('input#credit_check').addClass('requiredinput').focus();
                                    alert('กรุณาเลือกประเภทจำนวนเงิน (เงินสด หรือ บัตรเครดิต)');
                                    return false;
                                }
                                if (document.getElementById('flile_upload').value != "") {
                                    if (ckType_file() == false) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                }
                                //	f1.submit();
                                return true;
                            }

                            function CreateXmlHttp() {
                                //Creating object of XMLHTTP in IE
                                try {
                                    XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                                }
                                catch (e) {
                                    try {
                                        XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    catch (oc) {
                                        XmlHttp = null;
                                    }
                                }
                                //Creating object of XMLHTTP in Mozilla and Safari 
                                if (!XmlHttp && typeof XMLHttpRequest != "undefined") {
                                    XmlHttp = new XMLHttpRequest();
                                }
                            }

                            function daily_allowance() {
                                if (document.getElementById('id_type_cost').value == "5" || document.getElementById('id_type_cost').value == "31") {
                                    CreateXmlHttp();
                                    var tripid = document.getElementById('tripid').value;
                                    var getday = document.getElementById('getday').value;
                                    var runno = document.getElementById('runno').value;
                                    var params = "tripid=" + tripid + "&runno=" + runno + "&getday=" + getday + "&math=" + Math.random();
                                    XmlHttp.open("get", "ajax.check_allowance.php?" + params, true);
                                    //XmlHttp.responseText;
                                    XmlHttp.onreadystatechange = function() {
                                        if (XmlHttp.readyState == 4) {
                                            if (XmlHttp.status == 200) {
                                                var res = XmlHttp.responseText;
                                                var arr_res = res.split("#");
                                                if (arr_res[0] == "false") {
                                                    alert("ข้อมูลซ้ำกับ" + arr_res[1]);
                                                    document.getElementById('day_replace').value = "false";
                                                } else if (arr_res[0] == "true") {
                                                    document.getElementById('day_replace').value = "true";
                                                }
                                            } else if (XmlHttp.status == 404) {
                                                alert("ไม่สามารถทำการดึงข้อมูลได้");
                                                var xres = "false";
                                            } else {
                                                alert("Error : " + XmlHttp.status);
                                                var xres = "false";
                                            }
                                        }
                                    }
                                    XmlHttp.send(null);
                                } else {
                                    document.getElementById('day_replace').value = "true";
                                }
                            }

                            function checkid() {  //รวบรวมสร้าง id 

                                f1 = document.form1;

                                f1.id.value = f1.id1.value + f1.id2.value + f1.id3.value + f1.id4.value + f1.id5.value;

                            }



                            var isNN = (navigator.appName.indexOf("Netscape") != -1);

                            function autoTab(input, len, e) {

                                var keyCode = (isNN) ? e.which : e.keyCode;

                                var filter = (isNN) ? [0, 8, 9] : [0, 8, 9, 16, 17, 18, 37, 38, 39, 40, 46];

                                if (input.value.length >= len && !containsElement(filter, keyCode)) {

                                    input.value = input.value.slice(0, len);

                                    input.form[(getIndex(input) + 1) % input.form.length].focus();

                                }



                                function containsElement(arr, ele) {

                                    var found = false, index = 0;

                                    while (!found && index < arr.length)
                                        if (arr[index] == ele)
                                            found = true;

                                        else
                                            index++;

                                    return found;

                                }



                                function getIndex(input) {

                                    var index = -1, i = 0, found = false;

                                    while (i < input.form.length && index == - 1)
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



                            function MM_openBrWindow(theURL, winName, features) { //v2.0

                                window.open(theURL, winName, features);

                            }

                            function check_sum1() {
                                var f1 = document.form1;
                                var totalcheck;
                                var a;
                                var b;
                                a = Number(f1.cash.value);
                                b = Number(f1.cash_vat.value);
                                totalcheck = a + b;
                                if (totalcheck != f1.cash_total.value) {
                                    alert('รายการเงินสด : ท่านกำลังกรอกมูลค่าและ vat 7% ไม่เท่ากับยอดรวม กรุณาตรวจสอบ');
                                }
                            }

                            function check_sum2() {
                                var f1 = document.form1;
                                var totalcheck;
                                var a;
                                var b;
                                a = Number(f1.credit.value);
                                b = Number(f1.credit_vat.value);
                                totalcheck = a + b;
                                if (totalcheck != f1.credit_total.value) {
                                    alert('รายการเครดิต : ท่านกำลังกรอกมูลค่าและ vat 7% ไม่เท่ากับยอดรวม กรุณาตรวจสอบ');
                                }
                            }
                            //-->

        </script>


        <script language="javascript">
            var xmlHttp;
            function createXMLHttpRequest() {
                if (window.ActiveXObject) {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                else if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }
            }

            function handleStateChange() {
                if (xmlHttp.readyState == 4) {
                    if (xmlHttp.status == 200) {
                        updateproductList();
                    }
                }
            }
            function updateproductList() {
                clearproductList();
                var refcode = document.getElementById("id_type_project");
                var results = xmlHttp.responseText;
                var option = null;
                p = results.split(",");
                if (p.length != 2) { // กรณีมีรายการเดียวไม่ต้องแสดง
                    option = document.createElement("option");
                    option.setAttribute("value", 0);
                    option.appendChild(document.createTextNode("ไม่ระบุ"));
                    refcode.appendChild(option);
                }
                for (var i = 0; i < p.length; i++) {
                    if (p[i] > "") {
                        x = p[i].split("::");
                        option = document.createElement("option");
                        option.setAttribute("value", x[1]);
                        option.appendChild(document.createTextNode(x[0]));
                        refcode.appendChild(option);
                    }
                }
            }
            function clearproductList() {
                var refcode = document.getElementById("id_type_project");
                while (refcode.childNodes.length > 0) {
                    refcode.removeChild(refcode.childNodes[0]);
                }
            }
            function refreshproductList() {
                var type_p = document.getElementById("type_p").value;
                // alert(ampid);
                if (type_p == "") {
                    clearproductList();
                    return;
                }
                var url = "ajax_project_type.php?p_id=" + type_p;
                createXMLHttpRequest();

                xmlHttp.onreadystatechange = handleStateChange;
                xmlHttp.open("GET", url, true);
                xmlHttp.send(null);
            }

            function ckType_file() {
                flile_upload = document.getElementById("flile_upload");
                flileVar = flile_upload.value;
                arrFile = flileVar.split(".");
                num_len = arrFile.length;
                fileType = arrFile[(num_len - 1)].toUpperCase();
                if (fileType == "PDF") {
                    return true;
                } else {
                    alert("อนุญาตแนบไฟล์เฉพาะนามสกุล .PDF เท่านั้น");
                    return false;
                }
            }
        </script>



        <script language="javascript"  src="libary/popcalendar.js"></script>

    </head>

    <body >

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

                <td valign="top" background="" style="background-repeat: no-repeat; background-position:right bottom ">

                    <!-- main Table  -->

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2C2C9E">

                        <tr>

                            <td height="30" colspan="2"><span class="style4">รายงานค่าใช้จ่ายในการออกปฏิบัติงาน</span></td>

                        </tr>

<!--<tr bgcolor="#CACACA">

    <td width="862" bgcolor="#888888">&nbsp;</td>

    <td width="108" align="center" bgcolor="#888888">

    <input name="Button25"  title="ยกเลิก" type="button"  style="width: 80;" class="xbutton" value="กลับหน้ารายการ" 

    onClick="location.href='list.php?tripid=<?= $tripid ?>';" >

    </td>

</tr>-->

                    </table>

                    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center"><? include("header_cost.php"); // หัวโปรแกรม                      ?></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                            <td align="left" valign="top">

                                <form  name="form1" method="post"  action = "?" enctype="multipart/form-data" onSubmit="return ch1();" ><?
                                    if ($_GET[action] == "edit2") {

                                        $sql = "select * from list where  runno='$runno'  ;";
                                        $result = mysql_query($sql);
                                        if ($result) {
                                            $rs = mysql_fetch_array($result, MYSQL_ASSOC);
                                            //print_r($rs);
                                        }

                                        $sqlx1 = "SELECT * FROM type_project WHERE id_type_project='$rs[id_type_project]'";
                                        $resultx1 = mysql_query($sqlx1);
                                        $rsx1 = mysql_fetch_array($resultx1);
                                    }



                                    if ($_POST[runno] > "") {

                                        $rs = $_POST;

                                        //print_r($rs);
                                    }
                                    ?>

                                    <INPUT TYPE="hidden" NAME="action" ID="action" VALUE="<?= $action ?>">

                                    <INPUT TYPE="hidden" NAME="runno"  ID="runno" VALUE="<?= $rs[runno] ?>">

                                    <INPUT TYPE="hidden" NAME="tripid" ID="tripid" VALUE="<?= $tripid ?>">

                                    <INPUT TYPE="<?= $debug == "ON" ? "text" : "hidden" ?>" NAME="day_replace" ID="day_replace" VALUE="">

                                    <br>

                                    <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">

                                        <tr>

                                            <td bgcolor="#CACACA" onClick="javascript:swap('basicdata', 'bimg/profile_collapsed.gif', 'bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;

                                                <b class="gcaption"><font color="#000000">&nbsp;</font></b><b class="gcaption"><font color="#000000">

                                                    <img src="bimg/profile_expanded.gif" name="ctrlbasicdata" width="9" height="9" border="0" id="ctrlbasicdata" >&nbsp;&nbsp; 

                                                    รายการเบิกค่าใช้จ่าย </font></b>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td><DIV id=swapbasicdata>

                                                    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">

                                                        <tr>

                                                            <td width="60%">&nbsp;</td>

                                                            <td width="15%"><div align="center">วันที่ทำรายการ</div></td>

                                                            <td><?= DBThaiLongDate(date("Y-m-d")); ?> <span id="paid_daily" onClick="auto_daily();"><img src="images/coins.png" width="16" height="16" alt="(เป็นเบี้ยเลี้ยงคลิ้ก)" title="(เป็นเบี้ยเลี้ยงคลิ้ก)" style="cursor:pointer"> </span></td>

                                                        </tr>

                                                    </table>

                                                    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="textp">

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2">Trip</span></td>

                                                            <td height="25" colspan="2" valign="top"><span class="style2">

                                                                    <?
                                                                    $sqltrip = "select  * from trip where tripid = '$tripid' ";
                                                                    $resulttrip = mysql_query($sqltrip);
                                                                    $rstrip = mysql_fetch_array($resulttrip);

                                                                    $display = ($pri == '80' && $rstrip['userid'] != $_SESSION[userid]) ? true : false;

                                                                    echo $rstrip[tripid];

                                                                    echo "&nbsp; - &nbsp;";

                                                                    echo $rstrip[tripname];
                                                                    ?>                                       
                                                                </span>	
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td width="1%" align="center" valign="top">&nbsp;</td>

                                                            <td width="18%" height="25" valign="top"><span class="style2 style2">วันที่</span> <? $d2 = explode("-", $rs[date_list]); ?></td>

                                                            <td width="40%" height="25" valign="top"><span class="style2">
                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        if ($rs[date_list] == "") {
                                                                            echo date("d/m/") . (date("Y") );
                                                                        } else {
                                                                            echo swapdate($rs[date_list]);
                                                                        }
                                                                        echo '<input name="getday" type="hidden"  id="getday" value="' . swapdate($rs[date_list]) . '" size="20">';
                                                                    } else {
                                                                        ?>
                                                                        <input type="text" id="getday" name="getday"  class="input" maxlength="10" style="width:120px;" 

                                                                               value="<?
                                                                               if ($rs[date_list] == "") {
                                                                                   echo date("d/m/") . (date("Y") );
                                                                               } else {
                                                                                   echo swapdate($rs[date_list]);
                                                                               }
                                                                               ?>" readonly>

                                                                        <script language='javascript'>

            if (!document.layers) {

                document.write("<input type=button onclick='popUpCalendar(this, form1.getday, \"dd/mm/yyyy\")' value=' เลือกวัน ' class='input'>")

            }

                                                                        </script>
                                                                    <? } ?>
                                                                </span>	</td>

                                                            <td width="41%" valign="top"><div id="status"></div></td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2 style2">เลขที่ใบเสร็จ</span></td>

                                                            <td height="25" colspan="2" valign="top">

                                                                <?
                                                                If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                    echo $rs[no_ap];
                                                                    echo '<input name="no_ap" type="hidden"  id="no_ap" value="' . $rs[no_ap] . '" size="20">';
                                                                } else {
                                                                    ?>

                                                                    <input name="no_ap" type="text"  class="input_text " id="no_ap" value="<?= $rs[no_ap] ?>" size="20">

                                                                <? } ?>	</td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2 style2">รายการ</span></td>

                                                            <td height="25" colspan="2" valign="top">

                                                                <?
                                                                If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                    echo $rs[detail];
                                                                    echo '<input name="detail" type="hidden"  id="detail" value="' . $rs[detail] . '" size="120" >';
                                                                } else {
                                                                    ?>

                                                                    <input name="detail" type="text" class="input_text " id="detail" value="<?= $rs[detail] ?>" size="120" onBlur="daily_allowance()">

                                                                <? } ?>	</td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2 style2">จำนวนเงิน</span> <span class="requiredfield">***</span></td>

                                                            <td height="25" colspan="2" valign="top"><span class="style2">
                                                                    <input name="cash_check" type="checkbox" id="cash_check" VALUE="1" <? if ($rs[cash_check] == 1) echo "CHECKED"; ?> onClick="check_daily_paid(this);">
                                                                    เงินสด</span>
                                                                <script language="javascript">
            function check_daily_paid(xdaily) {
                if (xdaily.checked == true && (document.getElementById('id_type_cost').value == '5' || document.getElementById('id_type_cost').value == '31')) {
<?
$strSQL = " SELECT cost FROM `type_accrone`  WHERE id_type_cost = '5' AND userid = '" . $_SESSION[userid] . "' ";
$result_cost = mysql_query($strSQL);
$RS_Cost = mysql_fetch_assoc($result_cost);
$user_cost = $RS_Cost[cost];
?>
                    if (document.getElementById('cash').value == "") {
                        document.getElementById('cash').value = '<?= ($user_cost > 0) ? "$user_cost" : "150" ?>';
                    }
                    if (document.getElementById('cash_vat').value == "") {
                        document.getElementById('cash_vat').value = '0';
                    }
                    if (document.getElementById('cash_total').value == "") {
                        document.getElementById('cash_total').value = '<?= ($user_cost > 0) ? "$user_cost" : "150" ?>';
                    }
                }
            }
            function auto_daily() {
                var datex = document.getElementById('getday').value;
                if (document.getElementById('detail').value == "") {
                    document.getElementById('detail').value = 'รายการเบี้ยเลี้ยงประจำวันที่ ' + datex + ' ของ <?= $_SESSION[name] ?> <?= $_SESSION[surname] ?>';
                }
                if (document.getElementById('id_type_cost').value == "") {
                    document.getElementById('id_type_cost').value = '5'
                }
                if (document.getElementById('cash_check').checked == false) {
                    document.getElementById('cash_check').checked = true
                }
                check_daily_paid(document.getElementById('cash_check'));
                daily_allowance();
            }
                                                                </script>
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;มูลค่า</span></td>

                                                            <td height="25" colspan="2" valign="top"><span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[cash];
                                                                        echo '<input name="cash" type="hidden"  id="cash" value="' . $rs[cash] . '" >';
                                                                    } else {
                                                                        ?> 

                                                                        <input name="cash" type="text" class="input_text" id="cash" value="<?= $rs[cash] ?>" size="20" onKeyUp="cash_value_check(this);" onBlur="cash_value_check(this);" > บาท										  

                                                                    <? } ?>

                                                                </span>	
                                                                <script language="javascript">
            function cash_value_check(x) {
                isNumberchar(x);
                var txt_cash = $('input#cash').val();
                var txt_cash_vat = $('input#cash_vat').val();
                var txt_cash_total = $('input#cash_total').val();
                if (txt_cash == '' && txt_cash_total == '') {
                    // document.form1.cash_check.checked=false;
                    $('input#cash_vat').val('');
                } else if (txt_cash != '' || txt_cash_total != '') {
                    $('input#cash_check').attr('checked', 'checked');
                    if (txt_cash_vat == '') {
                        $('input#cash_vat').val('0');
                    }
                }
                txt_cash = parseFloat(txt_cash);
                txt_cash_vat = parseFloat(txt_cash_vat);
                if (isNaN(txt_cash) === true || txt_cash < 0)
                    txt_cash = 0;
                if (isNaN(txt_cash_vat) === true || txt_cash_vat < 0)
                    txt_cash_vat = 0;
                $('input#cash_total').val(parseFloat(txt_cash + txt_cash_vat).toFixed(2));
            }

            function isNumberchar(s) {
                var str = s.value;
                var orgi_text = "1234567890.";
                var str_length = str.length;
                var Char_At = "";
                var isNumber = "";
                for (i = 0; i < str_length; i++) {
                    Char_At = str.charAt(i);
                    var r = orgi_text.indexOf(Char_At);
                    if (r > -1) {
                        isNumber = isNumber + Char_At;
                    }
                }
                s.value = isNumber;
            }
                                                                </script>
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;Vat 7% </span></td>

                                                            <td height="25" colspan="2" valign="top"><span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[cash_vat];
                                                                        echo '<input name="cash_vat" type="hidden"  id="cash_vat" value="' . $rs[cash_vat] . '" >';
                                                                    } else {
                                                                        ?>

                                                                        <input name="cash_vat" type="text" class="input_text" id="cash_vat" value="<?= $rs[cash_vat] ?>" size="20"> บาท 

                                                                    <? } ?>

                                                                </span>	</td>
                                                        </tr>

                                                        <tr>

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;รวม</span></td>

                                                            <td height="25" colspan="2" valign="top">

                                                                <span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[cash_total];
                                                                        echo '<input name="cash_total" type="hidden"  id="cash_total" value="' . $rs[cash_total] . '" >';
                                                                    } else {
                                                                        ?>

                                                                        <input name="cash_total" type="text" class="input_text" id="cash_total" value="<?= $rs[cash_total] ?>" size="20" readonly="readonly"> บาท 

                                                                    <? } ?>
                                                                </span>	</td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td align="center" valign="top">&nbsp;</td>

                                                            <td height="25" valign="top">&nbsp;</td>

                                                            <td height="25" colspan="2"><span class="style2">

                                                                    <input name="credit_check" type="checkbox" id="credit_check" VALUE="1" <? if ($rs[credit_check] == 1) echo "CHECKED"; ?>>

                                                                    &nbsp;:&nbsp;&nbsp;เครดิต 

                                                                    <label>ประเภทบัตรเครดิต     

                                                                        <select name="id_type_credit" id="id_type_credit"  >

                                                                            <option value="">ไม่ระบุ</option>

                                                                            <?
                                                                            $select1 = mysql_query("select  *  from type_credit;");

                                                                            while ($rselect1 = mysql_fetch_array($select1, MYSQL_ASSOC)) {



                                                                                if ($rs[id_type_credit] == $rselect1[id_type_credit]) {

                                                                                    echo "<option value='$rselect1[id_type_credit]' SELECTED>$rselect1[type_credit]</option>";
                                                                                } else {

                                                                                    echo "<option value='$rselect1[id_type_credit]' >$rselect1[type_credit]</option>";
                                                                                }
                                                                            }//end while
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                    <?php
                                                                    if ($pri == '100') {
                                                                        ?>
                                                                        <label>
                                                                            <input type="button" name="btnNewcredit" value=" + " onClick="MM_openBrWindow('addtype_credit.php', '', 'width=800,height=500,scrollbars=yes')">
                                                                        </label>
                                                                    <?php } ?>
                                                                </span>	</td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;มูลค่า</span></td>

                                                            <td colspan="2"><span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[credit];
                                                                        echo '<input name="credit" type="hidden"  id="credit" value="' . $rs[credit] . '" >';
                                                                    } else {
                                                                        ?>

                                                                        <input name="credit" type="text" class="input_text" id="credit" value="<?= $rs[credit] ?>" size="20" onKeyUp="credit_value_check(this);" onBlur="credit_value_check(this);"> บาท

                                                                    <? } ?>

                                                                </span>	
                                                                <script language="javascript">
            function credit_value_check(x) {
                isNumberchar(x);
                var txt_credit = $('input#credit').val();
                var txt_credit_vat = $('input#credit_vat').val();
                var txt_credit_total = $('input#credit_total').val();
                if (txt_credit == '' && txt_credit_total == '') {
                    // document.form1.credit_check.checked=false;
                    $('input#credit_vat').val('');
                } else if (txt_credit != '' || txt_credit_total != '') {
                    $('input#credit_check').attr('checked', 'checked');
                    if (txt_credit_vat == '') {
                        $('input#credit_vat').val('0');
                    }
                }
                txt_credit = parseFloat(txt_credit);
                txt_credit_vat = parseFloat(txt_credit_vat);
                if (isNaN(txt_credit) === true || txt_credit < 0)
                    txt_credit = 0;
                if (isNaN(txt_credit_vat) === true || txt_credit_vat < 0)
                    txt_credit_vat = 0;
                $('input#credit_total').val(parseFloat(txt_credit + txt_credit_vat).toFixed(2));
            }
                                                                </script>	

                                                            </td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;Vat 7% </span></td>

                                                            <td colspan="2"><span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[credit_vat];
                                                                        echo '<input name="credit_vat" type="hidden"  id="credit_vat" value="' . $rs[credit_vat] . '" >';
                                                                    } else {
                                                                        ?>

                                                                        <input name="credit_vat" type="text" class="input_text" id="credit_vat" value="<?= $rs[credit_vat] ?>" size="20"> บาท

                                                                    <? } ?>

                                                                </span>	</td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;รวม</span></td>

                                                            <td colspan="2"><span class="style2">

                                                                    <?
                                                                    If ($rs[cleartrip] == 'y' || $rs[endtrip] == 'y' || $display) {

                                                                        echo $rs[credit_total];
                                                                        echo '<input name="credit_total" type="hidden"  id="credit_total" value="' . $rs[credit_total] . '" >';
                                                                    } else {
                                                                        ?>

                                                                        <input name="credit_total" type="text" class="input_text" id="credit_total" value="<?= $rs[credit_total] ?>" size="20" readonly="readonly"> บาท

                                                                    <? } ?>

                                                                </span>	</td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2 style2"><nobr>ความสมบูรณ์ของเอกสาร</span></td>

                                                            <td colspan="2">



                                                                <input type="radio" name="complete" id="complete1" class="bgbutton" value="y"  <?
                                                                if ($rs[complete] == "y") {
                                                                    echo "checked=\"checked\" ";
                                                                }
                                                                ?>> ครบ

                                                                <input type="radio" name="complete" id="complete2" class="bgbutton" value="n"  <?
                                                                if ($rs[complete] == "n") {
                                                                    echo " checked=\"checked\" ";
                                                                } elseif ($rs[complete] == "") {
                                                                    echo " checked=\"checked\" ";
                                                                }
                                                                ?> >

                                                                ไม่ครบ	

                                                            </td>
                                                        </tr

                                                        ><tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">หมวดค่าใช้จ่าย</span> <span class="requiredfield">***</span></td>

                                                            <td colspan="2" valign="top"><span class="style2">

                                                                    <select name="id_type_cost" id="id_type_cost"  onChange="daily_allowance()">



                                                                        <?
                                                                        If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                            echo '<option value="">ไม่ระบุ</option>';
                                                                        }
                                                                        $select1 = mysql_query("select  * from type_cost;");

                                                                        while ($rselect1 = mysql_fetch_array($select1, MYSQL_ASSOC)) {



                                                                            if ($rs[id_type_cost] == $rselect1[id_type_cost]) {

                                                                                echo "<option value='$rselect1[id_type_cost]' SELECTED>$rselect1[type_cost]</option>";
                                                                            } else {
                                                                                If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                                    echo "<option value='$rselect1[id_type_cost]' >$rselect1[type_cost]</option>";
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <?php
                                                                    if ($pri == '100') {
                                                                        ?>
                                                                        <input type="button" name="btnNewtype" value=" + " onClick="MM_openBrWindow('addtype_cost.php', '', 'scrollbars=Yes', 'resizable=Yes', 'width=800,height=500')">
                                                                    <?php } ?>
                                                                </span>	</td>

                                                        </tr>

                                                        <tr valign="top">
                                                            <td height="25" align="center">&nbsp;</td>
                                                            <td><span class="style2">ประเภทโครงการ</span> <span class="requiredfield">***</span></td>
                                                            <td colspan="2" ><label>
                                                                    <select name="type_p" id="type_p" onChange="refreshproductList();">
                                                                        <?php
                                                                        If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                            echo '<option value="0"> - เลือกประเภทโครงการ - </option>';
                                                                        }
                                                                        ?>
                                                                        <?
//$rs[id_type_project] //$arr_type = array("project"=>"โครงการ","presale"=>"Presale","office"=>"ออฟฟิศ","marketing"=>"ตลาด","RD"=>"วิจัยพัฒนา");
                                                                        foreach ($arr_type as $key => $val) {
                                                                            if ($action == "edit2") {
                                                                                if ($key == "presale") {
                                                                                    $sp = strpos($rsx1[code_project], "PS");
                                                                                    if (!($sp === false)) {
                                                                                        $sel = "selected";
                                                                                    } else {
                                                                                        $sel = "";
                                                                                    }
                                                                                } else if ($key == "offece") {
                                                                                    $sp = strpos($rsx1[code_project], "OF");
                                                                                    if (!($sp === false)) {
                                                                                        $sel = "selected";
                                                                                    } else {
                                                                                        $sel = "";
                                                                                    }
                                                                                } else if ($key == "marketing") {
                                                                                    $sp = strpos($rsx1[code_project], "MAR");
                                                                                    if (!($sp === false)) {
                                                                                        $sel = "selected";
                                                                                    } else {
                                                                                        $sel = "";
                                                                                    }
                                                                                } else if ($key == "RD") {
                                                                                    $sp = strpos($rsx1[code_project], "RD");
                                                                                    if (!($sp === false)) {
                                                                                        $sel = "selected";
                                                                                    } else {
                                                                                        $sel = "";
                                                                                    }
                                                                                } else if ($key == "MA") {
                                                                                    $sp = strpos($rsx1[code_project], "MA");
                                                                                    if (!($sp === false)) {
                                                                                        $sel = "selected";
                                                                                    } else {
                                                                                        $sel = "";
                                                                                    }
                                                                                } else if ($key == "project") {
                                                                                    $sel = "selected";
                                                                                } else {
                                                                                    $sel = "";
                                                                                }
                                                                            } else {
                                                                                if ($type_p == $key) {
                                                                                    $sel = "selected";
                                                                                } else {
                                                                                    $sel = "";
                                                                                }
                                                                            }
                                                                            if ($sel != "") {
                                                                                echo "<option value='$key' $sel>$val</option>";
                                                                            } else {
                                                                                If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                                    echo "<option value='$key' $sel>$val</option>";
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label></td>
                                                        </tr>
                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">โครงการ</span> <span class="requiredfield">***</span></td>

                                                            <td colspan="2" ><span class="style2">
                                                                    <?
                                                                    if ($action == "edit2") {
                                                                        $s1 = strpos($rsx1[code_project], "PS");
                                                                        $s2 = strpos($rsx1[code_project], "OF");
                                                                        $s3 = strpos($rsx1[code_project], "MAR");
                                                                        $s4 = strpos($rsx1[code_project], "RD");
                                                                        $s5 = strpos($rsx1[code_project], "MA");
                                                                        if (!($s1 === false)) {
                                                                            $conW = " WHERE type_project.code_project LIKE 'PS%'";
                                                                        } else if (!($s2 === false)) {
                                                                            $conW = " WHERE type_project.code_project LIKE 'OF%'";
                                                                        } else if (!($s3 === false)) {
                                                                            $conW = " WHERE type_project.code_project LIKE 'MAR%'";
                                                                        } else if (!($s4 === false)) {
                                                                            $conW = " WHERE type_project.code_project LIKE 'RD%'";
                                                                        } else if (!($s5 === false)) {
                                                                            $conW = " WHERE type_project.code_project LIKE 'MA%'";
                                                                        } else {
                                                                            $conW = "WHERE type_project.code_project NOT LIKE 'OF%' AND type_project.code_project NOT LIKE 'MAR%' AND type_project.code_project NOT LIKE 'RD%' AND type_project.code_project NOT LIKE 'PS%'";
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <select name="id_type_project" id="id_type_project" >
                                                                        <? if ($action == "edit2") { ?>

                                                                            <?php
                                                                            If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                                echo '<option value="" class="NON">ไม่ระบุ</option>';
                                                                            }
                                                                            ?>
                                                                            <?
                                                                            $select1 = mysql_query("select  * from type_project  $conW ORDER BY  code_project ASC ;");

                                                                            while ($rselect1 = mysql_fetch_array($select1, MYSQL_ASSOC)) {



                                                                                if ($rs[id_type_project] == $rselect1[id_type_project]) {

                                                                                    echo "<option value='$rselect1[id_type_project]' class='$rselect1[code_project]' SELECTED>$rselect1[code_project] :: " . substr($rselect1[name_project], 0, 80) . "</option>";
                                                                                } else {
                                                                                    If ($rs[cleartrip] != 'y' && $rs[endtrip] != 'y' && $display != true) {
                                                                                        echo "<option value='$rselect1[id_type_project]' class='$rselect1[code_project]' >$rselect1[code_project] :: " . substr($rselect1[name_project], 0, 80) . "</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }// end if($action == "edit2"){
                                                                        ?>
                                                                    </select>
                                                                    <?php
                                                                    if ($pri == '100') {
                                                                        ?>
                                                                        <input type="button" name="btnNewproject" value=" + " onClick="MM_openBrWindow('addtype_project.php', '', 'scrollbars=yes,width=800,height=500')">
                                                                    <?php } ?>
                                                                </span>	</td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">TOR ID</span> <span class="requiredfield">***</span></td>

                                                            <td colspan="2">
                                                                <input type="hidden" name="task_id" value="" />
                                                                <select name="tor_id" id="task_id" >

                                                                </select>
                                                                <span id="task_message"></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">Cost ID</span> <span class="requiredfield">***</span></td>

                                                            <td colspan="2">
                                                                <input type="text" name="cost_id" id="cost_id" value="" readonly="readonly" />
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">หมายเหตุ</span></td>

                                                            <td colspan="2"><input name="note" type="text" class="input_text " id="note" value="<?= $rs[note] ?>" size="50" <?= ( $display == true) ? 'disabled' : ''; ?>></td>
                                                        </tr>

                                                        <tr valign="top">

                                                            <td height="25" align="center">&nbsp;</td>

                                                            <td><span class="style2">แนบไฟล์</span></td>

                                                            <td colspan="2">
                                                                <input type="file" name="file" id="flile_upload" size="50" class="input" style="background-color:#ffffff;" value="<?= $rs[attach] ?>" <?= ( $display == true) ? 'disabled' : ''; ?> >
                                                                <br>
                                                                <span style="color:#FF0000;"> แนบได้ รายการละ 1 ไฟล์ ขนาดไฟล์ใหญ่สุดไม่เกิน  <?= ini_get('upload_max_filesize') ?>b  และควรเป็นไฟล์ชนิด PDF เท่านั้น</span>
                                                                <span id="attach_filed" >
                                                                    <?
                                                                    if (file_exists($rs[attach])) {
                                                                        echo (file_exists($rs[attach])) ? "การเลือกแนบไฟล์จะทับข้อมูลเก่าที่คุณเคยอัพโหลดไว้ " : "";
                                                                        $xsize = filesize($rs[attach]) . "b";
                                                                        echo "<br><b>รายการไฟล์แนบปัจจุบัน</b><br><a href='$rs[attach]' target=\"_blank\"><img src=\"images/16x16/attachment.png\" border=0>$rs[detail] </a> <img src='images/16x16/remove.png' title='ลบไฟล์แนบนี้' alt='ลบไฟล์แนบนี้' onclick='del_file(" . $rs[runno] . ");' style='cursor:pointer'> ";
                                                                    }
                                                                    ?>
                                                                </span>
                                                                <script language="javascript">
            function del_file(xfile) {
                if (confirm('ต้องการลบไฟล์แนบนี้ จริงหรือไม่!') == true) {
                    var url = "ajax_del_attach.php?p_id=" + xfile;
                    createXMLHttpRequest();
                    xmlHttp.open("GET", url, true);
                    //var res = xmlHttp.responseText;
                    xmlHttp.onreadystatechange = handleStateChangeFile;
                    //alert(url);
                    xmlHttp.send(null);
                }
            }

            function handleStateChangeFile() {
                if (xmlHttp.readyState == 4) {
                    if (xmlHttp.status == 200) {
                        var res = xmlHttp.responseText;
                        if (res == "success") {
                            document.getElementById('attach_filed').innerHTML = "";
                        }
                    }
                }
            }
                                                                </script>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <br>

                                                </DIV>

                                            </td>

                                        </tr>

                                    </table>

                                    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">

                                        <tr valign="middle" align="right">

                                            <td height="32">&nbsp;&nbsp;

                                                <input style="width:80px;" id="cost_submit" type="submit" name="send" value="บันทึก" onMouseOver="daily_allowance();"  <?= ( $display == true) ? 'disabled' : ''; ?>>

                                                <input style="width:80px;" type="reset" name="Reset" value="ยกเลิก" onClick="window.history.back();">&nbsp;&nbsp;	</td>

                                        </tr>

                                    </table>

                                </form>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>
        <script type="text/javascript">
            $(function() {
                if ($('input#cash_check').attr('checked') !== true) {
                    // $('input#cash').attr('disabled', 'disabled');
                    // $('input#cash_vat').attr('disabled', 'disabled');
                    // $('input#cash_total').attr('disabled', 'disabled');
                }
                if ($('input#credit_check').attr('checked') !== true) {
                    // $('input#credit').attr('disabled', 'disabled');
                    // $('input#credit_vat').attr('disabled', 'disabled');
                    // $('input#credit_total').attr('disabled', 'disabled');
                }

                $('select#id_type_cost').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('select#type_p').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('select#id_type_project').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#cash').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#cash_vat').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#cash_total').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#credit').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#credit_vat').change(function() {
                    $(this).removeClass('requiredinput');
                });
                $('input#credit_total').change(function() {
                    $(this).removeClass('requiredinput');
                });

                $('input#cash_vat').keyup(function() {
                    cash_value_check(this);
                });
                $('input#cash_vat').blur(function() {
                    cash_value_check(this);
                });
                $('input#credit_vat').keyup(function() {
                    credit_value_check(this);
                });
                $('input#credit_vat').blur(function() {
                    credit_value_check(this);
                });

                $('input#cash_check').change(function() {
                    $(this).removeClass('requiredinput');
                    $('input#credit_check').removeClass('requiredinput');
                    if ($(this).attr('checked') === true) {
                        $('input#cash').removeAttr('disabled');
                        $('input#cash_vat').removeAttr('disabled');
                        $('input#cash_total').removeAttr('disabled');
                    }
                    else {
                        // $('input#cash').attr('disabled', 'disabled');
                        // $('input#cash_vat').attr('disabled', 'disabled');
                        // $('input#cash_total').attr('disabled', 'disabled');
                    }
                });
                $('input#credit_check').change(function() {
                    $(this).removeClass('requiredinput');
                    $('input#cash_check').removeClass('requiredinput');
                    if ($(this).attr('checked') === true) {
                        $('input#credit').removeAttr('disabled');
                        $('input#credit_vat').removeAttr('disabled');
                        $('input#credit_total').removeAttr('disabled');
                    }
                    else {
                        // $('input#credit').attr('disabled', 'disabled');
                        // $('input#credit_vat').attr('disabled', 'disabled');
                        // $('input#credit_total').attr('disabled', 'disabled');
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {

                $("#cost_submit").attr('disabled', 'disabled');

                $("#id_type_project").on("change", function() {
                    $('#task_message').html('กรุณารอสักครู่...');
                    $('#task_id').html('');
                    $('#cost_id').val(0);

                    var pro_code_array0 = $("option:selected", "#id_type_project").text().trim().split(" ");

                    $.ajax({
                        url: "./get_cost_task_ajax.php?pro_code=" + pro_code_array0[0],
                        dataType: 'text',
                        success: function(datatext) {
                            $('#task_message').html('<span style=" color: red;">** ไม่พบรหัสโครงการดังกล่าวในฐานข้อมูล Daily</span>');
                            $("#cost_submit").attr('disabled', 'disabled');
                            var dataArray = datatext.trim().split('|');

                            for (var i = 0; i < dataArray.length; i++) {
                                // dataArray[i] = taskId,costId,taskName
                                var valueArray = dataArray[i].split(',');
                                $('#task_id').append($('<option class="' + valueArray[1] + '"></option>').val(valueArray[0]).html(valueArray[0] + ' :: ' + valueArray[2]));
                                $('#task_message').html(' ');
                                $("#cost_submit").removeAttr('disabled');

                                if (i == 0) {
                                    if (valueArray[2] == 'undefined') {
                                        $("#cost_submit").attr('disabled', 'disabled');
                                    }
                                    $('#cost_id').val(valueArray[1]);
                                }
                            }

                        },
                        error: function() {
                            $('#task_message').html('เกิดข้อผิดพลาด กรุณาติดต่อทีมพัฒนาระบบ');
                        }
                    });
                });

                $("#type_p").on("change", function() {
                    $("#cost_submit").attr('disabled', 'disabled');
                    $('#task_message').html('กรุณาระบุโครงการ');
                    $('#task_id').html('');
                    $('#cost_id').val(0);

                    if ($("option:selected", "#type_p").val() == 'office') {
                        var pro_code_array0 = "OFFICE";

                        $.ajax({
                            url: "./get_cost_task_ajax.php?pro_code=" + pro_code_array0,
                            dataType: 'text',
                            success: function(datatext) {
                                $('#task_message').html('<span style=" color: red;">** ไม่พบรหัสโครงการดังกล่าวในฐานข้อมูล Daily</span>');
                                $("#cost_submit").attr('disabled', 'disabled');
                                var dataArray = datatext.trim().split('|');

                                for (var i = 0; i < dataArray.length; i++) {
                                    // dataArray[i] = taskId,costId,taskName
                                    var valueArray = dataArray[i].split(',');
                                    $('#task_id').append($('<option class="' + valueArray[1] + '"></option>').val(valueArray[0]).html(valueArray[0] + ' :: ' + valueArray[2]));
                                    $('#task_message').html(' ');
                                    $("#cost_submit").removeAttr('disabled');

                                    if (i == 0) {
                                        if (valueArray[2] == 'undefined') {
                                            $("#cost_submit").attr('disabled', 'disabled');
                                        }
                                        $('#cost_id').val(valueArray[1]);
                                    }
                                }

                            },
                            error: function() {
                                $('#task_message').html('เกิดข้อผิดพลาด กรุณาติดต่อทีมพัฒนาระบบ');
                            }
                        });
                    }
                });

                $("#task_id").on("change", function() {
                    $('#cost_id').val($("option:selected", this).attr('class'));
                });

<?php if (isset($rs[tor_id]) && $rs[tor_id] != NULL): ?>
                    // when page start 
                    $('#task_message').html('กรุณารอสักครู่...');
                    $('#task_id').html('');
                    var pro_code_array0 = $("option:selected", "#id_type_project").text().split(" ");
                    $.ajax({
                        url: "./get_cost_task_ajax.php?pro_code=" + pro_code_array0[0],
                        dataType: 'text',
                        success: function(datatext) {

                            $('#task_message').html('<span style=" color: red;">** ไม่พบรหัสโครงการดังกล่าวในฐานข้อมูล Daily</span>');
                            $("#cost_submit").attr('disabled', 'disabled');
                            var dataArray = datatext.trim().split('|');

                            for (var i = 0; i < dataArray.length; i++) {
                                // dataArray[i] = taskId,costId,taskName
                                var valueArray = dataArray[i].split(',');
                                if ('<?php echo $rs[tor_id]; ?>' == valueArray[0]) {
                                    $('#task_id').append($('<option class="' + valueArray[1] + '" selected></option>').val(valueArray[0]).html(valueArray[0] + ' :: ' + valueArray[2]));
                                } else {
                                    $('#task_id').append($('<option class="' + valueArray[1] + '"></option>').val(valueArray[0]).html(valueArray[0] + ' :: ' + valueArray[2]));
                                }

                                $('#task_message').html(' ');
                                $("#cost_submit").removeAttr('disabled');
                            }

                            $('#cost_id').val('<?php echo $rs[cost_id]; ?>');
                        },
                        error: function() {
                            $('#task_message').html('เกิดข้อผิดพลาด กรุณาติดต่อทีมพัฒนาระบบ');
                        }
                    });
<?php endif; ?>
            });
        </script>
    </body>

</html>