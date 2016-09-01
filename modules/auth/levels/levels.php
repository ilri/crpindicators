<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Levels";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$levels=new Levels();
if(!empty($delid)){
	$levels->id=$delid;
	$levels->delete($levels);
	redirect("levels.php");
}
//Authorization.
$auth->roleid="1";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addlevels_proc.php', 540, 160);"><span>ADD LEVELS</span></a>
</div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="3";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4";//View
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
		$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$levels->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="3";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlevels_proc.php?id=<?php echo $row->id; ?>', 600, 430);"><img src="../edit.png" alt="edit" title="edit" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='levels.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
