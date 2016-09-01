<title>CRP Indicators: Groups </title>
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
	<form class="forms" id="theform" action="addgroups_proc.php" name="groups" method="POST" enctype="multipart/form-data">
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
				<td align="right">Group Name : </td>
				<td><input type="text" name="group_name" id="group_name" value="<?php echo $obj->group_name; ?>"></td>
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