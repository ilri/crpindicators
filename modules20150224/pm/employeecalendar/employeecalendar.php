<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeecalendar_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeecalendar";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8340";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeecalendar=new Employeecalendar();
if(!empty($delid)){
	$employeecalendar->id=$delid;
	$employeecalendar->delete($employeecalendar);
	redirect("employeecalendar.php");
}
//Authorization.
$auth->roleid="8339";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeecalendar_proc.php',600,430);" value="Add Employeecalendar " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Start Date </th>
			<th>Start Time </th>
			<th>End Date </th>
			<th>End Time </th>
			<th>Event Name </th>
			<th>Location </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8341";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8342";//View
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
		$fields="pm_employeecalendar.id, hrm_employees.name as employeeid, pm_employeecalendar.startdate, pm_employeecalendar.starttime, pm_employeecalendar.enddate, pm_employeecalendar.endtime, pm_employeecalendar.eventname, pm_employeecalendar.location, pm_employeecalendar.description, pm_employeecalendar.remarks, pm_employeecalendar.ipaddress, pm_employeecalendar.createdby, pm_employeecalendar.createdon, pm_employeecalendar.lasteditedby, pm_employeecalendar.lasteditedon";
		$join=" left join hrm_employees on pm_employeecalendar.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeecalendar->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeecalendar->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo $row->starttime; ?></td>
			<td><?php echo formatDate($row->enddate); ?></td>
			<td><?php echo $row->endtime; ?></td>
			<td><?php echo $row->eventname; ?></td>
			<td><?php echo $row->location; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8341";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeecalendar_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8342";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeecalendar.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
