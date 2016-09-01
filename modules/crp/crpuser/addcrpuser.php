<title>CRP Indicators: Crpuser </title>
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
<form class="forms" id="theform" action="addcrpuser_proc.php" name="crpuser" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	
		<tr>
		<td align="right">Crpid :<input type="hidden" name="id" value="<?php echo $obj->id; ?>"/> </td>
			<td><select name="crp_id" class="selectbox">
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
		<option value="<?php echo $rw->id; ?>" <?php if($obj->crp_id==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Userid: </td>
			<td><select name="userid" class="selectbox">
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
		<option value="<?php echo $rw->id; ?>" <?php if($obj->userid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	
	
	<tr>
		<td align="right">Join Date : </td>
		<td><input type="text" name="join_date" id="join_date" class="date_input" size="12" readonly  value="<?php echo $obj->join_date; ?>"></td>
	</tr>
	<tr>
		<td align="right">Supervisor : </td>
		<td><input type="radio" name="supervisor" value="1" <?php if($obj->supervisor==1){echo"checked";}?> />Yes<br/>
		<input type="radio" name="supervisor" value="0" <?php if($obj->supervisor==0){echo"checked";}?> />No
		</td>
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