<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Notifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../pm/notificationtypes/Notificationtypes_class.php");
require_once("../../pm/tasks/Tasks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8213";//Edit
}
else{
	$auth->roleid="8211";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->notificationrecipientid) and $ob->status=="unread"){
	$notificationrecipients=new Notificationrecipients();
	$where=" where id=$ob->notificationrecipientid ";
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
	$notifications=new Notifications();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$notifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notifications=$notifications->setObject($obj);
		if($notifications->add($notifications)){
			$error=SUCCESS;
			redirect("addnotifications_proc.php?id=".$notifications->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$notifications=new Notifications();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$notifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$notifications=$notifications->setObject($obj);
		if($notifications->edit($notifications)){
			$error=UPDATESUCCESS;
			redirect("addnotifications_proc.php?id=".$notifications->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$notificationtypes= new Notificationtypes();
	$fields="pm_notificationtypes.id, pm_notificationtypes.name, pm_notificationtypes.remarks, pm_notificationtypes.ipaddress, pm_notificationtypes.createdby, pm_notificationtypes.createdon, pm_notificationtypes.lasteditedby, pm_notificationtypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notificationtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$tasks= new Tasks();
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.routeid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.status, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$notifications=new Notifications();
	$where=" where id=$id ";
	$fields="pm_notifications.id, pm_notifications.notificationtypeid, pm_notifications.subject, pm_notifications.body, pm_notifications.taskid, pm_notifications.ipaddress, pm_notifications.createdby, pm_notifications.createdon, pm_notifications.lasteditedby, pm_notifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$notifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$notifications->fetchObject;

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
	
	
$page_title="Notifications ";
include "addnotifications.php";
?>