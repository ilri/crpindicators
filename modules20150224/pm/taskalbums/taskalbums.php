<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskalbums_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Taskalbums";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8348";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$taskalbums=new Taskalbums();
if(!empty($delid)){
	$taskalbums->id=$delid;
	$taskalbums->delete($taskalbums);
	redirect("taskalbums.php");
}
//Authorization.
$auth->roleid="8347";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtaskalbums_proc.php',600,430);" value="Add Taskalbums " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task </th>
			<th>Album </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8349";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8350";//View
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
		$fields="pm_taskalbums.id, pm_tasks.name as taskid, pm_taskalbums.name, pm_taskalbums.remarks, pm_taskalbums.ipaddress, pm_taskalbums.createdby, pm_taskalbums.createdon, pm_taskalbums.lasteditedby, pm_taskalbums.lasteditedon";
		$join=" left join pm_tasks on pm_taskalbums.taskid=pm_tasks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$taskalbums->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$taskalbums->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->taskid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8349";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtaskalbums_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8350";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='taskalbums.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
