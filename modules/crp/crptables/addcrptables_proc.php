<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crptables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/crps/Crps_class.php");
require_once("../../crp/tables/Tables_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9010";//Edit
}
else{
	$auth->roleid="9010";//Add
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
	$crptables=new Crptables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$crptables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crptables=$crptables->setObject($obj);
		if($crptables->add($crptables)){
			$error=SUCCESS;
			redirect("addcrptables_proc.php?id=".$crptables->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$crptables=new Crptables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$crptables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$crptables=$crptables->setObject($obj);
		if($crptables->edit($crptables)){
			$error=UPDATESUCCESS;
			redirect("addcrptables_proc.php?id=".$crptables->id."&error=".$error);
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


	$tables= new Tables();
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$crptables=new Crptables();
	$where=" where id=$id ";
	$fields="crp_crptables.id, crp_crptables.crpid, crp_crptables.tableid, crp_crptables.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crptables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$crptables->fetchObject;

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
	
	
$page_title="Crptables ";
include "addcrptables.php";
?>