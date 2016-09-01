<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agroecologicalzones_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Agroecologicalzones";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9069";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$agroecologicalzones=new Agroecologicalzones();
if(!empty($delid)){
	$agroecologicalzones->id=$delid;
	$agroecologicalzones->delete($agroecologicalzones);
	redirect("agroecologicalzones.php");
}
//Authorization.
$auth->roleid="9068";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addagroecologicalzones_proc.php',600,430);" value="New" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Agroecological Zones </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9070";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9071";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="crp_agroecologicalzones.id, crp_agroecologicalzones.name, crp_agroecologicalzones.remarks";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$agroecologicalzones->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$agroecologicalzones->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9070";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addagroecologicalzones_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9071";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='agroecologicalzones.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
