<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crpuser_class.php");
require_once("../crps/Crps_class.php");
require_once("../users/Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8879";//Edit
}
else{
	$auth->roleid="8877";//Add
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
	$crpuser=new Crpuser();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$crpuser->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crpuser=$crpuser->setObject($obj);
		if($crpuser->add($crpuser)){
			$error=SUCCESS;
			redirect("addcrpuser_proc.php?id=".$crpuser->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$crpuser=new Crpuser();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$crpuser->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crpuser=$crpuser->setObject($obj);
		if($crpuser->edit($crpuser)){
			$error=UPDATESUCCESS;
			redirect("addcrpuser_proc.php?id=".$crpuser->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$crpuser=new Crpuser();
	$where=" where id=$id ";
	$fields="crp_crpuser.id, crp_crpuser.crp_id, crp_crpuser.userid, crp_crpuser.join_date, crp_crpuser.supervisor";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crpuser->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$crpuser->fetchObject;

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
	
	
$page_title="Crpuser ";
include "addcrpuser.php";
?>