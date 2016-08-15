<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notificationtypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8217";//Edit
}
else{
	$auth->roleid="8215";//Add
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
	$notificationtypes=new Notificationtypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$notificationtypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notificationtypes=$notificationtypes->setObject($obj);
		if($notificationtypes->add($notificationtypes)){
			$error=SUCCESS;
			redirect("addnotificationtypes_proc.php?id=".$notificationtypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$notificationtypes=new Notificationtypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$notificationtypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notificationtypes=$notificationtypes->setObject($obj);
		if($notificationtypes->edit($notificationtypes)){
			$error=UPDATESUCCESS;
			redirect("addnotificationtypes_proc.php?id=".$notificationtypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$notificationtypes=new Notificationtypes();
	$where=" where id=$id ";
	$fields="pm_notificationtypes.id, pm_notificationtypes.name, pm_notificationtypes.remarks, pm_notificationtypes.ipaddress, pm_notificationtypes.createdby, pm_notificationtypes.createdon, pm_notificationtypes.lasteditedby, pm_notificationtypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notificationtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$notificationtypes->fetchObject;

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
	
	
$page_title="Notificationtypes ";
include "addnotificationtypes.php";
?>