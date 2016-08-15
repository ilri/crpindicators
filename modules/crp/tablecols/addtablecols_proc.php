<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tablecols_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/tables/Tables_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9308";//Edit
}
else{
	$auth->roleid="9308";//Add
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
	$tablecols=new Tablecols();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tablecols->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tablecols=$tablecols->setObject($obj);
		if($tablecols->add($tablecols)){
			$error=SUCCESS;
			redirect("addtablecols_proc.php?id=".$tablecols->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tablecols=new Tablecols();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tablecols->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tablecols=$tablecols->setObject($obj);
		if($tablecols->edit($tablecols)){
			$error=UPDATESUCCESS;
			redirect("addtablecols_proc.php?id=".$tablecols->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tables= new Tables();
	$fields="crp_tables.id, crp_tables.name, crp_tables.description, crp_tables.remarks, crp_tables.status, crp_tables.indicator, crp_tables.title, crp_tables.position";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tablecols=new Tablecols();
	$where=" where id=$id ";
	$fields="crp_tablecols.id, crp_tablecols.tableid, crp_tablecols.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tablecols->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tablecols->fetchObject;

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
	
	
$page_title="Tablecols ";
include "addtablecols.php";
?>