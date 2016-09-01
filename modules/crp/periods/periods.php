<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Periods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Periods";
//connect to db
$db=new DB();

$ob = (object)$_GET;

if(!empty($ob->id)){
	if($ob->status=="active")
		$status="inactive";
	else
		$status="active";

	mysql_query("update crp_periods set status='$status' where id='$ob->id'");
}

//Authorization.
$auth->roleid="8959";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$periods=new Periods();
if(!empty($delid)){
	$periods->id=$delid;
	$periods->delete($periods);
	redirect("periods.php");
}
//Authorization.
$auth->roleid="8959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addperiods_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8959";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8959";//Add
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
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$periods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$periods->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		//check whether period is used
		mysql_query("select * from period_view where rec_period='$row->name'");
		$used=false;
		if(mysql_affected_rows()>0)
			$used=true;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="periods.php?id=<?php echo $row->id; ?>&status=<?php echo $row->status; ?>"><font color="<?php if($row->status=='inactive'){echo 'red';}?>"><?php echo $row->status; ?></font></a></td>
<?php
//Authorization.
$auth->roleid="8959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth) ){
	if(!$used){
?>
			<td><a href="javascript:;" onclick="showPopWin('addperiods_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
	}else{
	?>
		<td>&nbsp;</td>
	<?
	}
}
//Authorization.
$auth->roleid="8959";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
	if(!$used){
?>
			<td><a href='periods.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
<?php }else{ ?>
			<td>&nbsp;</td>
<?php }} ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
