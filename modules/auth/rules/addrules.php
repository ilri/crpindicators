<title>WiseDigits: Rules </title>
<?php 
include "../../../headerpop.php";

?>
<form action="addrules_proc.php" name="rules" method="POST" class="forms" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Level : </td>
			<td><select name="levelid">
<option value="">Select...</option>
<?php
	$levels=new Levels();
	$where="  ";
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($levels->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->levelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Role : </td>
			<td><select name="roleid">
<option value="">Select...</option>
<?php
	$roles=new Roles();
	$where=" where auth_roles.moduleid=9 ";
	$fields="auth_roles.id, auth_roles.name, auth_roles.moduleid, auth_roles.module, auth_roles.createdby, auth_roles.createdon, auth_roles.lasteditedby, auth_roles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $roles->sql;

	while($rw=mysql_fetch_object($roles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->roleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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