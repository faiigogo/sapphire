<?php
session_start();
//include ("checklogin.php");
include ("config/phpconfig.php");
include ("libary/function.php");
include ("cost/function.php");

$arr_type = array("PRO"=>"�ç���","PS"=>"Presale","OF"=>"�Ϳ���","MAR"=>"��Ҵ","RD"=>"�Ԩ�¾Ѳ��","MA"=>"����㹻�Сѹ");




		$sql_province_code = "SELECT ccDigi, ccName FROM province  ";
		$result_p_code = mysql_db_query($db_name,$sql_province_code);
		while($rs_pcode = mysql_fetch_assoc($result_p_code)){
			if($rs_pcode[ccName] != "��ا෾��ҹ��"){ $txt_name = "�ѧ��Ѵ".$rs_pcode[ccName];}else{ $txt_name = $rs_pcode[ccName];}
			$arr_province[$rs_pcode[ccDigi]] = $txt_name;
		}


if($_SESSION[pri] != 100){
		echo "
		<HTML>
		<HEAD>
		<TITLE>app</TITLE>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-874\">
		<head>
				<SCRIPT language=JavaScript>
					 if (confirm('�Է�Ԣͧ��ҹ�������ö�������������¡�� ��ҵ�ͧ��ûԴ˹�ҵ�ҧ��顴 OK ��ҵ�ͧ�����͹��Ѻ�� CANCEL')) {window.close();} else {window.history.go(-1);}
				</script>
		</head>
		</html>
		";
		die;
}

$arr_projecttype = array("1"=>"�ç���ʹѺʹع��â��","2" =>"�ç��������ҧ���Թ�ҹ" , "3" => "�ç���ʹѺʹع��ú����çҹ", "4"=>"�ç����Ԩ����оѲ��","5"=>"�ç�������㹻�Сѹ");

if ($_SERVER[REQUEST_METHOD] == "POST"){
$start_project = swapdate($start_project);
$end_project = swapdate($end_project);
if ($_POST[action]=="edit2"){
				$sql = "UPDATE type_project SET  code_project='".trim($code_project)."' , name_project = '$name_project' , no_project = '$no_project', value = '$value' ,start_project = '$start_project', end_project = '$end_project' , projecttype = '$projecttype',province = '$province',province_code='$province_code'   WHERE id_type_project ='$id_type_project' ;";			
				mysql_db_query($db_name, $sql);
				#Begin Update �ç��ú���ѷ GNIS
				$sql_get = "SELECT id_type_project FROM type_project WHERE id_type_project ='$id_type_project' ";
				$query_get = mysql_db_query($db_name_gnis, $sql_get);
				$num_row = mysql_num_rows($query_get);
				if($num_row==0){
					$sql_insert_typeproject = "INSERT  INTO type_project SET id_type_project ='$id_type_project' ";
					mysql_db_query($db_name_gnis, $sql_insert_typeproject);
				}else{
					$sql = "UPDATE type_project SET  code_project='".trim($code_project)."' , name_project = '$name_project' , no_project = '$no_project', value = '$value' ,start_project = '$start_project', end_project = '$end_project' , projecttype = '$projecttype',province = '$province',province_code='$province_code'   WHERE id_type_project ='$id_type_project' ;";			
					mysql_db_query($db_name_gnis, $sql);
				}
				mysql_db_query($db_name_gnis, $sql);//$sql update �������͹����ѷ Sapphire
				#End Update �ç��ú���ѷ GNIS
				
				if (mysql_errno()){
					$msg = "Cannot update parameter information.";
				}else{
					// -------------- update code ��蹷������Ǣ�ͧ ----------------------------- // 
				$sql1 = "UPDATE $db_epm.epm_activity2 SET $db_epm.epm_activity2.refcode='".trim($code_project)."'  WHERE $db_epm.epm_activity2.refcode='".trim($old_code_project)."' ";
				mysql_db_query($db_epm,$sql1);
				$sql2 = "UPDATE $db_epm.epm_detail SET $db_epm.epm_detail.refcode='".trim($code_project)."'  WHERE $db_epm.epm_detail.refcode='".trim($old_code_project)."' ";
				mysql_db_query($db_epm,$sql2);
				$sql3 = "UPDATE $db_epm.epm_dailyreport SET $db_epm.epm_dailyreport.refcode='".trim($code_project)."' WHERE $db_epm.epm_dailyreport.refcode='".trim($old_code_project)."' ";
				mysql_db_query($db_epm,$sql3);
				
				//echo $sql1."<hr>".$sql2."<hr>".$sql3;die;
				
		
				// -------------- �óշ������¹�� Project ----------------------------- // 
						if(isset($presale2project)){
							#Begin Database: Sapphire ����������ҧ�ԧ㹪�ͧ detail 㹵��ҧ  list �������������㹪�ͧ presale_code 㹵��ҧ type_project 
							$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where  t1. id_type_project='$id_type_project'   ";
							$query_str = mysql_db_query($db_epm, $str);
							while($rsx = mysql_fetch_assoc($query_str)){
								$detail1 = trim($rsx[detail]);
								$detail2 = substr($detail1,0,1);								
								if($detail2!="["){								
								mysql_db_query($db_epm, " UPDATE  list  SET detail = '[".$presale_old_code."] $rsx[detail]' WHERE  runno = $rsx[runno]  ");
								}								
							}	// end while
							mysql_db_query($db_epm, " update  type_project SET  presale_code = '".trim($presale_old_code)."'    where id_type_project ='$id_type_project' ;");		
							#End Database: Sapphire ����������ҧ�ԧ㹪�ͧ detail 㹵��ҧ  list �������������㹪�ͧ presale_code 㹵��ҧ type_project 
							
							#Begin Database: GNIS ����������ҧ�ԧ㹪�ͧ detail 㹵��ҧ  list �������������㹪�ͧ presale_code 㹵��ҧ type_project 
							$str = " select *  from list t1 left join type_project t2 on t1.id_type_project = t2.id_type_project where  t1. id_type_project='$id_type_project'   ";
							$query_str = mysql_db_query($db_name_gnis, $str);
							while($rsx = mysql_fetch_assoc($query_str)){
								$detail1 = trim($rsx[detail]);
								$detail2 = substr($detail1,0,1);								
								if($detail2!="["){								
								mysql_db_query($db_name_gnis, " UPDATE  list  SET detail = '[".$presale_old_code."] $rsx[detail]' WHERE  runno = $rsx[runno]  ");
								}								
							}	// end while
							mysql_db_query($db_name_gnis, " update  type_project SET  presale_code = '".trim($presale_old_code)."'    where id_type_project ='$id_type_project' ;");		
							#End Database: GNIS ����������ҧ�ԧ㹪�ͧ detail 㹵��ҧ  list �������������㹪�ͧ presale_code 㹵��ҧ type_project						
						} // end if 
						
					//header("Location: ?id=$id&action=edit&refreshpage=1");
					echo "<script>window.location='?id=$id&action=edit&refreshpage=1';</script>";
					exit;
				}
}else if ($action == 'addnew') 	{
				$sql = "INSERT INTO  type_project (id_type_project,code_project,name_project,no_project,value,start_project,end_project,projecttype,province,province_code)	VALUES ('$id_type_project','".trim($code_project)."','$name_project','$no_project','$value','$start_project','$end_project','$projecttype','$province','$province_code')";
					$result  = mysql_db_query($db_name, $sql);
					$id_type_project = mysql_insert_id();
					#Begin Update type_project GNIS
					$sql_gnis = "INSERT INTO  type_project (id_type_project,code_project,name_project,no_project,value,start_project,end_project,projecttype,province,province_code)	VALUES ('$id_type_project','".trim($code_project)."','$name_project','$no_project','$value','$start_project','$end_project','$projecttype','$province','$province_code')";
					$result_gnis  = mysql_db_query($db_name_gnis, $sql_gnis);
					#End Update type_project GNIS
					if($result){
						$query = mysql_db_query($db_name, "select id_type_project from  type_project   ;");//Connect �ҹ�����š�Ѻ $db_name
						//header("Location: ?id=$id&action=edit&refreshpage=1");
						echo "<script>window.location='?id=$id&action=edit&refreshpage=1';</script>";
						exit;
					}else{	
						echo "�������ö�ѹ�֡�������� ";
					}

}else{
		
	 	$sql = "SELECT * FROM  type_project ";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}

} //end 

 if ($action == 'delete'){
		$sql 		= " select count(id_type_project) as num from list where id_type_project = '$id_type_project'  ";
		$result	= mysql_query($sql);
		$rs		= mysql_fetch_assoc($result);
		if($rs[num] >= 1){
			$msg	 = "�������öź�ç��ù���� - ���ç�����蹷������Ǣ�ͧ�Ѻ�ç��ù��";
			include("msg_box.php");
			echo "<meta http-equiv='refresh' content='0;url=$PHP_SELF'>" ;
			exit;
		} 

		mysql_query("delete from type_project where id_type_project = $id_type_project ");
			if (mysql_errno()){
			$msg = "Cannot delete parameter.";
			}else{
			//header("Location: ?runid=$runid&action=edit&refreshpage=1");
			echo "<script>window.location='?runid=$runid&action=edit&refreshpage=1';</script>";
			exit;
			}
}
$onLoad	= ($action == "") ;
$readonly	= ($action == "edit2") ? " readonly " : "" ;

?>
<html>
<head>
<title>������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="cost.css" type="text/css" rel="stylesheet">
<script language="javascript" src="libary/popcalendar.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
<script language="javascript" src="libary/xmlhttp.js"></script>
<script language="javascript">
function ok(){

	if (document.form1.code_project.value.length == 0){
		alert("��س��к������ç���");
		document.form1.code_project.focus();
		return false;
	} else {
		document.form1.submit();
		return true;
	}
	
}

function process()
{
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)	{

		code = document.form1.code_project.value;
		xmlHttp.open('GET', 'code_exists.php?code=' + code, true);	
		xmlHttp.onreadystatechange = handleServerResponse;	
		xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		xmlHttp.send(null);
		
	} else {
		setTimeout('process()', 10);
	}	
}

function handleServerResponse()
{

	if (xmlHttp.readyState == 4) {
	if (xmlHttp.status == 200){			
		CheckUser(xmlHttp.responseText);
		setTimeout('process()', 100);				
	} else {	
		alert("There was a problem accessing the server: " + xmlHttp.statusText);
	}}
		
}

function CheckUser(val) {	
	document.getElementById("status").innerHTML = val;	
  	if (val.length == 838) {
   		document.getElementById("save").disabled=false;	
  		return false;
  	} else {  
		document.getElementById("save").disabled=true;
    	return false;  	
  	}  
}

</script>
<?
//refresh openner
if ($refreshpage){
?>	
<SCRIPT LANGUAGE="JavaScript">
<!--
		alert('��Ѻ��ا���������º����');
		window.location = '<?=$PHP_SELF?>';
//-->
</SCRIPT>
<?
}
?>
</head>

<body <?=$onLoad?>>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="47" align="right" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><B class="pheader">
                <?=($rs[runid]!=0?"���":"����")?>�������ç���</B></td>
              </tr>
        </table>
          <!--<font style="font-size:16px; font-weight:bold; color:#FFFFFF;">
          <input name="Button25"  title="¡��ԡ" type="button"  style="width: 80;" class="xbutton" value="��Ѻ˹����ѡ" onClick="location.href='addtrip.php';" >
          </font>--></td>
      </tr>
      <tr>
        <?

 if ($action=="")
 {
?>
        <td valign="top" >
        <p><? include("header_cost.php"); // �������� ?></p>
        <table width="80%" border="0" align="center">
          <tr>
            <td>
            <form action="" method="get">
            <fieldset>
            <legend>���Ң������ç���</legend>
            <table width="100%" border="0">
              <tr>
                <td width="150" align="right">�����ç���:</td>
                <td><input type="text" name="name_project" value="<?php echo $_GET['name_project'];?>" size="50"/></td>
              </tr>
              <tr>
                <td align="right">����������ѭ��:</td>
                <td>
                <select name="yy_s">
                <option value="">����к�</option>
                <?php 
				for($y=2549;$y<=(date('Y')+543);$y++){
				?>
                <option value="<?php echo $y;?>" <?php echo ($_GET['yy_s']==$y)?' SELECTED ':'';?>><?php echo $y;?></option>
                <?php } ?>
                </select>
                </td>
              </tr>
              <tr>
                <td align="right">�������ç���:</td>
                <td>
                <select name="type_p">
				<option value="">����к�</option>
                <?php 
				foreach($arr_type as $key => $val){
				?>
                <option value="<?php echo $key;?>" <?php echo ($key == $_GET['type_p'])?' SELECTED ':'';?> ><?php echo $val; ?></option>
                <?php } ?>
                </select>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                <input type="submit" name="b_search" value="�ѹ�֡"/>&nbsp;<input type="button" name="b_cancel" value="¡��ԡ" onClick="javascript:window.location='?';"/>
                </td>
              </tr>
            </table>
            </fieldset>
            </form>
            </td>
          </tr>
        </table>
            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><a href="?action=addnew">�����ç���</a></td>
              </tr>
            </table>
            <br>
            <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black"  id="table0" class="sortable">
              <tr bgcolor="#A3B2CC" onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#A3B2CC';">
                <td width="4%" align="center"><strong>�ӴѺ</strong></td>
                <td width="8%" align="center"><b>�����ç���</b></td>
                <td width="21%" align="center"><strong>�����ç���</strong></td>
                <td width="6%" align="center"><strong>�ѧ��Ѵ</strong></td>
                <td width="6%" align="center"><strong>˹��§ҹ</strong></td>
                <td width="7%" align="center"><strong>�Ţ����ѭ��</strong></td>
                <td width="8%" align="center"><strong>��Ť���ç���</strong></td>
                <td width="10%" align="center"><strong>�ѹ�����������ѭ��</strong></td>
                <td width="11%" align="center"><strong>�ѹ�������ش�ѭ��</strong></td>
                <td width="10%" align="center"><strong>ʶҹ��ç���</strong></td>
                <td width="9%"><div align="center"><strong>����ͧ���</strong></div></td>
              </tr>
              <?php
		$i = 0;
		$no=0;
		$max=0;
		if($_GET['type_p']=='PRO'){
			$type_pW = "AND (type_project.code_project NOT LIKE 'OF%' AND type_project.code_project NOT LIKE 'MAR%' AND type_project.code_project NOT LIKE 'RD%' AND type_project.code_project NOT LIKE 'PS%' )";
		}else{
			$type_pW = ($_GET['type_p'])?" AND code_project LIKE('".$_GET['type_p']."%') ":'';
		}
		
		$name_projectW = ($_GET['name_project'])?" AND name_project LIKE('%".$_GET['name_project']."%') ":'';
		$start_projectW = ($_GET['yy_s'])?" AND start_project LIKE('".($_GET['yy_s']-543)."-%') ":'';
		$sql = "SELECT * FROM type_project  WHERE  name_project IS NOT NULL {$type_pW} {$name_projectW} {$start_projectW}";
		$result = mysql_query($sql);
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$i++;
			$no++;
			if ($rs[id_type_project] > $max) $max=$rs[id_type_project];
			
			if ($i % 2) {
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}
			
		// �ѧ��Ѵ 
		$sql_province = "SELECT * FROM province WHERE ccDigi='$rs[province_code]'";
		$result_province = @mysql_query($sql_province);
		$rs_p = @mysql_fetch_assoc($result_province);
		$txt_province = $rs_p[ccName];
		
		?>
              <tr bgcolor="<?=$bg?>">
                <td align="center" ><?=$i?></td>
                <td align="center"><?=$rs[code_project]?></td>
                <td width="21%"><?=$rs[name_project]?></td>
                <td><?=$txt_province?></td>
                <td><?=$rs[province]?></td>
                <td><?=$rs[no_project]?></td>
                <td align="right"><?=number_format($rs[value],2)."&nbsp;"?></td>
                <td align="left"><?=daythai($rs[start_project])."&nbsp;"?></td>
                <td align="left"><?=daythai($rs[end_project])."&nbsp;"?></td>
                <td align="left"><?=$arr_projecttype[$rs[projecttype]]?></td>
                <td  align="center"><input class="xbutton" style="width: 70;" type="button" value="Edit" onClick="location.href='?id_type_project=<?=$rs[id_type_project]?>&action=edit2';" name="button2">
                    <input class="xbutton"  style="width: 70;" type="button" value="Delete" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id_type_project=<?=$rs[id_type_project]?>';" name="button"></td>
              </tr>
              <?
		}
		?>
            </table>
          <?
}else if (  ($action== "addnew") OR ($action=="edit2") ){

	 if ($action=="edit2"){
		$sql = "select * from type_project where id_type_project='$id_type_project'  ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$start_project = swapdate($rs[start_project]);
 			$end_project = swapdate($rs[end_project]);
		}
		$code2 = substr($rs[code_project],0,2);
		if($code2=="ps" || $code2=="PS" || $code2=="Ps"){ $msg_presale = "** �ҡ��ҹ��ͧ��û�Ѻ��ا��������¡�ù��ҡ����� Presale �� Project ��س����͡ Check Box";$chbox=true;}
	}
		


 include("header_cost.php"); // ��������
?>
            <form name="form1"  method = POST  action = "<?=$PHP_SELF?>">
              <INPUT TYPE="hidden" NAME="id_type_project" VALUE="<?=$id_type_project?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>">
              <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
                <tr>
                  <td colspan=3 align="left" valign="top" bgcolor="#888888"><B class="gcaption">
                    <?=($rs[id_type_project]!=0?"���":"����")?>
                    �������ç���</B></td>
                </tr>
                <tr>
                  <td width="23%" align="right" valign="middle" bgcolor="#CCCCCC">�����ç���</td>
                  <td align="left"><input name="code_project" type="text" id="code_project" 
				  value="<?=$rs[code_project]?>" size="50" <? if(!$chbox){echo $readonly;}?>>
                  <input type="button" name="Button" onClick="conp2o()" value="����ç��ù������繤������� office">
                  <script language="javascript">
				    function conp2o(){
						if(confirm(" ����ç��ù������繤������� office ? ")==true){
							location.href='project2office.php?id_type_project=<?=$rs[id_type_project]?>&action=p2o';  
						}
					}
				  </script>
                  </td>
                </tr>
				<? if($chbox){ ?>
                <tr>
                  <td align="right" valign="middle" bgcolor="#CCCCCC" class="caption">��Ѻ�������ਤ</td>
                  <td align="left" valign="top" class="caption"><input name="presale2project" type="checkbox" id="presale2project" value="1">
                  <?=$msg_presale?>
                  <input name="presale_old_code" type="hidden" id="old_code" value="<?=$rs[code_project]?>"></td>
                </tr>
				<? } //end $chbox?>
                <tr>
                  <td align="right" valign="middle" bgcolor="#CCCCCC">�����ç���</td>
                  <td align="left" valign="top"><input name="name_project" type="text" id="name_project" value="<?=$rs[name_project]?>" size="100"></td>
                </tr>
                <tr>
                  <td height="18" align="right" valign="middle" bgcolor="#999999">ʶҹ��ç���</td>
                  <td align="left" valign="top"><input name="projecttype" type="radio" id="radio" value="1" <? if($rs[projecttype]==1){ echo "checked";}?>>
                  �ç���ʹѺʹع��â�� &nbsp;</td>
                </tr>
                <tr>
                  <td height="18" align="right" valign="middle" bgcolor="#999999">&nbsp;</td>
                  <td align="left" valign="top"><input type="radio" name="projecttype" id="radio2" value="2" <? if($rs[projecttype]==2){ echo "checked";}?>>
�ç��������ҧ���Թ�ҹ&nbsp;</td>
                </tr>
                <tr>
                  <td height="18" align="right" valign="middle" bgcolor="#999999">&nbsp;</td>
                  <td align="left" valign="top"><input type="radio" name="projecttype" id="radio3" value="3" <? if($rs[projecttype]==3){ echo "checked";}?>>
                  �ç���ʹѺʹع��ú����çҹ </td>
                </tr>
                <tr>
                  <td height="18" align="right" valign="middle" bgcolor="#999999">&nbsp;</td>
                  <td align="left" valign="top"><input type="radio" name="projecttype" id="radio4" value="4" <? if($rs[projecttype]==4){ echo "checked";}?>>
�ç����Ԩ����оѲ�� </td>
                </tr>
                <tr>
                  <td height="18" align="right" valign="middle" bgcolor="#999999">&nbsp;</td>
                  <td align="left" valign="top"><input type="radio" name="projecttype" id="radio5" value="5">
�ç�������㹻�Сѹ</td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">�ѧ��Ѵ</td>
                  <td align="left" valign="top"><label>
                    <select name="province_code" id="province_code">
					<option value=""> - ���͡�ѧ��Ѵ����Դ�ç��� - </option>
					<?
					th_asort($arr_province);
					foreach($arr_province as $keyP => $valP){
							if($rs[province_code] == $keyP){ $sel = "selected";}else{ $sel = "";}
							echo "<option value='$keyP' $sel>$valP</option>";
					}
					?>
                    </select>
                  </label></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">˹��§ҹ����Դ�ç���</td>
                  <td align="left" valign="top"><input name="province" type="text" id="province" value="<?=$rs[province]?>" size="50"></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">�Ţ����ѭ��</td>
                  <td align="left" valign="top"><input name="no_project" type="text" id="no_project" value="<?=$rs[no_project]?>" size="50"></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">��Ť���ç���</td>
                  <td align="left" valign="top"><input name="value" type="text" id="value" value="<?=$rs[value]?>" size="50"></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">�ѹ�����������ѭ��</td>
                  <td align="left" valign="top"><input type="text" name="start_project" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<? if($start_project == "" || $start_project == "00/00/0000"){ echo date("d/m/").(date("Y") ); }else{ echo $start_project; }?>">
	<script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.start_project, \"dd/mm/yyyy\")' value=' ���͡�ѹ ' class='input'>")	}</script></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" bgcolor="#666666">�ѹ�������ش�ѭ��</td>
                  <td align="left" valign="top"><input type="text" name="end_project" id="Txt-Field" class="input" maxlength="10" style="width:200px;" value="<? if($end_project == "" || $end_project == "00/00/0000"){ echo date("d/m/").(date("Y") ); }else{ echo $end_project; }?>">
	<script language='javascript'>	if (!document.layers) {	document.write("<input type=button onclick='popUpCalendar(this, form1.end_project, \"dd/mm/yyyy\")' value=' ���͡�ѹ ' class='input'>")	}</script></td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="23%">&nbsp;</td>
                  <td align="left" valign="top">
				  <input name="old_code_project" type="hidden" id="old_code_project" value="<?=$rs[code_project]?>">
				  <button id="save" style="width:60px;" onClick="ok()">�ѹ�֡</button>
				  <button style="width:60px;" onClick="document.form1.reset()">Reset</button>
				  <button style="width:60px;" onClick="<? if($action == "edit2") echo "location.href='?';"; else echo "window.close();";?>">¡��ԡ</button>				</td>
                </tr>
              </table>
            </form>
          </td>
      </tr>
    </table>
    <? } ?>
    </td>
  </tr>
</table>
</body>
</html>