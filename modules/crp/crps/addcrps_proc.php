<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crps_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8959";//Edit
}
else{
	$auth->roleid="8957";//Add
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
	$crps=new Crps();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$crps->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crps=$crps->setObject($obj);
		if($crps->add($crps)){
			$error=SUCCESS;
			redirect("addcrps_proc.php?id=".$crps->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$crps=new Crps();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$crps->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crps=$crps->setObject($obj);
		if($crps->edit($crps)){
			$error=UPDATESUCCESS;
			redirect("addcrps_proc.php?id=".$crps->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$crps=new Crps();
	$where=" where id=$id ";
	$fields="crp_crps.id, crp_crps.crpno, crp_crps.crp_name, crp_crps.category, crp_crps.subcategory";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$crps->fetchObject;

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
	
	
$page_title="Crps ";
include "addcrps.php";
?>