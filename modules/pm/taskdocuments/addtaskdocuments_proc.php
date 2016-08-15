<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/tasks/Tasks_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8353";//Edit
}
else{
	$auth->roleid="8351";//Add
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
	$taskdocuments=new Taskdocuments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$taskdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskdocuments=$taskdocuments->setObject($obj);
		if($taskdocuments->add($taskdocuments)){
			$error=SUCCESS;
			redirect("addtaskdocuments_proc.php?id=".$taskdocuments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$taskdocuments=new Taskdocuments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$taskdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskdocuments=$taskdocuments->setObject($obj);
		if($taskdocuments->edit($taskdocuments)){
			$error=UPDATESUCCESS;
			redirect("addtaskdocuments_proc.php?id=".$taskdocuments->id."&error=".$error);
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


	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$taskdocuments=new Taskdocuments();
	$where=" where id=$id ";
	$fields="pm_taskdocuments.id, pm_taskdocuments.title, pm_taskdocuments.taskid, pm_taskdocuments.documenttypeid, pm_taskdocuments.file, pm_taskdocuments.remarks, pm_taskdocuments.ipaddress, pm_taskdocuments.createdby, pm_taskdocuments.createdon, pm_taskdocuments.lasteditedby, pm_taskdocuments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$taskdocuments->fetchObject;

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
	
	
$page_title="Taskdocuments ";
include "addtaskdocuments.php";
?>