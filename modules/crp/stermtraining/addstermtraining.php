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

?></title> </title>
<?php 
include "../../../headerpop.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

<div class='main'>
<form class="forms" id="theform" action="addstermtraining_proc.php" name="stermtraining" method="POST" enctype="multipart/form-data">
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
		<td align="right" width="50%">Training Subject Matter : </td>
		<td><textarea name="short_training_name" id="short_training_name"><?php echo $obj->short_training_name; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Location : </td>
		<td><input type="text" name="location" id="location" value="<?php echo $obj->location; ?>"></td>
	</tr>
	<tr>
		<td align="right">Men Number : </td>
		<td><input type="text" name="men_number" id="men_number" value="<?php echo $obj->men_number; ?>"></td>
	</tr>
	<tr>
		<td align="right">Women Number : </td>
		<td><input type="text" name="women_number" id="women_number" value="<?php echo $obj->women_number; ?>"></td>
	</tr>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="crpid" value="<?php echo $_SESSION['crpid'];?>"/>
		</td>
	</tr>

	
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" readonly name="rec_period" id="rec_period" value="<?php echo $_SESSION['rec_period']; ?>"></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td><input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>"></td>
	</tr>
	<tr>
		<td align="right">URL : </td>
	<td><textarea name="url" id="url"><?php echo $obj->url; ?></textarea></td>
	</tr>
	<tr>
		<td align="right"> </td>
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
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
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