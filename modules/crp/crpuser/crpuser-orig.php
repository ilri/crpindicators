<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crpuser_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Crpuser";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8878";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$crpuser=new Crpuser();
if(!empty($delid)){
	$crpuser->id=$delid;
	$crpuser->delete($crpuser);
	redirect("crpuser.php");
}
//Authorization.
$auth->roleid="8877";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="content">
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcrpuser_proc.php',600,430);" value="Add Crpuser " type="button"/></div>
<div class="clearb"></div>
<div class="content-flex">
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Crp Id </th>
			<th>Userid </th>
<th>Center </th>
			<th>Join Date </th>
			<th>Supervisor </th>
<?php
//Authorization.
$auth->roleid="8879";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8880";//View
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
		$fields="crp_crpuser.id, crp_crps.crp_name crp_id, crp_users.user_name userid, crp_crpuser.join_date, case when crp_crpuser.supervisor=1 then 'Yes' when crp_crpuser.supervisor=0 then 'No' end supervisor";
		$join=" left join crp_crps on crp_crps.id=crp_crpuser.crp_id left join crp_users on crp_users.id=crp_crpuser.userid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		$crpuser->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$crpuser->result;echo mysql_error();
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->crp_id; ?></td>
			<td><?php echo $row->userid; ?></td><td><?php echo $grp->centerid; ?></td>
			<td><?php echo formatDate($row->join_date); ?></td>
			<td><?php echo $row->supervisor; ?></td>
<?php
//Authorization.
$auth->roleid="8879";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcrpuser_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8880";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='crpuser.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
