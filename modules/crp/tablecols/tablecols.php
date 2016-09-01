<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tablecols_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tablecols";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9309";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tablecols=new Tablecols();
if(!empty($delid)){
	$tablecols->id=$delid;
	$tablecols->delete($tablecols);
	redirect("tablecols.php");
}
//Authorization.
$auth->roleid="9308";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtablecols_proc.php',600,430);" value="Add Tablecols " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Indicator </th>
			<th>Column Name </th>
<?php
//Authorization.
$auth->roleid="9310";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9311";//Add
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
		$fields="crp_tablecols.id, crp_tables.name as tableid, crp_tablecols.name";
		$join=" left join crp_tables on crp_tablecols.tableid=crp_tables.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tablecols->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tablecols->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tableid; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="9310";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtablecols_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9311";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tablecols.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
