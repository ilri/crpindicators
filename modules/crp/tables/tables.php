<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8994";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tables=new Tables();
if(!empty($delid)){
	$tables->id=$delid;
	$tables->delete($tables);
	redirect("tables.php");
}
//Authorization.
$auth->roleid="8993";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtables_proc.php',600,430);" value="Add Tables " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Table Name </th>
			<th>Description </th>
			<th>Remarks </th>
			<th>Status </th>
			<th>Indicator No </th>
			<th>Title </th>
			<th>Position </th>
<?php
//Authorization.
$auth->roleid="8995";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8996";//View
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
		$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks, crp_tables.status, crp_tables.indicator, crp_tables.title, crp_tables.position";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td valign='top'><?php echo $i; ?></td>
			<td valign='top'><?php echo $row->name; ?></td>
			<td valign='top'><?php echo $row->description; ?></td>
			<td valign='top'><?php echo $row->remarks; ?></td>
			<td valign='top'><?php echo $row->status; ?></td>
			<td valign='top'><?php echo $row->indicator; ?></td>
			<td valign='top'><?php echo $row->title; ?></td>
			<td valign='top'><?php echo $row->position; ?></td>
<?php
//Authorization.
$auth->roleid="8995";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td valign='top'><a href="javascript:;" onclick="showPopWin('addtables_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8996";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td valign='top'><a href='tables.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
