<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notificationrecipients_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/notifications/Notifications_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8345";//Edit
}
else{
	$auth->roleid="8343";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;


if(!empty($ob->id) and $ob->status=="unread"){
	$notificationrecipients=new Notificationrecipients();
	$where=" where id=$ob->id ";
	$fields="pm_notificationrecipients.id, pm_notificationrecipients.notificationid, pm_notificationrecipients.employeeid, pm_notificationrecipients.email, pm_notificationrecipients.notifiedon, pm_notificationrecipients.readon, pm_notificationrecipients.status, pm_notificationrecipients.ipaddress, pm_notificationrecipients.createdby, pm_notificationrecipients.createdon, pm_notificationrecipients.lasteditedby, pm_notificationrecipients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notificationrecipients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$notificationrecipients=$notificationrecipients->fetchObject;
	$notificationrecipients->status="read";
	$notificationrecipients->readon=date("Y-m-d H:i:s");
	
	$np = new Notificationrecipients();
	$np->setObject($notificationrecipients);
	$np->edit($np);
}

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
	$notificationrecipients=new Notificationrecipients();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$notificationrecipients->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notificationrecipients=$notificationrecipients->setObject($obj);
		if($notificationrecipients->add($notificationrecipients)){
			$error=SUCCESS;
			redirect("addnotificationrecipients_proc.php?id=".$notificationrecipients->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$notificationrecipients=new Notificationrecipients();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$notificationrecipients->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notificationrecipients=$notificationrecipients->setObject($obj);
		if($notificationrecipients->edit($notificationrecipients)){
			$error=UPDATESUCCESS;
			redirect("addnotificationrecipients_proc.php?id=".$notificationrecipients->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$notifications= new Notifications();
	$fields="pm_notifications.id, pm_notifications.notificationtypeid, pm_notifications.subject, pm_notifications.body, pm_notifications.taskid, pm_notifications.ipaddress, pm_notifications.createdby, pm_notifications.createdon, pm_notifications.lasteditedby, pm_notifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$notificationrecipients=new Notificationrecipients();
	$where=" where id=$id ";
	$fields="pm_notificationrecipients.id, pm_notificationrecipients.notificationid, pm_notificationrecipients.employeeid, pm_notificationrecipients.email, pm_notificationrecipients.notifiedon, pm_notificationrecipients.readon, pm_notificationrecipients.status, pm_notificationrecipients.ipaddress, pm_notificationrecipients.createdby, pm_notificationrecipients.createdon, pm_notificationrecipients.lasteditedby, pm_notificationrecipients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notificationrecipients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$notificationrecipients->fetchObject;

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
	
	
$page_title="Notificationrecipients ";
include "addnotificationrecipients.php";
?>