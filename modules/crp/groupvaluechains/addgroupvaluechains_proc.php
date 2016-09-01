<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Groupvaluechains_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/groups/Groups_class.php");
require_once("../../crp/valuechains/Valuechains_class.php");

require_once("../../crp/themes/Themes_class.php");
require_once("../../crp/valuechains/Valuechains_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9160";//Edit
}
else{
	$auth->roleid="9160";//Add
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
	$groupvaluechains=new Groupvaluechains();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$groupvaluechains->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupvaluechains=$groupvaluechains->setObject($obj);
		if($groupvaluechains->add($groupvaluechains)){
			$error=SUCCESS;
			redirect("addgroupvaluechains_proc.php?id=".$groupvaluechains->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$groupvaluechains=new Groupvaluechains();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$groupvaluechains->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupvaluechains=$groupvaluechains->setObject($obj);
		if($groupvaluechains->edit($groupvaluechains)){
			$error=UPDATESUCCESS;
			redirect("addgroupvaluechains_proc.php?id=".$groupvaluechains->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$groups= new Groups();
	$fields="crp_groups.id, crp_groups.group_name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$valuechains= new Valuechains();
	$fields="crp_valuechains.id, crp_valuechains.name, crp_valuechains.remarks, crp_valuechains.ipaddress, crp_valuechains.createdby, crp_valuechains.createdon, crp_valuechains.lasteditedby, crp_valuechains.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$groupvaluechains=new Groupvaluechains();
	$where=" where id=$id ";
	$fields="crp_groupvaluechains.id, crp_groupvaluechains.groupid, crp_groupvaluechains.valuechainid, crp_groupvaluechains.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groupvaluechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$groupvaluechains->fetchObject;

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
	
	
$page_title="Groupvaluechains ";
include "addgroupvaluechains.php";
?>