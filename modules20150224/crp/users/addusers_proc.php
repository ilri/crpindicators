<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/groups/Groups_class.php");
require_once("../../crp/centers/Centers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8963";//Edit
}
else{
	$auth->roleid="8961";//Add
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
	$users=new Users();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$users->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$users=$users->setObject($obj);
		if($users->add($users)){
			$error=SUCCESS;
			redirect("addusers_proc.php?id=".$users->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$users=new Users();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$users->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$users=$users->setObject($obj);
		if($users->edit($users)){
			$error=UPDATESUCCESS;
			redirect("addusers_proc.php?id=".$users->id."&error=".$error);
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


	$centers= new Centers();
	$fields="crp_centers.id, crp_centers.name, crp_centers.remarks, crp_centers.ipaddress, crp_centers.createdby, crp_centers.createdon, crp_centers.lasteditedby, crp_centers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$centers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$users=new Users();
	$where=" where id=$id ";
	$fields="crp_users.id, crp_users.user_login, crp_users.user_name, crp_users.user_email,crp_users.user_isadmin, crp_users.centerid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$obj=$users->fetchObject;

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

if(!empty($ob->edit)){
  $obj->editing=$ob->edit;
}
	
$page_title="Users ";
include "addusers.php";
?>