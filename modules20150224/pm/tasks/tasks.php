<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tasks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tasks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8228";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tasks=new Tasks();
if(!empty($delid)){
	$tasks->id=$delid;
	$tasks->delete($tasks);
	redirect("tasks.php");
}
//Authorization.
$auth->roleid="8227";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtasks_proc.php',600,430);" value="Add Tasks " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task Name </th>
			<th>Task Description </th>
			<th>Project </th>
			<th>Route </th>
			<th>Responsible Person </th>
			<th>Assignment </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8229";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8230";//View
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
		$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, wf_routes.name as routeid, pm_tasks.projecttype, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_assignments.name as assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_taskstatuss.name as statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
		$join=" left join wf_routes on pm_tasks.routeid=wf_routes.id  left join hrm_employees on pm_tasks.employeeid=hrm_employees.id  left join hrm_assignments on pm_tasks.assignmentid=hrm_assignments.id  left join pm_taskstatuss on pm_tasks.statusid=pm_taskstatuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tasks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->routeid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $row->statusid; ?></td>
<?php
//Authorization.
$auth->roleid="8229";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtasks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8230";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tasks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
