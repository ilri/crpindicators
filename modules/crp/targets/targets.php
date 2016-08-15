<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Targets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Targets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9073";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$targets=new Targets();
if(!empty($delid)){
	$targets->id=$delid;
	$targets->delete($targets);
	redirect("targets.php");
}
//Authorization.
$auth->roleid="9072";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtargets_proc.php',600,430);" value="Add Targets " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>CRP Indicator </th>
			<th>CRP </th>
			<th>Target </th>
			<th> </th>
			<th>Year </th>
			<th>Date </th>
			<?php
 $crp=mysql_fetch_object(mysql_query("select * from crp_crps where id='".$_SESSION['crpid']."'"));?>
<th><?php echo $crp->category; ?></th>
			<th><?php echo $crp->subcategory; ?></th>
<th>User Group</th>
<?php
//Authorization.
$auth->roleid="9074";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9075";//Add
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
		$fields="crp_targets.id,crp_targets.themeid,crp_targets.valuechainid, crp_tables.description as tableid, crp_crps.crp_name as crpid, crp_targets.target, crp_users.user_name as userid, crp_users.id user, crp_targets.year, crp_targets.datekeyed";
		$join=" left join crp_tables on crp_targets.tableid=crp_tables.id  left join crp_crps on crp_targets.crpid=crp_crps.id  left join crp_users on crp_targets.userid=crp_users.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_targets.crpid='".$_SESSION['crpid']."' and crp_targets.userid='".$_SESSION['userid']."'";
		$targets->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$targets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tableid; ?></td>
			<td><?php echo $row->crpid; ?></td>
			<td><?php echo formatNumber($row->target); ?></td>
			<td><?php echo $row->userid; ?></td><td><?php echo $grp->centerid; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->datekeyed); ?></td>
			<td><?php echo $row->themeid; ?></td>
			<td><?php echo $row->valuechainid; ?></td>
<?php
//Authorization.
$auth->roleid="9074";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtargets_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9075";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='targets.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
