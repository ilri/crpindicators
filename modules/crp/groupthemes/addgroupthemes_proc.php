<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Groupthemes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/groups/Groups_class.php");
require_once("../../crp/themes/Themes_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9158";//Edit
}
else{
	$auth->roleid="9158";//Add
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
	$groupthemes=new Groupthemes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$groupthemes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupthemes=$groupthemes->setObject($obj);
		if($groupthemes->add($groupthemes)){
			$error=SUCCESS;
			redirect("addgroupthemes_proc.php?id=".$groupthemes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$groupthemes=new Groupthemes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$groupthemes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$groupthemes=$groupthemes->setObject($obj);
		if($groupthemes->edit($groupthemes)){
			$error=UPDATESUCCESS;
			redirect("addgroupthemes_proc.php?id=".$groupthemes->id."&error=".$error);
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


	$themes= new Themes();
	$fields="crp_themes.id, crp_themes.name, crp_themes.remarks, crp_themes.ipaddress, crp_themes.createdby, crp_themes.createdon, crp_themes.lasteditedby, crp_themes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$groupthemes=new Groupthemes();
	$where=" where id=$id ";
	$fields="crp_groupthemes.id, crp_groupthemes.groupid, crp_groupthemes.themeid, crp_groupthemes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groupthemes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$groupthemes->fetchObject;

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
	
	
$page_title="Groupthemes ";
include "addgroupthemes.php";
?>