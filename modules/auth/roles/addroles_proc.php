<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Roles_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/modules/Modules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7";//Edit
}
else{
	$auth->roleid="5";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$roles=new Roles();
	$where=" where id=$id ";
	$fields="auth_roles.id, auth_roles.name, auth_roles.moduleid, auth_roles.module, auth_roles.createdby, auth_roles.createdon, auth_roles.lasteditedby, auth_roles.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$roles->fetchObject;
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
		$roles=new Roles();
		$roles=setObject($obj);
		if($roles->add($roles)){
			$error=SUCCESS;
			redirect("addroles_proc.php?id=".$roles->id."&error=".$error);
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
		$roles=new Roles();
		$roles=setObject($obj);
		if($roles->edit($roles)){
			$obj="";
			$error=UPDATESUCCESS;
			redirect("addroles_proc.php?id=".$roles->id."&error=".$error);
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

	$shop['$it']=array("id"=>$obj->id, "name"=>$obj->name, "moduleid"=>$obj->moduleid, "module"=>$obj->module, "createdby"=>$obj->createdby, "createdon"=>$obj->createdon, "lasteditedby"=>$obj->lasteditedby, "lasteditedon"=>$obj->lasteditedon);

 	$it++;
 	$_SESSION['shop']=$shop;

	$obj->id="";
 	$obj->name="";
 	$obj->moduleid="";
 	$obj->module="";
 	$obj->createdby="";
 	$obj->createdon="";
 	$obj->lasteditedby="";
 	$obj->lasteditedon="";
 }
if(empty($obj->action)){

	$modules= new Modules ();
	$fields="sys_modules.id, sys_modules.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

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
	else if(empty($obj->moduleid)){
		$error="moduleid should be provided";
	}
	else if(empty($obj->module)){
		$error="module should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$roles= new Roles();
		$roles->id=str_replace(',','',$obj->id);
		$roles->name=str_replace(',','',$obj->name);
		$roles->moduleid=str_replace(',','',$obj->moduleid);
		$roles->module=str_replace(',','',$obj->module);
		$roles->createdby=str_replace(',','',$obj->createdby);
		$roles->createdon=str_replace(',','',$obj->createdon);
		$roles->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$roles->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $roles;
	
}
$page_title="Roles ";
include "addroles.php";
?>