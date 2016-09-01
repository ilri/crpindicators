<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Themes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Themes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9111";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$themes=new Themes();
if(!empty($delid)){
	$themes->id=$delid;
	$themes->delete($themes);
	redirect("themes.php");
}
//Authorization.
$auth->roleid="9110";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addthemes_proc.php',600,430);" value="Add" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>CRP </th>
			<th>Status</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9112";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9113";//View
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
		$fields="crp_themes.id, crp_themes.name, concat(crp_crps.crpno,' ',crp_crps.crp_name) as crpid, crp_themes.status, crp_themes.remarks, crp_themes.ipaddress, crp_themes.createdby, crp_themes.createdon, crp_themes.lasteditedby, crp_themes.lasteditedon";
		$join=" left join crp_crps on crp_themes.crpid=crp_crps.id ";
		$having="";
		$groupby="";
		$orderby=" order by crpid, name";
		$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$themes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->crpid; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9112";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addthemes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9113";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='themes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
