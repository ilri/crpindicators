<title>CRP Indicators: Groupvaluechains </title>
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
<form class="forms" id="theform" action="addgroupvaluechains_proc.php" name="groupvaluechains" method="POST" enctype="multipart/form-data">
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
		<td align="right">Group : </td>
			<td><select name="groupid" class="selectbox">
<option value="">Select...</option>
<?php
	$groups=new Groups();
	$where="  ";
	$fields="crp_groups.id, crp_groups.group_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($groups->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->groupid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Value Chain : </td>
			<td><select name="valuechainid" class="selectbox">
<option value="">Select...</option>
<?php
	$valuechains=new Valuechains();
	$where="  ";
	$fields="crp_valuechains.id, crp_valuechains.name, crp_valuechains.remarks, crp_valuechains.ipaddress, crp_valuechains.createdby, crp_valuechains.createdon, crp_valuechains.lasteditedby, crp_valuechains.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($valuechains->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->valuechainid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
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