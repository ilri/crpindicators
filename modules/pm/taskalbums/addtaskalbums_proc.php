<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskalbums_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/tasks/Tasks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8349";//Edit
}
else{
	$auth->roleid="8347";//Add
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
	$taskalbums=new Taskalbums();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$taskalbums->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskalbums=$taskalbums->setObject($obj);
		if($taskalbums->add($taskalbums)){
			$error=SUCCESS;
			redirect("addtaskalbums_proc.php?id=".$taskalbums->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$taskalbums=new Taskalbums();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$taskalbums->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskalbums=$taskalbums->setObject($obj);
		if($taskalbums->edit($taskalbums)){
			$error=UPDATESUCCESS;
			redirect("addtaskalbums_proc.php?id=".$taskalbums->id."&error=".$error);
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

}

if(!empty($id)){
	$taskalbums=new Taskalbums();
	$where=" where id=$id ";
	$fields="pm_taskalbums.id, pm_taskalbums.taskid, pm_taskalbums.name, pm_taskalbums.remarks, pm_taskalbums.ipaddress, pm_taskalbums.createdby, pm_taskalbums.createdon, pm_taskalbums.lasteditedby, pm_taskalbums.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskalbums->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$taskalbums->fetchObject;

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
	
	
$page_title="Taskalbums ";
include "addtaskalbums.php";
?>