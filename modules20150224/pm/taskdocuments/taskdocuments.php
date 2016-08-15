<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Taskdocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8352";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$taskdocuments=new Taskdocuments();
if(!empty($delid)){
	$taskdocuments->id=$delid;
	$taskdocuments->delete($taskdocuments);
	redirect("taskdocuments.php");
}
//Authorization.
$auth->roleid="8351";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtaskdocuments_proc.php',600,430);" value="Add Taskdocuments " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Title </th>
			<th>Task </th>
			<th>Document Type </th>
			<th>Upload File </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8353";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8354";//View
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
		$fields="pm_taskdocuments.id, pm_taskdocuments.title, pm_tasks.name as taskid, dms_documenttypes.name as documenttypeid, pm_taskdocuments.file, pm_taskdocuments.remarks, pm_taskdocuments.ipaddress, pm_taskdocuments.createdby, pm_taskdocuments.createdon, pm_taskdocuments.lasteditedby, pm_taskdocuments.lasteditedon";
		$join=" left join pm_tasks on pm_taskdocuments.taskid=pm_tasks.id  left join dms_documenttypes on pm_taskdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$taskdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$taskdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->title; ?></td>
			<td><?php echo $row->taskid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8353";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtaskdocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8354";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='taskdocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
