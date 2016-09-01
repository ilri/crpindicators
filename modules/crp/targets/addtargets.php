<title>CRP Indicators: Targets </title>
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
<form class="forms" id="theform" action="addtargets_proc.php" name="targets" method="POST" enctype="multipart/form-data">
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
		<td align="right">CRP Indicator : </td>
			<td><select name="tableid" class="selectbox">
<option value="">Select...</option>
<?php
	$tables=new Tables();
	$where="  ";
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks, crp_tables.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tables->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tableid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="crpid" value="<?php echo $_SESSION['crpid'];?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">Target : </td>
		<td><input type="text" name="target" id="target" size="8"  value="<?php echo $obj->target; ?>"></td>
	</tr>
	<tr>
		<td align="right"> </td>
			<td><input type="hidden" name="userid" value="<?php echo $_SESSION['userid'];?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><select name="year" id="year" class="selectbox">
		      <option value="">Select...</option>
		      <?php
	      $i=date("Y")-10;
	      while($i<date("Y")+10)
	      {
		    ?>
		      <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		      <?
		$i++;
	      }
	      ?>
		    </select></td>
	</tr>
	<tr>
		<td align="right">Date : </td>
		<td><input type="text" name="datekeyed" id="datekeyed" class="date_input" size="12" readonly  value="<?php echo $obj->datekeyed; ?>"></td>
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