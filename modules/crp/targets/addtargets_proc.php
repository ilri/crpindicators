<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Targets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/tables/Tables_class.php");
require_once("../../crp/crps/Crps_class.php");
require_once("../../crp/users/Users_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9072";//Edit
}
else{
	$auth->roleid="9072";//Add
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
	$targets=new Targets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$targets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$targets=$targets->setObject($obj);
		if($targets->add($targets)){
			$error=SUCCESS;
			redirect("addtargets_proc.php?id=".$targets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$targets=new Targets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$targets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$targets=$targets->setObject($obj);
		if($targets->edit($targets)){
			$error=UPDATESUCCESS;
			redirect("addtargets_proc.php?id=".$targets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tables= new Tables();
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks, crp_tables.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$crps= new Crps();
	$fields="crp_crps.id, crp_crps.crp_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$users= new Users();
	$fields="crp_users.id, crp_users.user_login, crp_users.user_name, crp_users.user_pass, crp_users.user_email, crp_users.user_isadmin";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$targets=new Targets();
	$where=" where id=$id ";
	$fields="crp_targets.id, crp_targets.tableid, crp_targets.crpid, crp_targets.target, crp_targets.userid, crp_targets.year, crp_targets.datekeyed";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$targets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$targets->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->year=date("Y");
		$obj->datekeyed=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Targets ";
include "addtargets.php";
?>