<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Config_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="122";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="120";//Add
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
	
	
if($obj->action=="Save"){
	$config=new Config();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$config->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$config=$config->setObject($obj);
		if($config->add($config)){
			$error=SUCCESS;
			redirect("addconfig_proc.php?id=".$config->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$config=new Config();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$config->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$config=$config->setObject($obj);
		if($config->edit($config)){
			$error=UPDATESUCCESS;
			redirect("addconfig_proc.php?id=".$config->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$config=new Config();
	$where=" where id=$id ";
	$fields="sys_config.id, sys_config.name, sys_config.value";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$config->fetchObject;

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
	
	
$page_title="Config ";
include "addconfig.php";
?>