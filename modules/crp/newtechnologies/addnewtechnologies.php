<title><?php echo $_SESSION['system']?>: 
<?php
require_once("../tables/Tables_class.php"); 
$tables = new Tables();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where name='".strtolower($page_title)."'";
$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$tables = $tables->fetchObject;
echo $tables->description;

?></title>
<?php 
//include "../../../headerpop.php";

?>
 <script type="text/javascript" charset="utf-8">

 
 $(document).ready(function(){
  $("#action").on("click",function(){
    //var counter = 1;//tbl.fnGetData().length;
	var st = $("#theform").serialize()+"&action="+$("#action").val();
	$.post("addnewtechnologies_proc.php", st, function( data ) {
	  alert( "Success"+data );
	});
	var cnt;
	cnt = counter-1;
	if($("#action").val()=="Update"){
	
	  tbl.row(cnt).remove().draw( false );
	  $("#close").click();
	}
	
	tbl.row.add( [
		cnt,
		$("#technology_name").val(),
		$("#country").val(),
		$("#region").val(),
		$("#location").val(),
		$("#number_women").val(),
		$("#number_men").val(),
		$("#newtech").val(),
		counter+".3",
		counter+".3",
		counter+".3",
		$("#url").val(),
		'<a data-label='+counter+' data-toggle="modal" id="<?php echo $row->id; ?>" class="btn popup" data-id="<?php echo $row->id; ?>" href="#helpModal">View</a>',
		"<a href='newtechnologies.php?delid=<?php echo $row->id; ?>' onclick='return confirm(&quot;Are you sure you want to delete?&quot;)'>Delete</a>"] ).draw();	
	
	$("#new").show();
	$("#action").val("Update");
	
  })
 })
 </script>

<div class='main'>
<form class="forms" id="theform" action="addnewtechnologies_proc.php" name="newtechnologies" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right" width="50%">Enter the name of the new technology applied by farmers/others as a result of CRP : </td>
		<td><textarea name="technology_name" id="technology_name"><?php echo $obj->technology_name; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Country : </td>
		<td><select name="country" id="country" >
		<option value="">Select...</option>
		</select>
		</td>
	</tr>
	<tr>
		<td align="right">Region : </td>
		<td><select name="region" id="region" >
		<option value="">Select...</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Location : </td>
		<td><input type="text" name="location" id="location" value="<?php echo $obj->location; ?>"></td>
	</tr>
	<tr>
		<td align="right">Number of farmers and others who have applied new technologies or management practices as a result of CRP research (female) : </td>
		<td><input type="text" name="number_women" id="number_women" value="<?php echo $obj->number_women; ?>"></td>
	</tr>
	<tr>
		<td align="right">Number of farmers and others who have applied new technologies or management practices as a result of CRP research (male): </td>
		<td><input type="text" name="number_men" id="number_men" value="<?php echo $obj->number_men; ?>"></td>
	</tr>
	<tr>
		<td align="right">Newtech : </td>
		<td><input type="checkbox" name="newtech" id="newtech" value="1" <?php if($obj->newtech==1){echo"checked";}; ?>/></td>
	</tr>
	<tr>
		<td align="right">AgroEcological Zone : </td>
		<td>
		<select name="agroecologicalzoneid" class="select-box">
		  <option value="">Select...</option>
		  <?php
		   $agroecologicalzones = new AgroEcologicalzones();
		   $fields="*";
		   $where="";
		   $having="";
		   $orderby="";
		   $groupby="";
		   $join="";
		   $agroecologicalzones->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		   while($row=mysql_fetch_object($agroecologicalzones->result)){
		    ?>
		      <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->agroecologicalzoneid){echo"selected";}?>><?php echo $row->name; ?></option>
		    <?php
		   }
		  ?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="crpid" value="<?php echo $_SESSION['crpid'];?>"/>
		</td>
	</tr>
	<tr>
		<td align="right"></td>
		<td><input type="hidden" readonly name="rec_period" id="rec_period" value="<?php echo $_SESSION['rec_period']; ?>"></td>
	</tr>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="userid" value="<?php echo $_SESSION['userid'];?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">URL : </td>
		<td><textarea name="url" id="url"><?php echo $obj->url; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">  </td>
		<td><input type="hidden" name="valid_data" id="valid_data" value="<?php echo $obj->valid_data; ?>"></td>
	</tr>
	<?php
	$crps = new Crps();
	$fields="*";
	$where=" where id='".$_SESSION['crpid']."'";
	$groupby="";
	$having="";
	$orderby="";
	$join="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$crps = $crps->fetchObject;
	
	$themes=new Themes();
	$where=" where crp_themes.crpid='$crps->id' and status='active' ";
	$fields="crp_themes.id, crp_themes.name, crp_themes.remarks, crp_themes.ipaddress, crp_themes.createdby, crp_themes.createdon, crp_themes.lasteditedby, crp_themes.lasteditedon";
	$join="  ";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	if($themes->affectedRows>0){
	?>
	<tr>
		<td align="right" valign="top"><?php echo $crps->category; ?> : </td>
			<td>
<?php
	

	while($rw=mysql_fetch_object($themes->result)){
	?>
		<input type="checkbox" name="theme<?php echo $rw->id; ?>" value="1" <?php if($_POST['theme'.$rw->id]){echo "checked";}?>/>&nbsp;<?php echo initialCap($rw->name);?><br/>
	<?php
	}
	?>
		</td>
	</tr>
	<?php
	}
	
	$valuechains=new Valuechains();
	$where=" where crp_valuechains.crpid='$crps->id' ";
	$fields="crp_valuechains.id, crp_valuechains.name, crp_valuechains.remarks, crp_valuechains.ipaddress, crp_valuechains.createdby, crp_valuechains.createdon, crp_valuechains.lasteditedby, crp_valuechains.lasteditedon";
	$join=" ";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	if($valuechains->affectedRows>0){
	?>
	<tr>
		<td align="right" valign="top"><?php echo $crps->subcategory; ?> : </td>
			<td>
			<?php
			
			
	while($rw=mysql_fetch_object($valuechains->result)){
	?>
		<input type="checkbox" name="valuechain<?php echo $rw->id; ?>" value="1" <?php if($_POST['valuechain'.$rw->id]){echo "checked";}?>/>&nbsp;<?php echo initialCap($rw->name);?><br/>
	<?php
	}
	?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
	<td colspan='2' align='center'>% CRP Attribution<input type="hidden" name="crpattribution" value='<?php echo $obj->crpattribution; ?>'/></td>
	</tr>
	<?php
	
	$crps = new Crps();
	$fields="*";
	$where="";
	$groupby="";
	$having="";
	$orderby="";
	$join="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($crps->result)){
	$id="";
	$id=$row->id;
	if(!$obj->crpattribution){
	  
	   if($row->id==$_SESSION['crpid'])
	    $obj->$id="100";
	   else
	    $obj->$id="0";
	}
	  ?>
	   <tr>
	    <td align="right"><?php echo $row->crp_name; ?></td>
	    <td><input type="text" name="<?php echo $row->id; ?>" size="2" value="<?php echo $obj->$id; ?>"/>%
	   </tr>
	  <?php
	}
	?>
	
	<tr>
		<td colspan="2" align="center"><input type="button" name="action" id="action" class="btn btn-default" value="<?php echo $obj->action; ?>"></td>
	</tr>
<?php if($error=="SUCCESS"){?>
<script>
  
</script>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>