<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Themes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/crps/Crps_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9112";//Edit
}
else{
	$auth->roleid="9110";//Add
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
	$themes=new Themes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$themes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$themes=$themes->setObject($obj);
		if($themes->add($themes)){
			$error=SUCCESS;
			redirect("addthemes_proc.php?id=".$themes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$themes=new Themes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$themes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$themes=$themes->setObject($obj);
		if($themes->edit($themes)){
			$error=UPDATESUCCESS;
			redirect("addthemes_proc.php?id=".$themes->id."&error=".$error);
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
	$themes=new Themes();
	$where=" where id=$id ";
	$fields="crp_themes.id, crp_themes.name, crp_themes.crpid, crp_themes.remarks, crp_themes.ipaddress, crp_themes.createdby, crp_themes.createdon, crp_themes.lasteditedby, crp_themes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$themes->fetchObject;

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
	
	
$page_title="Themes ";
include "addthemes.php";
?>