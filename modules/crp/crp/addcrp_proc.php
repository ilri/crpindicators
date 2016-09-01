<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crp_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8875";//Edit
}
else{
	$auth->roleid="8873";//Add
}
$auth->levelid=$_SESSION['level'];


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
	$crp=new Crp();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$crp->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crp=$crp->setObject($obj);
		if($crp->add($crp)){
			$error=SUCCESS;
			redirect("addcrp_proc.php?id=".$crp->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$crp=new Crp();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$crp->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crp=$crp->setObject($obj);
		if($crp->edit($crp)){
			$error=UPDATESUCCESS;
			redirect("addcrp_proc.php?id=".$crp->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$crp=new Crp();
	$where=" where id=$id ";
	$fields="crp_crp.id, crp_crp.crp_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crp->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$crp->fetchObject;

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
	
	
$page_title="Crp ";
include "addcrp.php";
?>