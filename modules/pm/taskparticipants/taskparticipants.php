<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskparticipants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Taskparticipants";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8224";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$taskparticipants=new Taskparticipants();
if(!empty($delid)){
	$taskparticipants->id=$delid;
	$taskparticipants->delete($taskparticipants);
	redirect("taskparticipants.php");
}
//Authorization.
$auth->roleid="8223";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtaskparticipants_proc.php',600,430);" value="Add Taskparticipants " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task </th>
			<th>Participant </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8225";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8226";//View
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
		$fields="pm_taskparticipants.id, pm_tasks.name as taskid, hrm_employees.name as employeeid, pm_taskparticipants.description, pm_taskparticipants.remarks, pm_taskparticipants.ipaddress, pm_taskparticipants.createdby, pm_taskparticipants.createdon, pm_taskparticipants.lasteditedby, pm_taskparticipants.lasteditedon";
		$join=" left join pm_tasks on pm_taskparticipants.taskid=pm_tasks.id  left join hrm_employees on pm_taskparticipants.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$taskparticipants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$taskparticipants->result;
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
$auth->roleid="8225";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtaskparticipants_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8226";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='taskparticipants.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
