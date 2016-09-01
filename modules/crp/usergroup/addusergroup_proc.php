<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Usergroup_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../crp/users/Users_class.php");
require_once("../../crp/groups/Groups_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8955";//Edit
}
else{
	$auth->roleid="8953";//Add
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
	$usergroup=new Usergroup();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$usergroup->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$usergroup=$usergroup->setObject($obj);
		if($usergroup->add($usergroup)){
			$error=SUCCESS;
			redirect("addusergroup_proc.php?id=".$usergroup->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$usergroup=new Usergroup();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$usergroup->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$usergroup=$usergroup->setObject($obj);
		if($usergroup->edit($usergroup)){
			$error=UPDATESUCCESS;
			redirect("addusergroup_proc.php?id=".$usergroup->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$usergroup=new Usergroup();
	$where=" where id=$id ";
	$fields="crp_usergroup.user_id, crp_usergroup.group_id, crp_usergroup.join_date";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$usergroup->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $usergroup->sql;
	$obj=$usergroup->fetchObject;

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
	
	
$page_title="Usergroup ";
include "addusergroup.php";
?>