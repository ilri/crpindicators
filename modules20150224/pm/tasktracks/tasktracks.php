<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tasktracks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tasktracks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8396";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tasktracks=new Tasktracks();
if(!empty($delid)){
	$tasktracks->id=$delid;
	$tasktracks->delete($tasktracks);
	redirect("tasktracks.php");
}
//Authorization.
$auth->roleid="8395";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtasktracks_proc.php',600,430);" value="Add Tasktracks " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Task </th>
			<th>Status </th>
			<th>Changed On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8397";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8398";//Add
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
		$fields="pm_tasktracks.id, pm_tasks.name as taskid, pm_statuss.name as statusid, pm_tasktracks.changedon, pm_tasktracks.remarks, pm_tasktracks.ipaddress, pm_tasktracks.createdby, pm_tasktracks.createdon, pm_tasktracks.lasteditedby, pm_tasktracks.lasteditedon";
		$join=" left join pm_tasks on pm_tasktracks.taskid=pm_tasks.id  left join pm_statuss on pm_tasktracks.statusid=pm_statuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tasktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tasktracks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->taskid; ?></td>
			<td><?php echo $row->statusid; ?></td>
			<td><?php echo formatDate($row->changedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8397";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtasktracks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8398";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tasktracks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
