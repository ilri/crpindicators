<title>CRP Indicators: Tasks </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
 $("#employeenames").autocomplete("../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))", {
 	width: 260,
 	selectFirst: false
 });
 $("#employeenames").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("employeenames").value=data[0];
     document.getElementById("employeeids").value=data[1];
   }
 });
 $("#assignmentname").autocomplete("../../../modules/server/server/search.php?main=hrm&module=assignments&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#assignmentname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("assignmentname").value=data[0];
     document.getElementById("assignmentid").value=data[1];
   }
 });
});
<?php include'js.php'; ?>
</script>
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
<form class="forms" id="theform" action="addtasks_proc.php" name="tasks" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<thead>
	
	</thead>
	<tbody>
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Task Name : </td>
		<td><?php echo $obj->name; ?></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Task Description : </td>
		<td><?php echo $obj->description; ?></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Project : </td>
		<td><?php echo $obj->projectname; ?></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Route : </td>
			<td><?php echo $obj->routename; ?></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Project Type : </td>
		<td><?php echo $obj->projecttype; ?></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Responsible Person : </td>
			<td><?php echo $obj->employeename; ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Assignment : </td>
			<td><?php echo $obj->assignmentname; ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">HR Level : </td>
			<td><?php echo $obj->levelname; ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Document Type : </td>
		<?php
		switch($obj->documenttype){
		    case "Requisition":
			$href="../../proc/requisitions/addrequisitions.php?retrieve=1&documentno=".$obj->documentno;
		}
		?>
		<td><a href="<?php echo $href; ?>" target="_blank"><?php echo $obj->documenttype; ?>&nbsp; #<?php echo $obj->documentno; ?></a></td>
	</tr>
	<tr>
		<td align="right" style="font-weight:bold;">Priority : </td>
		<td><?php echo $obj->priority; ?></td>
	</tr>
	<?php if($obj->statusid>1){?>
	<tr>
	  <td align="right" style="font-weight:bold;">Remarks</td>
	  <td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea>
	</tr>
	<?php }?>
	
	<tr>
		<td colspan="2" align="center">
		<?php if($obj->statusid<3){?>
		<input type="submit" class="btn btn-warning" name="actions" id="actions" value="Start">&nbsp;
		<input type="submit" class="btn btn-primary" name="actions" id="actions" value="Delegate">&nbsp;
		<input type="submit" class="btn btn-success" name="actions" id="actions" value="Push Up to Supervisor">&nbsp;
		<?php }else{?>
		<?if($obj->statusid<5 and $obj->routeid>0){?>
		<input type="submit" class="btn btn-success" name="actions" id="actions" value="Approve">&nbsp;
		<input type="submit" class="btn btn-danger" name="actions" id="actions" value="Decline">&nbsp;
		<?php }else{
		if($obj->statusid<8){?>
		<input type="submit" class="btn btn-warning" name="actions" id="actions" value="Finish">
		<?php
		}
		}
		}
		?>
		</td>
	</tr>
	<tr class="yellow">
	  <td colspan="2" align="center">
	    <input type="text" name="employeenames" id="employeenames" value="<?php echo $obj->employeenames; ?>"/>
	    <input type="text" name="employeeids" id="employeeids" value="<?php echo $obj->employeeids; ?>"/>
	  </td>
	</tr>
	
	<tr>
	  <td colspan='2'>
	    <table align="center">
	    <tr>
	      <td>Start</td>
	      </tr>
	      <?php
	      //retrieve task statuss
	      $tasktracks = new Tasktracks();
	      $fields="pm_taskstatuss.name statusid, hrm_assignments.name assignmentid, pm_tasktracks.changedon";
	      $where=" where pm_tasktracks.origtask='$obj->origtask' ";
	      $join=" left join pm_tasks on pm_tasks.id=pm_tasktracks.taskid left join pm_taskstatuss on pm_taskstatuss.id=pm_tasktracks.statusid left join hrm_assignments on hrm_assignments.id=pm_tasks.assignmentid ";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $tasktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      while($row=mysql_fetch_object($tasktracks->result)){
	      ?>
	      <tr>
		<td>--><?php echo $row->statusid; ?> by <?php echo $row->assignmentid; ?> on <?php echo $row->changedon; ?></td>
		</tr>
	      <?
	      }
	      ?>
	    </ul>
	  </td>
	</tr>
	
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</tbody>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>