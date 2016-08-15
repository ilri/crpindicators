<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notificationtypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Notificationtypes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8216";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$notificationtypes=new Notificationtypes();
if(!empty($delid)){
	$notificationtypes->id=$delid;
	$notificationtypes->delete($notificationtypes);
	redirect("notificationtypes.php");
}
//Authorization.
$auth->roleid="8215";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addnotificationtypes_proc.php',600,430);" value="Add Notificationtypes " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Notification Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8217";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8218";//View
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
		$fields="pm_notificationtypes.id, pm_notificationtypes.name, pm_notificationtypes.remarks, pm_notificationtypes.ipaddress, pm_notificationtypes.createdby, pm_notificationtypes.createdon, pm_notificationtypes.lasteditedby, pm_notificationtypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$notificationtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$notificationtypes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8217";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addnotificationtypes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8218";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='notificationtypes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
