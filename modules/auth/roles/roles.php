<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Roles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Roles";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="6";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$roles=new Roles();
if(!empty($delid)){
	$roles->id=$delid;
	$roles->delete($roles);
	redirect("roles.php");
}
//Authorization.
$auth->roleid="5";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addroles_proc.php',540, 240);"><span>ADD ROLES</span></a>
</div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Sys_modules </th>
			<th>Module </th>
<?php
//Authorization.
$auth->roleid="7";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8";//View
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
		$fields="auth_roles.id, auth_roles.name, sys_modules.name as moduleid, auth_roles.module, auth_roles.createdby, auth_roles.createdon, auth_roles.lasteditedby, auth_roles.lasteditedon";
		$join=" left join sys_modules on auth_roles.moduleid=sys_modules.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where auth_roles.moduleid in(2,3,4,5,6,7,20,21,22,23,24,25) ";
		$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$roles->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->moduleid; ?></td>
			<td><?php echo $row->module; ?></td>
<?php
//Authorization.
$auth->roleid="7";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addroles_proc.php?id=<?php echo $row->id; ?>', 540, 240);"><img src="../edit.png" alt="edit" title="edit" /></a></td>
<?php
}
//Authorization.
$auth->roleid="8";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='roles.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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