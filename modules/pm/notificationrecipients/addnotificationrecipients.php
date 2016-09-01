<title>CRP Indicators: Notificationrecipients </title>
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
<form class="forms" id="theform" action="addnotificationrecipients_proc.php" name="notificationrecipients" method="POST" enctype="multipart/form-data">
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
		<td align="right">Notification : </td>
			<td><select name="notificationid" class="selectbox">
<option value="">Select...</option>
<?php
	$notifications=new Notifications();
	$where="  ";
	$fields="pm_notifications.id, pm_notifications.notificationtypeid, pm_notifications.subject, pm_notifications.body, pm_notifications.taskid, pm_notifications.ipaddress, pm_notifications.createdby, pm_notifications.createdon, pm_notifications.lasteditedby, pm_notifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($notifications->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->notificationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><select name="employeeid" class="selectbox">
<option value="">Select...</option>
<?php
	$employees=new Employees();
	$where="  ";
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($employees->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->employeeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Email : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr>
		<td align="right">Notified On : </td>
		<td><input type="text" name="notifiedon" id="notifiedon" class="date_input" size="12" readonly  value="<?php echo $obj->notifiedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Read On : </td>
		<td><input type="text" name="readon" id="readon" class="date_input" size="12" readonly  value="<?php echo $obj->readon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='unread' <?php if($obj->status=='unread'){echo"selected";}?>>unread</option>
			<option value='read' <?php if($obj->status=='read'){echo"selected";}?>>read</option>
			<option value='starred' <?php if($obj->status=='starred'){echo"selected";}?>>starred</option>
		</select></td>
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