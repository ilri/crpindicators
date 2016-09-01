<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Policies_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../crp/tables/Tables_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Policies";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8906";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$policies=new Policies();
if(!empty($delid)){
	$policies->id=$delid;
	$policies->delete($policies);
	redirect("policies.php");
}
//Authorization.
$auth->roleid="8905";//View
$auth->levelid=$_SESSION['level'];

$tables = retrieveTables(strtolower($page_title));

if(existsRule($auth)){
?>
<div class="content">
<h4><?php echo $tables->description; ?></h4>
<div style="float:left;" class="buttons">
<div class="clear:both;"></div>
<div style="border: 1px solid #CCC;">
<p><?php 
echo $tables->remarks;
?></p>
</div>
</div>
<div class="clearb"></div>
<input onclick="showPopWin('addpolicies_proc.php',600,430);" value="New " type="button"/></div>
<?php }?>
<div class="clearb"></div>
<div class="content-flex">
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Policy Name </th>
			<th>Policy Type </th>
			<th>Country </th>
			<th>Analysed? </th>
			<th>Presented for Consultation? </th>
			<th>Presented for Legislation? </th>
			<th>Approved? </th>
			<th>Implemented? </th>
			<th>URL </th>
			<th>% CRP Attribution</th>
			<?php
			$crp=mysql_fetch_object(mysql_query("select * from crp_crps where id='".$_SESSION['crpid']."'"));?>
			<th><?php echo $crp->category; ?></th>
			<th><?php echo $crp->subcategory; ?></th>			
			<th>User </th>
			<th>User Center </th>
			<th>User Group</th>
			
<?php
//Authorization.
$auth->roleid="8907";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8908";//View
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
		$fields="crp_policies.id, crp_policies.policy_name,crp_policies.themeid,crp_policies.valuechainid,crp_policies.policy_type, crp_policies.country, case when crp_policies.analysed=1 then 'Yes' else 'No' end analysed, case when crp_policies.presented_consult=1 then 'Yes' else 'No' end presented_consult, case when crp_policies.presented_legislation=1 then 'Yes' else 'No' end presented_legislation, case when crp_policies.approved=1 then 'Yes' else 'No' end approved, case when crp_policies.implemented=1 then 'Yes' else 'No' end implemented, crp_crps.crp_name as crpid, crp_policies.rec_period, crp_agroecologicalzones.name agroecologicalzoneid, crp_policies.crpattribution, crp_users.user_name as userid, crp_users.id user, crp_policies.url, crp_policies.valid_data";
		$join=" left join crp_crps on crp_policies.crpid=crp_crps.id  left join crp_users on crp_policies.userid=crp_users.id left join crp_agroecologicalzones on crp_agroecologicalzones.id=crp_policies.agroecologicalzoneid";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_policies.crpid='".$_SESSION['crpid']."'";
		$policies->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$policies->result;
		while($row=mysql_fetch_object($res)){
		
		 $query="select crp_centers.name centerid from crp_centers left join crp_users on crp_centers.id=crp_users.centerid where crp_users.id=$row->user ";
		  
$grp=mysql_fetch_object(mysql_query($query));

$query="select group_concat(crp_groups.group_name separator '\n') grp from crp_groups left join crp_usergroup on crp_groups.id=crp_usergroup.group_id where crp_usergroup.user_id=$row->user ";

$grp1=mysql_fetch_object(mysql_query($query));
		  
		   $tables = new Tables();
		  $row->tableid = $tables->getTable("policies");
		  
		  $attribution = getCrpAttribution($row);
		   $theme = getThemes($row);
		   $vc = getValuechains($row);
		
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->policy_name; ?></td>
			<td><?php echo $row->policy_type; ?></td>
			<td><?php echo $row->country; ?></td>
			<td><?php echo $row->analysed; ?></td>
			<td><?php echo $row->presented_consult; ?></td>
			<td><?php echo $row->presented_legislation; ?></td>
			<td><?php echo $row->approved; ?></td>
			<td><?php echo $row->implemented; ?></td>
			<td><?php echo $row->url; ?></td>
			<td><?php echo $attribution; ?></td>
			<td><?php echo $theme; ?></td>
			<td><?php echo $vc; ?></td>			
			<td><?php echo $row->userid; ?></td>
			<td><?php echo $grp->centerid; ?></td>
			<td><?php echo $grp1->grp; ?></td>
			
		
<?php
//Authorization.
$auth->roleid="8899";//View
$auth->levelid=$_SESSION['level'];

if(checkRule($row->id,strtolower($page_title))){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpolicies_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}elseif(supervisor($row->user)){
?>
  <td><a href='../crp/confirm.php?id=<?php echo $row->id; ?>&valid_data=<?php echo $row->valid_data; ?>&tbl=policies'><?php if(empty($row->valid_data)){echo "<font style='color:red;'>Validate</font>";}else{echo "Invalidate";}?></a></td>
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
			<td><a href='policies.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php }else{
  ?>
  <td>&nbsp;</td>
  <?
} ?>
		</tr>
	<?php 
	}
	?>
	</tbody>openaccesdtbs
</table>
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
<?php
include"../../../foot.php";
?>
