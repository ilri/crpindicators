<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Usergroup_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Usergroup";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8954";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$usergroup=new Usergroup();
if(!empty($delid)){
	$usergroup->id=$delid;
	$usergroup->delete($usergroup);
	redirect("usergroup.php");
}
//Authorization.
$auth->roleid="8953";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="content">
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addusergroup_proc.php',600,430);" value="Add Usergroup " type="button"/></div>
<div class="clearb"></div>
<div class="content-flex">
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>User Id </th>
			<th>Group Id </th>
			<th>Join Date </th>
<?php
//Authorization.
$auth->roleid="8955";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8956";//View
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
		$fields="crp_usergroup.id, crp_users.user_name user_id, crp_groups.group_name group_id, crp_usergroup.join_date";
		$join=" left join crp_groups on crp_groups.id=crp_usergroup.group_id left join crp_users on crp_users.id=crp_usergroup.user_id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		$usergroup->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$usergroup->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->user_id; ?></td>
			<td><?php echo $row->group_id; ?></td>
			<td><?php echo formatDate($row->join_date); ?></td>
<?php
//Authorization.
$auth->roleid="8955";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addusergroup_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8956";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='usergroup.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
<?php
include"../../../foot.php";
?>
<?php
include"../../../foot.php";
?>
