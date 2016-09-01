<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
// require_once("../../sys/submodules/Submodules_class.php");
require_once("Periods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8959";//Edit
}
else{
	$auth->roleid="8959";//Add
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
	$periods=new Periods();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$periods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$periods=$periods->setObject($obj);
		if($periods->add($periods)){
			$error=SUCCESS;
			redirect("addperiods_proc.php?id=".$periods->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$periods=new Periods();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$periods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$periods=$periods->setObject($obj);
		if($periods->edit($periods)){
			$error=UPDATESUCCESS;
			redirect("addperiods_proc.php?id=".$periods->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$periods=new Periods();
	$where=" where id=$id ";
	$fields="crp_periods.id, crp_periods.name, crp_periods.ipaddress, crp_periods.createdby, crp_periods.createdon, crp_periods.lasteditedby, crp_periods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$periods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$periods->fetchObject;

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
	
	

$page_title="Periods";
include "addperiods.php";
?>