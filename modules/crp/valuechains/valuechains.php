<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Valuechains_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Valuechains";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9115";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$valuechains=new Valuechains();
if(!empty($delid)){
	$valuechains->id=$delid;
	$valuechains->delete($valuechains);
	redirect("valuechains.php");
}
//Authorization.
$auth->roleid="9114";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addvaluechains_proc.php',600,430);" value="Add" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th><?php echo $crp->subcategory; ?></th>
			<th>CRP </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9116";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9117";//View
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
		$fields="crp_valuechains.id, crp_valuechains.name, concat(crp_crps.crpno,' ',crp_crps.crp_name) as crpid, crp_valuechains.remarks, crp_valuechains.ipaddress, crp_valuechains.createdby, crp_valuechains.createdon, crp_valuechains.lasteditedby, crp_valuechains.lasteditedon";
		$join=" left join crp_crps on crp_valuechains.crpid=crp_crps.id ";
		$having="";
		$groupby="";
		$orderby=" order by crpid, name";
		$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$valuechains->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->crpid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9116";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addvaluechains_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9117";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='valuechains.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
