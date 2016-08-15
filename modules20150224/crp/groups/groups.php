<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Groups_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Groups";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8990";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$groups=new Groups();
if(!empty($delid)){
	$groups->id=$delid;
	$groups->delete($groups);
	redirect("groups.php");
}
//Authorization.
$auth->roleid="8989";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="content">
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addgroups_proc.php',600,430);" value="Add Groups " type="button"/></div>
<div class="clearb"></div>
<div class="content-flex">
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Group Name </th>
<?php
//Authorization.
$auth->roleid="8991";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8992";//View
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
		$fields="crp_groups.id, crp_groups.group_name";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$groups->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->group_name; ?></td>
<?php
//Authorization.
$auth->roleid="8991";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addgroups_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8992";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='groups.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
