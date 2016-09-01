<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notificationrecipients_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Notificationrecipients";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8344";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../rptheader.php";

$delid=$_GET['delid'];
$notificationrecipients=new Notificationrecipients();
if(!empty($delid)){
	$notificationrecipients->id=$delid;
	$notificationrecipients->delete($notificationrecipients);
	redirect("notificationrecipients.php");
}
//Authorization.
$auth->roleid="8343";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<style>
body{background-image:none !important;}
</style>

<?php }?>
<table class="table table-condensed table-responsive">
	
		<tr>
			<th>#</th>
			<th>Notification </th>
			<th>Email </th>
			<th>Notified On </th>
			<th>Read On </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8345";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8346";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	<tbody>
	<?php
		$i=0;
		$fields="pm_notificationrecipients.id, pm_notifications.id as notificationid,pm_notifications.subject, hrm_employees.id as employeeid, pm_notificationrecipients.email, pm_notificationrecipients.notifiedon, pm_notificationrecipients.readon, pm_notificationrecipients.status, pm_notificationrecipients.ipaddress, pm_notificationrecipients.createdby, pm_notificationrecipients.createdon, pm_notificationrecipients.lasteditedby, pm_notificationrecipients.lasteditedon";
		$join=" left join pm_notifications on pm_notificationrecipients.notificationid=pm_notifications.id  left join hrm_employees on pm_notificationrecipients.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby=" order by pm_notificationrecipients.status, pm_notificationrecipients.id desc";
		$where=" where hrm_employees.id in(select employeeid from auth_users where id='".$_SESSION['userid']."') ";
		$notificationrecipients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$notificationrecipients->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr style="color:<?php if($row->status=='unread'){echo '#F00';}?>">
			<td><?php echo $i; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('../notifications/addnotifications_proc.php?id=<?php echo $row->notificationid; ?>&notificationrecipientid=<?php echo $row->id; ?>&status=<?php echo $row->status; ?>&not=true',600,430);"><?php echo $row->subject; ?></a></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->notifiedon; ?></td>
			<td><?php if($row->status!="unread"){echo $row->readon;} ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8345";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td>&nbsp;</td>
<?php
}
//Authorization.
$auth->roleid="8346";//View
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
//include"../../../foot.php";
?>
