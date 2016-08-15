<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskobservers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Taskobservers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8220";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$taskobservers=new Taskobservers();
if(!empty($delid)){
	$taskobservers->id=$delid;
	$taskobservers->delete($taskobservers);
	redirect("taskobservers.php");
}
//Authorization.
$auth->roleid="8219";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtaskobservers_proc.php',600,430);" value="Add Taskobservers " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task </th>
			<th>Observer </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8221";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8222";//View
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
		$fields="pm_taskobservers.id, pm_tasks.name as taskid, hrm_employees.name as employeeid, pm_taskobservers.description, pm_taskobservers.remarks, pm_taskobservers.ipaddress, pm_taskobservers.createdby, pm_taskobservers.createdon, pm_taskobservers.lasteditedby, pm_taskobservers.lasteditedon";
		$join=" left join pm_tasks on pm_taskobservers.taskid=pm_tasks.id  left join hrm_employees on pm_taskobservers.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$taskobservers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$taskobservers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->taskid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8221";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtaskobservers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8222";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='taskobservers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
