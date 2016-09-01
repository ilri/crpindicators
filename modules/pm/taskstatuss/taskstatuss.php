<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Taskstatuss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8392";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$taskstatuss=new Taskstatuss();
if(!empty($delid)){
	$taskstatuss->id=$delid;
	$taskstatuss->delete($taskstatuss);
	redirect("taskstatuss.php");
}
//Authorization.
$auth->roleid="8391";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtaskstatuss_proc.php',600,430);" value="Add Taskstatuss " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8393";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8394";//Add
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
		$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$taskstatuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8393";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtaskstatuss_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8394";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='taskstatuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
