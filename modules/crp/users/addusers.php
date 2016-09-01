<title>CRP Indicators: Users </title>
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
<form class="forms" id="theform" action="addusers_proc.php" name="users" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Name :<input type="hidden" name="editing" id="editing" value="<?php echo $obj->editing; ?>"/> </td>
		<td><input type="text" name="user_name" id="user_name" value="<?php echo $obj->user_name; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Username : </td>
		<td><input type="text" name="user_login" id="user_login" value="<?php echo $obj->user_login; ?>"></td>
	</tr>
	<?php if($_SESSION['user_isadmin']!=1){?>
	<tr>
		<td align="right">Old Password : </td>
		<td><input type="password" name="user_opass" id="user_opass"></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right">New Password : </td>
		<td><input type="password" name="user_pass" id="user_pass"></td>
	</tr>
	<?php if($_SESSION['user_isadmin']!=1){?>
	<tr>
		<td align="right">Confirm Password : </td>
		<td><input type="password" name="user_cpass" id="user_cpass"></td>
	</tr>
	<?php }?>
	<tr>
		<td align="right">Email : </td>
		<td><input type="text" name="user_email" id="user_email" value="<?php echo $obj->user_email; ?>"></td>
	</tr>
	<?php if($_SESSION['user_isadmin']==1){?>
	<tr>
		<td align="right">Is admin? </td>
		<td><input type="checkbox" name="user_isadmin" id="user_isadmin" value="1" <?php if($obj->user_isadmin==1){echo"checked";}?>/></td>
	</tr>
	
	<tr>
		<td align="right">Center : </td>
			<td><select name="centerid" class="selectbox">
<option value="">Select...</option>
<?php
	$centers=new Centers();
	$where="  ";
	$fields="crp_centers.id, crp_centers.name, crp_centers.remarks, crp_centers.ipaddress, crp_centers.createdby, crp_centers.createdon, crp_centers.lasteditedby, crp_centers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$centers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($centers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->centerid==$rw->id){echo "selected";}?>><?php echo $rw->name;?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<?php }else{?>
	<tr>
	  <td><input type="hidden" name="user_isadmin" value="<?php echo $obj->user_isadmin; ?>"/></td>
	  <td><input type="hidden" name="centerid" value="<?php echo $obj->centerid; ?>"/></td>
	</tr>
	<?php }?>
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