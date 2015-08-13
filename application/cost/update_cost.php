<?
include ("checklogin.php");
include ("config/phpconfig.php");

$report_title = "บุคลากร";
$org_id = intval($org_id);

$epm_mode = "off";
$del_mode = "off";

############# define variable zone #############

define('CON_COST_ACCRONE', '511013-15', true);
define('CON_TYPE_ACCRONE', 'ค่าเบี้ยเลี้ยง-', true);
$CON_TYPE_COST = array('5', '31');
define('CON_UPDATE_SUCCESS', 'บันทึกข้อมูลสำเร็จ', true);
define('CON_UPDATE_FAIL', 'ข้อมูลไม่มีการเปลี่ยนแปลง', true);

############# define variable zone #############

$id = (isset($_GET['id']))? $_GET['id']: '0';
?>
<html>
<head>
<title>การเชื่อมโยงผู้ใช้งานกับประเภทรหัส GL</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body>
<div id="wrapper" style="width:500px; margin:auto; border:1px solid grey; text-align:center;">
<h3 style="background-color:#a3b2cc; color:#FFFFFF; padding:3px; margin:0px;">การเชื่อมโยงผู้ใช้งานกับประเภทรหัส GL</h3>
<form action="update_cost.php?id=<?=$id?>" method="post" onSubmit="return doSubmit();">
<?
if(ctype_digit($id) && $id!='0'){

	$updateMsg = '';

	$arr_user = array();
	$sql = 'select userid, name, surname from cos_user where userid='.$id.' limit 0,1';
	$result = mysql_query($sql, $conn);
	list($arr_user['userid'], $arr_user['name'], $arr_user['surname']) = mysql_fetch_row($result);
	unset($sql, $result);

	if(isset($_POST['submit']) && isset($_POST['id_type_cost']) && in_array($_POST['id_type_cost'],$CON_TYPE_COST,true)){

		$id_cost_type = $_POST['id_type_cost'];

		$sql = 'update type_accrone set
			id_cost_accrone="'.CON_COST_ACCRONE.'",
			type_accrone="'.CON_TYPE_ACCRONE.$arr_user['name'].'",
			id_type_cost='.$id_cost_type.'
			where userid='.$arr_user['userid'].'
			limit 1';
		mysql_query($sql, $conn);

		if(mysql_affected_rows($conn) <= 0){

			$sql = 'insert into type_accrone set
				id_cost_accrone="'.CON_COST_ACCRONE.'",
				type_accrone="'.CON_TYPE_ACCRONE.$arr_user['name'].'",
				id_type_cost='.$id_cost_type.',
				userid='.$arr_user['userid'];
			mysql_query($sql, $conn);

			$updateMsg = (mysql_affected_rows($conn) > 0)? CON_UPDATE_SUCCESS: CON_UPDATE_FAIL;
		}
		else $updateMsg = CON_UPDATE_SUCCESS;
	}
	
	$arr_type_cost = array();
	$sql = 'select * from type_cost where id_type_cost in('.implode(',',$CON_TYPE_COST).') order by id_type_cost';
	$result = mysql_query($sql, $conn);
	while($row = mysql_fetch_assoc($result)) $arr_type_cost[$row['id_type_cost']] = $row['type_cost'];
	unset($sql, $result, $row);

	$sql = 'select id_type_cost from type_accrone where userid='.$arr_user['userid'].' order by runid limit 0,1';
	$result = mysql_query($sql, $conn);
	$arr_user['id_type_cost'] = mysql_result($result, 0);

?>
<p style="text-align:center; color:red;"><?=$updateMsg?></p>
<table style="with:400px; margin:auto;">
<tr>
<td align="right">ชื่อ :</td>
<td><?=$arr_user['name'].' '.$arr_user['surname']?></td>
</tr>
<tr>
<td>ประเภทค่าใช้จ่าย :</td>
<td><select name="id_type_cost" id="id_type_cost">
<option id="id_type_cost_0" value="0">ระบุประเภท</option>
<? foreach($arr_type_cost as $id=>$value){ ?><option id="id_type_cost_<?=$id?>" value="<?=$id?>"><?=$value?></option><? } ?>
</select></td>
</tr>
</table>
<input type="submit" name="submit" value="บันทึก">

<script type="text/javascript">
if(document.getElementById && document.getElementById("id_type_cost_<?=$arr_user['id_type_cost']?>")){
document.getElementById("id_type_cost_<?=$arr_user['id_type_cost']?>").selected = true;
document.getElementById('id_type_cost').removeChild(document.getElementById('id_type_cost_0'));
}
</script>
<?
}
else{

}
?>
<input type="button" value="ย้อนกลับ" onClick="goBack();">
</form>
</div>
<script type="text/javascript">
function goBack(){
window.location.href = "list_user.php";
}
function doSubmit(){
if(document.getElementById && document.getElementById("id_type_cost_0") && document.getElementById("id_type_cost_0").selected==true){
alert('กรุณาระบุประเภทค่าใช้จ่าย');
return false;
}
return true;
}
</script>
</body>
</html>