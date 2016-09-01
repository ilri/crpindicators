<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8995";//Edit
}
else{
	$auth->roleid="8993";//Add
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
	$tables=new Tables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tables=$tables->setObject($obj);
		if($tables->add($tables)){
			$error=SUCCESS;
			redirect("addtables_proc.php?id=".$tables->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tables=new Tables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tables=$tables->setObject($obj);
		if($tables->edit($tables)){
			$error=UPDATESUCCESS;
			redirect("addtables_proc.php?id=".$tables->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$tables=new Tables();
	$where=" where id=$id ";
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks, crp_tables.status, crp_tables.indicator";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tables->fetchObject;

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
	
	
$page_title="Tables ";
include "addtables.php";
?>