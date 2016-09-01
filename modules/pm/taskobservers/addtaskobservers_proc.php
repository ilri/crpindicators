<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskobservers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/tasks/Tasks_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8221";//Edit
}
else{
	$auth->roleid="8219";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$taskobservers=new Taskobservers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$taskobservers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskobservers=$taskobservers->setObject($obj);
		if($taskobservers->add($taskobservers)){
			$error=SUCCESS;
			redirect("addtaskobservers_proc.php?id=".$taskobservers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$taskobservers=new Taskobservers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$taskobservers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskobservers=$taskobservers->setObject($obj);
		if($taskobservers->edit($taskobservers)){
			$error=UPDATESUCCESS;
			redirect("addtaskobservers_proc.php?id=".$taskobservers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tasks= new Tasks();
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.status, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$taskobservers=new Taskobservers();
	$where=" where id=$id ";
	$fields="pm_taskobservers.id, pm_taskobservers.taskid, pm_taskobservers.employeeid, pm_taskobservers.description, pm_taskobservers.remarks, pm_taskobservers.ipaddress, pm_taskobservers.createdby, pm_taskobservers.createdon, pm_taskobservers.lasteditedby, pm_taskobservers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskobservers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$taskobservers->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Taskobservers ";
include "addtaskobservers.php";
?>