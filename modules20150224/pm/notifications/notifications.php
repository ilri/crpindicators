<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Notifications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8212";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$notifications=new Notifications();
if(!empty($delid)){
	$notifications->id=$delid;
	$notifications->delete($notifications);
	redirect("notifications.php");
}
//Authorization.
$auth->roleid="8211";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addnotifications_proc.php',600,430);" value="Add Notifications " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Notification Type </th>
			<th>Subject </th>
			<th>Status</th>
<?php
//Authorization.
$auth->roleid="8213";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8214";//View
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
		$fields="pm_notifications.id, pm_notificationtypes.name as notificationtypeid, pm_notifications.subject, pm_notificationrecipients.status, pm_notifications.body, pm_tasks.name as taskid, pm_notifications.ipaddress, pm_notifications.createdby, pm_notifications.createdon, pm_notifications.lasteditedby, pm_notifications.lasteditedon";
		$join=" left join pm_notificationtypes on pm_notifications.notificationtypeid=pm_notificationtypes.id  left join pm_tasks on pm_notifications.taskid=pm_tasks.id left join pm_notificationrecipients on pm_notificationrecipients.notificationid=pm_notifications.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pm_notifications.id in(select notificationid from pm_notificationrecipients where employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."'))";
		$notifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$notifications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->notificationtypeid; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addnotifications_proc.php?id=<?php echo $row->id; ?>&not=true',600,430);"><?php echo $row->subject; ?></a></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8213";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td>&nbsp;</td>
<?php
}
//Authorization.
$auth->roleid="8214";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td>&nbsp;</td>
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
