<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tasktracks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/tasks/Tasks_class.php");
require_once("../../pm/statuss/Statuss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8395";//Edit
}
else{
	$auth->roleid="8395";//Add
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
	$tasktracks=new Tasktracks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tasktracks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasktracks=$tasktracks->setObject($obj);
		if($tasktracks->add($tasktracks)){
			$error=SUCCESS;
			redirect("addtasktracks_proc.php?id=".$tasktracks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tasktracks=new Tasktracks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tasktracks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasktracks=$tasktracks->setObject($obj);
		if($tasktracks->edit($tasktracks)){
			$error=UPDATESUCCESS;
			redirect("addtasktracks_proc.php?id=".$tasktracks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tasks= new Tasks();
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.routeid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$statuss= new Statuss();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tasktracks=new Tasktracks();
	$where=" where id=$id ";
	$fields="pm_tasktracks.id, pm_tasktracks.taskid, pm_tasktracks.statusid, pm_tasktracks.changedon, pm_tasktracks.remarks, pm_tasktracks.ipaddress, pm_tasktracks.createdby, pm_tasktracks.createdon, pm_tasktracks.lasteditedby, pm_tasktracks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tasktracks->fetchObject;

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
	
	
$page_title="Tasktracks ";
include "addtasktracks.php";
?>