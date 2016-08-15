<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agroecologicalzones_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9068";//Edit
}
else{
	$auth->roleid="9068";//Add
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
	$agroecologicalzones=new Agroecologicalzones();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$agroecologicalzones->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agroecologicalzones=$agroecologicalzones->setObject($obj);
		if($agroecologicalzones->add($agroecologicalzones)){
			$error=SUCCESS;
			redirect("addagroecologicalzones_proc.php?id=".$agroecologicalzones->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$agroecologicalzones=new Agroecologicalzones();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$agroecologicalzones->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agroecologicalzones=$agroecologicalzones->setObject($obj);
		if($agroecologicalzones->edit($agroecologicalzones)){
			$error=UPDATESUCCESS;
			redirect("addagroecologicalzones_proc.php?id=".$agroecologicalzones->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$agroecologicalzones=new Agroecologicalzones();
	$where=" where id=$id ";
	$fields="crp_agroecologicalzones.id, crp_agroecologicalzones.name, crp_agroecologicalzones.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agroecologicalzones->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$agroecologicalzones->fetchObject;

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
	
	
$page_title="Agroecologicalzones ";
include "addagroecologicalzones.php";
?>