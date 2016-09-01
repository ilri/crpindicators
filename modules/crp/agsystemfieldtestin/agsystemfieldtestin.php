<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agsystemfieldtestin_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../crp/tables/Tables_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Agsystemfieldtestin";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8866";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$agsystemfieldtestin=new Agsystemfieldtestin();
if(!empty($delid)){
	$agsystemfieldtestin->id=$delid;
	$agsystemfieldtestin->delete($agsystemfieldtestin);
	redirect("agsystemfieldtestin.php");
}
//Authorization.
$auth->roleid="8865";//View
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
<input onclick="showPopWin('addagsystemfieldtestin_proc.php',600,430);" value="New " type="button"/></div>
<div class="clearb"></div>
<div class="content-flex">
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Ecosystem Name </th>
			<th>Practice Name </th>
			<th>Country </th>
			<th>Region </th>
			<th>Decrease Inequality </th>
			<th>Publications</th>
			<th>AgroEcological Zone</th>
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
$auth->roleid="8867";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8868";//View
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
		$fields="crp_agsystemfieldtestin.id, crp_agsystemfieldtestin.ecosystem_name, crp_agsystemfieldtestin.practice_name, crp_agsystemfieldtestin.country, crp_agroecologicalzones.name agroecologicalzoneid, crp_agsystemfieldtestin.region, crp_agsystemfieldtestin.decrease_inequality, crp_agsystemfieldtestin.publications,crp_agsystemfieldtestin.themeid,crp_agsystemfieldtestin.valuechainid, crp_crps.crp_name as crpid, crp_agsystemfieldtestin.rec_period,crp_agsystemfieldtestin.crpattribution, crp_users.user_name as userid, crp_users.id user, crp_agsystemfieldtestin.url, crp_agsystemfieldtestin.valid_data";
		$join=" left join crp_crps on crp_agsystemfieldtestin.crpid=crp_crps.id  left join crp_users on crp_agsystemfieldtestin.userid=crp_users.id left join crp_agroecologicalzones on crp_agroecologicalzones.id=crp_agsystemfieldtestin.agroecologicalzoneid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_agsystemfieldtestin.crpid='".$_SESSION['crpid']."'";
		$agsystemfieldtestin->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$agsystemfieldtestin->result;
		while($row=mysql_fetch_object($res)){
		
		 $query="select crp_centers.name centerid from crp_centers left join crp_users on crp_centers.id=crp_users.centerid where crp_users.id=$row->user ";
		  
$grp=mysql_fetch_object(mysql_query($query));

$query="select group_concat(crp_groups.group_name separator '\n') grp from crp_groups left join crp_usergroup on crp_groups.id=crp_usergroup.group_id where crp_usergroup.user_id=$row->user ";

$grp1=mysql_fetch_object(mysql_query($query));
		  
		  $tables = new Tables();
		  $row->tableid = $tables->getTable("agsystemfieldtestin");
		  
		  $attribution = getCrpAttribution($row);
		  $theme = getThemes($row);
		   $vc = getValuechains($row);
		
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->ecosystem_name; ?></td>
			<td><?php echo $row->practice_name; ?></td>
			<td><?php echo $row->country; ?></td>
			<td><?php echo $row->region; ?></td>
			<td><?php echo $row->decrease_inequality; ?></td>
			<td><?php echo $row->publications; ?></td>
			<td><?php echo $row->agroecologicalzoneid; ?>
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
			<td><a href="javascript:;" onclick="showPopWin('addagsystemfieldtestin_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}elseif(supervisor($row->user)){
?>
  <td><a href='../crp/confirm.php?id=<?php echo $row->id; ?>&valid_data=<?php echo $row->valid_data; ?>&tbl=agsystemfieldtestin'><?php if(empty($row->valid_data)){echo "<font style='color:red;'>Validate</font>";}else{echo "Invalidate";}?></a></td>
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
			<td><a href='gsystemfieldtestin.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
