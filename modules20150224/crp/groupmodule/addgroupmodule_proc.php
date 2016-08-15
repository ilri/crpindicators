<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Groupmodule_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/tables/Tables_class.php");
require_once("../../crp/groups/Groups_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8887";//Edit
}
else{
	$auth->roleid="8885";//Add
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
	$groupmodule=new Groupmodule();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$groupmodule->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupmodule=$groupmodule->setObject($obj);
		if($groupmodule->add($groupmodule)){
			$error=SUCCESS;
			redirect("addgroupmodule_proc.php?id=".$groupmodule->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$groupmodule=new Groupmodule();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$groupmodule->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupmodule=$groupmodule->setObject($obj);
		if($groupmodule->edit($groupmodule)){
			$error=UPDATESUCCESS;
			redirect("addgroupmodule_proc.php?id=".$groupmodule->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tables= new Tables();
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$groups= new Groups();
	$fields="crp_groups.id, crp_groups.group_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$groupmodule=new Groupmodule();
	$where=" where id=$id ";
	$fields="crp_groupmodule.id, crp_groupmodule.tableid, crp_groupmodule.groupid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groupmodule->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$groupmodule->fetchObject;

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
	
	
$page_title="Groupmodule ";
include "addgroupmodule.php";
?>