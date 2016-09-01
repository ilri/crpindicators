<title>CRP Indicators: Notifications </title>
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
<form class="forms" id="theform" action="addnotifications_proc.php" name="notifications" method="POST" enctype="multipart/form-data">
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
		<td align="right">Notification Type : </td>
			<td><select name="notificationtypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$notificationtypes=new Notificationtypes();
	$where="  ";
	$fields="pm_notificationtypes.id, pm_notificationtypes.name, pm_notificationtypes.remarks, pm_notificationtypes.ipaddress, pm_notificationtypes.createdby, pm_notificationtypes.createdon, pm_notificationtypes.lasteditedby, pm_notificationtypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notificationtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($notificationtypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->notificationtypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Subject : </td>
		<td><textarea name="subject"><?php echo $obj->subject; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Body : </td>
		<td><textarea name="body"><?php echo $obj->body; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Task : </td>
			<td>
<?php
	$tasks=new Tasks();
	$where=" where id='$obj->taskid' ";
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.routeid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $sql;
	$tasks=$tasks->fetchObject;	
	?>
		<a href="../../pm/tasks/addtasks_proc.php?id=<?php echo $tasks->id; ?>&not=true" target="_blank"><?php echo initialCap($tasks->name);?></a>
	
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php if($ob->not!="true"){?><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<?php }?><input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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