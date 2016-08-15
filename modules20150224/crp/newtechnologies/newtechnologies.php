<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Newtechnologies_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Newtechnologies";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8898";//View
$auth->levelid=$_SESSION['level'];

include"../../../head.php";

$delid=$_GET['delid'];
$newtechnologies=new Newtechnologies();
if(!empty($delid)){
	$newtechnologies->id=$delid;
	$newtechnologies->delete($newtechnologies);
	redirect("newtechnologies.php");
}
//Authorization.
$auth->roleid="8897";//View
$auth->levelid=$_SESSION['level'];

$tables = retrieveTables(strtolower($page_title));

if(existsRule($auth)){
?>
<script>
var id=null;
var counter;

$(document).ready(function(){
  
  $(".popup").on("click",function(){
//    $("#id").val($(this).data("id"));

    id=this.id;
    var label = $(this).data("label");
    
    //do an ajax call to retrieve selected id item
    //$.post( "../../set.php", { id: this.id, name:'newtechnologiesid'} );
    $("#item_id").load("addnewtechnologies_proc.php?id="+id);
    if(id==''){
      $("#action").val("Save");
      counter = $("#example tr").length;
    }
    else{
      $("#action").val("Update");
      
	counter = label;
    }
    
  });
  
  });
  
</script>

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
<!-- <input onclick="showPopWin('addnewtechnologies_proc.php',600,430,returnRefresh);" value="New" type="button"/> -->
<a data-toggle="modal" class="btn popup" href="#helpModal">New</a> 

<div class="content-flex">
<?php }?>
<!-- <button id="addRow" value="New">Add new row</button><input type="text" name="test" id="test" value="Test"/> -->
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Technology Name </th>
			<th>Country </th>
			<th>Region </th>
			<th>Location </th>
			<th>Number Women </th>
			<th>Number Men </th>
			<th>Newtech </th>
			<th>AgroEcological Zone</th>
			<th>URL </th>
			<th>% CRP Attribution </th>
			<?php
			$crp=mysql_fetch_object(mysql_query("select * from crp_crps where id='".$_SESSION['crpid']."'"));?>
			<th><?php echo $crp->category; ?></th>
			<th><?php echo $crp->subcategory; ?></th>			
			<th>User </th>
			<th>User Center </th>
			<th>User Group</th>
			
<?php
//Authorization.
$auth->roleid="8899";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8900";//View
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
		$fields="crp_newtechnologies.id, crp_newtechnologies.technology_name,crp_newtechnologies.themeid,crp_newtechnologies.valuechainid, crp_newtechnologies.country, crp_newtechnologies.region, crp_agroecologicalzones.name agroecologicalzoneid crp_newtechnologies.crpattribution, crp_newtechnologies.location, crp_newtechnologies.number_women, crp_newtechnologies.number_men, case when crp_newtechnologies.newtech=1 then 'Yes' else 'No' end newtech, crp_crps.crp_name as crpid, crp_newtechnologies.rec_period, crp_users.id user, crp_users.user_name as userid, crp_users.id user, crp_newtechnologies.url, crp_newtechnologies.valid_data";
		$join=" left join crp_crps on crp_newtechnologies.crpid=crp_crps.id  left join crp_users on crp_newtechnologies.userid=crp_users.id left join crp_agroecologicalzones on crp_agroecologicalzones.id=crp_newtechnologies.agroecologicalzoneid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where crp_newtechnologies.crpid='".$_SESSION['crpid']."'";
		$newtechnologies->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$newtechnologies->result;
		while($row=mysql_fetch_object($res)){
		
		$query="select crp_centers.name centerid from crp_centers left join crp_users on crp_centers.id=crp_users.centerid where crp_users.id=$row->user ";
		  
$grp=mysql_fetch_object(mysql_query($query));

$query="select group_concat(crp_groups.group_name separator '\n') grp from crp_groups left join crp_usergroup on crp_groups.id=crp_usergroup.group_id where crp_usergroup.user_id=$row->user ";

$grp1=mysql_fetch_object(mysql_query($query));
		  
		  $tables = new Tables();
		  $row->tableid = $tables->getTable("newtechnologies");
		  
		  $attribution = getCrpAttribution($row);
		   $theme = getThemes($row);
		   $vc = getValuechains($row);
		
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->technology_name; ?></td>
			<td><?php echo $row->country; ?></td>
			<td><?php echo $row->region; ?></td>
			<td><?php echo $row->location; ?></td>
			<td><?php echo $row->number_women; ?></td>
			<td><?php echo $row->number_men; ?></td>
			<td><?php echo $row->newtech; ?></td>
			<td><?php echo $row->agroecologicalzoneid; ?></td>
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
			<td><a data-label="<?php echo $i; ?>" data-toggle="modal" id="<?php echo $row->id; ?>" class="btn popup" data-id="<?php echo $row->id; ?>" href="#helpModal">View</a></td>
<!-- <td><a href="javascript:;" onclick="showPopWin('addnewtechnologies_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td> -->
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
			<td><a href='newtechnologies.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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

<div id="helpModal" class="modal fade">
      <div class="modal-dialog">
      
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $tables->description; ?></h4>
          </div>
          <div class="modal-body">
          <div id="item_id"></div>
            
          </div>
          <div class="modal-footer">
          <div>
          
            <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
           
           <button style="display:none;" id="new" type="button" class="btn btn-default" >New</button>
           </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->
    <div style="clear:both;"></div>
<?php

if($error=="SUCCESS"){
  echo "Haiya";
}

include"../../../foot.php";
?>
