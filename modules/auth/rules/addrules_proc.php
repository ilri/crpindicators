<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../auth/roles/Roles_class.php");
require_once("../../auth/levels/Levels_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1783";//Edit
}
else{
	$auth->roleid="9";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$rules=new Rules();
	$where=" where id=$id ";
	$fields="auth_rules.id, auth_rules.levelid, auth_rules.roleid, auth_rules.createdby, auth_rules.createdon, auth_rules.lasteditedby, auth_rules.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$rules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$rules->fetchObject;
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
		$rules=new Rules();
		$rules=setObject($obj);
		if($rules->add($rules)){
			$error=SUCCESS;
			redirect("addrules_proc.php?id=".$rules->id."&error=".$error);
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
		$rules=new Rules();
		$rules=setObject($obj);
		if($rules->edit($rules)){
			$obj="";
			$error=UPDATESUCCESS;
			redirect("addrules_proc.php?id=".$rules->id."&error=".$error);
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

	$shop['$it']=array("id"=>$obj->id, "levelid"=>$obj->levelid, "roleid"=>$obj->roleid, "createdby"=>$obj->createdby, "createdon"=>$obj->createdon, "lasteditedby"=>$obj->lasteditedby, "lasteditedon"=>$obj->lasteditedon);

 	$it++;
 	$_SESSION['shop']=$shop;

	$obj->id="";
 	$obj->levelid="";
 	$obj->roleid="";
 	$obj->createdby="";
 	$obj->createdon="";
 	$obj->lasteditedby="";
 	$obj->lasteditedon="";
 }
if(empty($obj->action)){

	$roles= new Roles ();
	$fields="auth_roles.id, auth_roles.name, auth_roles.moduleid, auth_roles.module, auth_roles.createdby, auth_roles.createdon, auth_roles.lasteditedby, auth_roles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$levels= new Levels ();
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	
		return null;
	
}
function setObject($obj){
		$rules= new Rules();
		$rules->id=str_replace(',','',$obj->id);
		$rules->levelid=str_replace(',','',$obj->levelid);
		$rules->roleid=str_replace(',','',$obj->roleid);
		$rules->createdby=str_replace(',','',$obj->createdby);
		$rules->createdon=str_replace(',','',$obj->createdon);
		$rules->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$rules->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $rules;
	
}
$page_title="Rules ";
include "addrules.php";
?>