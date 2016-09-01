<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Strategicvchainsanalysed_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../crp/tables/Tables_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Strategicvchainsanalysed";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8922";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$strategicvchainsanalysed=new Strategicvchainsanalysed();
if(!empty($delid)){
	$strategicvchainsanalysed->id=$delid;
	$strategicvchainsanalysed->delete($strategicvchainsanalysed);
	redirect("strategicvchainsanalysed.php");
}
//Authorization.
$auth->roleid="8921";//View
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
<input onclick="showPopWin('addstrategicvchainsanalysed_proc.php',600,430);" value="New" type="button"/></div>
<div class="clearb"></div>
<div class="content-flex">
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Value Chain Desc </th>
			<th>Country </th>
			<th>Region </th>
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
$auth->roleid="8923";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8924";//View
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
		$fields="crp_strategicvchainsanalysed.id, crp_strategicvchainsanalysed.value_chain_desc,crp_strategicvchainsanalysed.themeid,crp_strategicvchainsanalysed.valuechainid, crp_strategicvchainsanalysed.country, crp_strategicvchainsanalysed.region, crp_agroecologicalzones.name agroecologicalzoneid, crp_crps.crp_name as crpid, crp_strategicvchainsanalysed.rec_period, crp_strategicvchainsanalysed.crpattribution, crp_users.user_name as userid, crp_users.id user, crp_strategicvchainsanalysed.url, crp_strategicvchainsanalysed.valid_data";
		$join=" left join crp_crps on crp_strategicvchainsanalysed.crpid=crp_crps.id  left join crp_users on crp_strategicvchainsanalysed.userid=crp_users.id left join crp_agroecologicalzones on crp_agroecologicalzones.id=crp_strategicvchainsanalysed.agroecologicalzoneid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_strategicvchainsanalysed.crpid='".$_SESSION['crpid']."'";
		$strategicvchainsanalysed->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$strategicvchainsanalysed->result;
		while($row=mysql_fetch_object($res)){
		
		 $query="select crp_centers.name centerid from crp_centers left join crp_users on crp_centers.id=crp_users.centerid where crp_users.id=$row->user ";
		  
$grp=mysql_fetch_object(mysql_query($query));

$query="select group_concat(crp_groups.group_name separator '\n') grp from crp_groups left join crp_usergroup on crp_groups.id=crp_usergroup.group_id where crp_usergroup.user_id=$row->user ";

$grp1=mysql_fetch_object(mysql_query($query));
		
		 $tables = new Tables();
		  $row->tableid = $tables->getTable("strategicvchainsanalysed");
		  
		  $attribution = getCrpAttribution($row);
		   $theme = getThemes($row);
		   $vc = getValuechains($row);
		
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->value_chain_desc; ?></td>
			<td><?php echo $row->country; ?></td>
			<td><?php echo $row->region; ?></td>
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
			<td><a href="javascript:;" onclick="showPopWin('addstrategicvchainsanalysed_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}elseif(supervisor($row->user)){
?>
  <td><a href='../crp/confirm.php?id=<?php echo $row->id; ?>&valid_data=<?php echo $row->valid_data; ?>&tbl=strategicvchainsanalysed'><?php if(empty($row->valid_data)){echo "<font style='color:red;'>Validate</font>";}else{echo "Invalidate";}?></a></td>
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
			<td><a href='strategicvchainsanalysed.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
<?php
include"../../../foot.php";
?>
