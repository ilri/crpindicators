<title>CRP Indicators: Crptables </title>
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
<form class="forms" id="theform" action="addcrptables_proc.php" name="crptables" method="POST" enctype="multipart/form-data">
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
		<td align="right">CRP : </td>
			<td><select name="crpid" class="selectbox">
<option value="">Select...</option>
<?php
	$crps=new Crps();
	$where="  ";
	$fields="crp_crps.id, crp_crps.crp_name name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($crps->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->crpid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Indicator : </td>
			<td><select name="tableid" class="selectbox">
<option value="">Select...</option>
<?php
	$tables=new Tables();
	$where="  ";
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tables->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tableid==$rw->id){echo "selected";}?>><?php echo substr($rw->description,0,80);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
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