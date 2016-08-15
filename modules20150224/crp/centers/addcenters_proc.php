<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Centers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9106";//Edit
}
else{
	$auth->roleid="9106";//Add
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
	$centers=new Centers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$centers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$centers=$centers->setObject($obj);
		if($centers->add($centers)){
			$error=SUCCESS;
			redirect("addcenters_proc.php?id=".$centers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$centers=new Centers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$centers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$centers=$centers->setObject($obj);
		if($centers->edit($centers)){
			$error=UPDATESUCCESS;
			redirect("addcenters_proc.php?id=".$centers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$centers=new Centers();
	$where=" where id=$id ";
	$fields="crp_centers.id, crp_centers.name, crp_centers.remarks, crp_centers.ipaddress, crp_centers.createdby, crp_centers.createdon, crp_centers.lasteditedby, crp_centers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$centers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$centers->fetchObject;

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
	
	
$page_title="Centers ";
include "addcenters.php";
?>