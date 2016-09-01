<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../auth/levels/Levels_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="13";//Edit
}
else{
	$auth->roleid="11";//Add
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
	
	
if($obj->action=="Save"){
	$users=new Users();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$users->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$users=$users->setObject($obj);
		$users->setPassword($users->password);
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
		$users->setPassword($users->password);
		if($users->edit($users)){
			$error=UPDATESUCCESS;
			redirect("addusers_proc.php?id=".$users->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Change Level"){

	$user = new Users();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$obj->id' ";
	$user->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$ob=$user->fetchObject;

	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$ob->levelid=$obj->levelid;
	
	$users=new Users();
	
	//$error=$users->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$users=$users->setObject($ob);
		if($users->edit($users)){
			$error=UPDATESUCCESS;
			//redirect("addusers_proc.php?id=".$users->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if(empty($obj->action)){

	$levels= new Levels();
	$fields="auth_levels.id, auth_levels.name, auth_levels.createdby, auth_levels.createdon, auth_levels.lasteditedby, auth_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$users=new Users();
	$where=" where id=$id ";
	$fields="auth_users.id, auth_users.employeeid, auth_users.username, auth_users.levelid, auth_users.status, auth_users.lastlogin, auth_users.createdby, auth_users.createdon, auth_users.lasteditedby, auth_users.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
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
	$obj->status="Active";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Users ";
include "addusers.php";
?>