<title>CRP Indicators: Usergroup </title>
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
<form class="forms" id="theform" action="addusergroup_proc.php" name="usergroup" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right">User Id : </td>
		<td><select name="user_id" class="selectbox">
<option value="">Select...</option>
<?php
	$users=new Users();
	$where="  ";
	$fields="crp_users.id, crp_users.user_name name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($users->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->user_id==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Group Id : </td>
		<td><select name="group_id" class="selectbox">
<option value="">Select...</option>
<?php
	$groups=new Groups();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($groups->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->group_id==$rw->id){echo "selected";}?>><?php echo initialCap($rw->group_name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Join Date : </td>
		<td><input type="text" name="join_date" id="join_date" class="date_input" size="12" readonly  value="<?php echo $obj->join_date; ?>"></td>
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