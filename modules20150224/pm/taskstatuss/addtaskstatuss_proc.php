<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Taskstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8391";//Edit
}
else{
	$auth->roleid="8391";//Add
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
	$taskstatuss=new Taskstatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$taskstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskstatuss=$taskstatuss->setObject($obj);
		if($taskstatuss->add($taskstatuss)){
			$error=SUCCESS;
			redirect("addtaskstatuss_proc.php?id=".$taskstatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$taskstatuss=new Taskstatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$taskstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$taskstatuss=$taskstatuss->setObject($obj);
		if($taskstatuss->edit($taskstatuss)){
			$error=UPDATESUCCESS;
			redirect("addtaskstatuss_proc.php?id=".$taskstatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$taskstatuss=new Taskstatuss();
	$where=" where id=$id ";
	$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$taskstatuss->fetchObject;

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
	
	
$page_title="Taskstatuss ";
include "addtaskstatuss.php";
?>