<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crp_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Crp";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8874";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$crp=new Crp();
if(!empty($delid)){
	$crp->id=$delid;
	$crp->delete($crp);
	redirect("crp.php");
}
//Authorization.
$auth->roleid="8873";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcrp_proc.php',600,430);" value="Add Crp " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8875";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8876";//View
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
		$fields="crp_crp.id, crp_crp.crp_name";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_crp.crpid='".$_SESSION['crpid']."'";
		$crp->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$crp->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->crp_name; ?></td>
<?php
//Authorization.
$auth->roleid="8899";//View
$auth->levelid=$_SESSION['level'];

if(checkRule($row->id,strtolower($page_title))){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcrp_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}elseif(supervisor($row->user)){
?>
  <td><a href=''>Confirm</a></td>
<?php
}else{
  ?>
  <td>&nbsp;</td>
  <?
}
//Authorization.
$auth->roleid="8900";//View
$auth->levelid=$_SESSION['level'];

if(checkRule($row->id,strtolower($page_title))){
?>
			<td><a href='crp.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php }else{
  ?>
  <td>&nbsp;</td>
  <?
} ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
