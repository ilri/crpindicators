<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Valuechains_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/crps/Crps_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9116";//Edit
}
else{
	$auth->roleid="9114";//Add
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
	$valuechains=new Valuechains();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$valuechains->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$valuechains=$valuechains->setObject($obj);
		if($valuechains->add($valuechains)){
			$error=SUCCESS;
			redirect("addvaluechains_proc.php?id=".$valuechains->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$valuechains=new Valuechains();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$valuechains->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$valuechains=$valuechains->setObject($obj);
		if($valuechains->edit($valuechains)){
			$error=UPDATESUCCESS;
			redirect("addvaluechains_proc.php?id=".$valuechains->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$crps= new Crps();
	$fields="crp_crps.id, crp_crps.crp_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$valuechains=new Valuechains();
	$where=" where id=$id ";
	$fields="crp_valuechains.id, crp_valuechains.name, crp_valuechains.crpid, crp_valuechains.remarks, crp_valuechains.ipaddress, crp_valuechains.createdby, crp_valuechains.createdon, crp_valuechains.lasteditedby, crp_valuechains.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$valuechains->fetchObject;

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
	
	
$page_title="Valuechains ";
include "addvaluechains.php";
?>