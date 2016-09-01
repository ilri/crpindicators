<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="3";//Edit
}
else{
	$auth->roleid="1";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$levels=new Levels();
	$where=" where id=$id ";
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$levels->fetchObject;
}
	
if($obj->action=="Save"){
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levels=new Levels();
		$levels=setObject($obj);
		if($levels->add($levels)){
			$error=SUCCESS;
			redirect("addlevels_proc.php?id=".$levels->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levels=new Levels();
		$levels=setObject($obj);
		if($levels->edit($levels)){
			$obj="";
			$error=UPDATESUCCESS;
			redirect("addlevels_proc.php?id=".$levels->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action=="Add"){

	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shop=$_SESSION['shop'];

	$shop['$it']=array("id"=>$obj->id, "name"=>$obj->name, "createdby"=>$obj->createdby, "createdon"=>$obj->createdon, "lasteditedby"=>$obj->lasteditedby, "lasteditedon"=>$obj->lasteditedon);

 	$it++;
 	$_SESSION['shop']=$shop;

	$obj->id="";
 	$obj->name="";
 	$obj->createdby="";
 	$obj->createdon="";
 	$obj->lasteditedby="";
 	$obj->lasteditedon="";
 }
if(empty($obj->action)){
}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->name)){
		$error="name should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$levels= new Levels();
		$levels->id=str_replace(',','',$obj->id);
		$levels->name=str_replace(',','',$obj->name);
		$levels->createdby=str_replace(',','',$obj->createdby);
		$levels->createdon=str_replace(',','',$obj->createdon);
		$levels->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$levels->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $levels;
	
}
$page_title="Levels ";
include "addlevels.php";
?>