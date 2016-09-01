<title>WiseDigits: Levels </title>
<?php 
include "../../../headerpop.php";

?>
<form action="addlevels_proc.php" name="levels" method="POST" class="forms" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<td colspan="2" align="center">
		</td>
	</tr>
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>