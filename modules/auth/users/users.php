<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Users";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$resetid = $_GET['resetid'];
$status=$_GET['status'];

if(!empty($resetid)){
  $users = new Users();
  $fields="*";
  $join="  ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$resetid' ";
  $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $users = $users->fetchObject;
  $users->password=md5('a');
  
  $user = new Users();
  $user->edit($users);
  redirect("users.php");
}

$users=new Users();
if(!empty($delid)){
	$users = new Users();
	$fields="*";
	$join="  ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$delid' ";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$users = $users->fetchObject;
	$users->status=$status;
	
	$user = new Users();
	$user->edit($users);
	redirect("users.php");
}
//Authorization.
$auth->roleid="11";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addusers_proc.php',600,430);" value="Add Users " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Username </th>
			<th>Level </th>
			<th>Status </th>
			<th>Last Login </th>
<?php
//Authorization.
$auth->roleid="13";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="14";//View
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
		$fields="auth_users.id, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, auth_users.username, auth_users.password, auth_levels.name as levelid, auth_users.status, auth_users.lastlogin, auth_users.createdby, auth_users.createdon, auth_users.lasteditedby, auth_users.lasteditedon";
		$join=" left join hrm_employees on auth_users.employeeid=hrm_employees.id  left join auth_levels on auth_users.levelid=auth_levels.id ";
		$having="";
		$groupby="";
		$orderby="";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$users->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><a href='users.php?resetid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to Reset?')"><?php echo $row->username; ?></></td>
			<td><?php echo $row->levelid; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->lastlogin; ?></td>
<?php
//Authorization.
$auth->roleid="13";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addusers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="14";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='users.php?delid=<?php echo $row->id; ?>&status=<?php if($row->status=='Active'){echo"Inactive";}else{echo"Active";}?>' onclick="return confirm('Are you sure you want to delete?')"><?php if($row->status=='Active'){echo"De-Activate";}else{echo"Activate";}?></a></td>
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
