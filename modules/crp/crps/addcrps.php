<title>CRP Indicators: Crps </title>
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
<form class="forms" id="theform" action="addcrps_proc.php" name="crps" method="POST" enctype="multipart/form-data">
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
		<td align="right">CRP No : </td>
		<td><input type="text" name="crpno" id="crpno" size="8"  value="<?php echo $obj->crpno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Crp Name : </td>
		<td><input type="text" name="crp_name" id="crp_name" value="<?php echo $obj->crp_name; ?>"></td>
	</tr>
	<tr>
		<td align="right">Category Name : </td>
		<td><input type="text" name="category" id="category" value="<?php echo $obj->category; ?>"></td>
	</tr>
	<tr>
		<td align="right">Sub Category Name : </td>
		<td><input type="text" name="subcategory" id="subcategory" value="<?php echo $obj->subcategory; ?>"></td>
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