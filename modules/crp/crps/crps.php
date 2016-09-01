<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crps_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Crps";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8958";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$crps=new Crps();
if(!empty($delid)){
	$crps->id=$delid;
	$crps->delete($crps);
	redirect("crps.php");
}
//Authorization.
$auth->roleid="8957";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcrps_proc.php',600,430);" value="Add Crps " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>CRP No </th>
			<th>Crp Name </th>
			<th>Category Name </th>
			<th>Sub Category Name </th>
<?php
//Authorization.
$auth->roleid="8959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8960";//View
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
		$fields="crp_crps.id, crp_crps.crpno, crp_crps.crp_name, crp_crps.category, crp_crps.subcategory";
		$join="";
		$having="";
		$groupby="";
		$orderby=" order by crpno ";
		$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$crps->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->crpno; ?></td>
			<td><?php echo $row->crp_name; ?></td>
			<td><?php echo $row->category; ?></td>
			<td><?php echo $row->subcategory; ?></td>
<?php
//Authorization.
$auth->roleid="8959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcrps_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8960";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='crps.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
