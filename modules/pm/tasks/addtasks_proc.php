<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tasks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../pm/taskstatuss/Taskstatuss_class.php");
require_once("../../pm/tasktracks/Tasktracks_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../con/projects/Projects_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8229";//Edit
}
else{
	$auth->roleid="8227";//Add
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
	$tasks=new Tasks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tasks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks=$tasks->setObject($obj);
		if($tasks->add($tasks)){
			$error=SUCCESS;
			//redirect("addtasks_proc.php?id=".$tasks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tasks=new Tasks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tasks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks=$tasks->setObject($obj);
		if($tasks->edit($tasks)){
			$error=UPDATESUCCESS;
			redirect("addtasks_proc.php?id=".$tasks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(!empty($obj->actions)){

	$action=$obj->actions;
	
	$tasks=new Tasks();
	$where=" where id=$obj->id ";
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.routeid,pm_tasks.routedetailid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.origtask, pm_tasks.statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tasks->fetchObject;
	
	$obj->workflow=1;
	
	if(empty($obj->origtask))
	  $obj->origtask=$obj->id;
	
	$tasks = new Tasks();
	
	switch($action){
	  case "Start":
	    $obj->statusid=3;
	    $tasks->setObject($obj);
	    $tasks->edit($tasks);
	    break;
	    
	  case "Delegate":
	  //create new task for employee delegated to
	    $obj->statusid=4;
	    $tasks->employeeid=$obj->employee;
	    $tasks->setObject($obj);
	    $tasks->edit($tasks);
	    
	    
	    break;
	  case "Approve":
	  //create a new task to the next guy in wf route
	      $obj->statusid=6;
	      $tasks->setObject($obj);
	      $tasks->edit($tasks);
	      
	      $tasks=new Tasks();
	      $tasks->processTask($obj);
	      
	      break;
	  case "Decline":
	  //create NOTIFICATION to the creator of the document and other nodes who had approved it already
	      $obj->statusid=7;
	      $tasks->setObject($obj);
	      $tasks->edit($tasks);
	      
	      $tasks=new Tasks();
	      $tasks->processTask($obj);
	      
	      break;
	  case "Finish":
	      $obj->statusid=8;
	      $tasks->setObject($obj);
	      $tasks->edit($tasks);
	      break;
	  default:
	    
	}
    
    //add task tracktime
    $tasktracks = new Tasktracks();
    $tasktracks->taskid=$obj->id;
    $tasktracks->origtask=$obj->origtask;
    $tasktracks->statusid=$obj->statusid;
    $tasktracks->remarks=$obj->remarks;
    $tasktracks->changedon=date("Y-m-d H:i:s");
    $tasktracks->createdby=$_SESSION['userid'];
    $tasktracks->createdon=date("Y-m-d H:i:s");
    $tasktracks->lasteditedby=$_SESSION['userid'];
    $tasktracks->lasteditedon=date("Y-m-d H:i:s");
    $tasktracks->ipaddress=$_SERVER['REMOTE_ADDR'];
    $tasktracks->add($tasktracks);
    
    redirect("addtasks_proc.php?id=".$obj->id."&not=true&error=".$error);
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$routes= new Routes();
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$assignments= new Assignments();
	$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$taskstatuss= new Taskstatuss();
	$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tasks=new Tasks();
	$where=" where id=$id ";
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.projectid, pm_tasks.routedetailid, pm_tasks.routeid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.origtask, pm_tasks.statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tasks->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
	$assignments = new Assignments();
	$fields=" hrm_assignments.name, hrm_levels.name levelid ";
	$where=" where hrm_assignments.id='$obj->assignmentid'";
	$join=" left join hrm_levels on hrm_assignments.levelid=hrm_levels.id ";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$assignments->fetchObject;
	
	$obj->assignmentname=$auto->name;
	$obj->levelname=$auto->levelid;
	
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$obj->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$obj->projectname=$auto->name;
	
	$routes = new Routes();
	$fields=" * ";
	$where=" where id='$obj->routeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$routes->fetchObject;

	$obj->routename=$auto->name;
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
	
	
$page_title="Tasks ";

if($ob->not){
  //change tasks status to viewed
  if($obj->statusid==1){
    $obj->statusid=2;
    
    //update task record
    $tasks = new Tasks();
    $tasks->setObject($obj);
    $tasks->edit($tasks);
    
    //add task tracktime
    $tasktracks = new Tasktracks();
    $tasktracks->taskid=$obj->taskid;
    $tasktracks->statusid=2;
    $tasktracks->changedon=date("Y-m-d H:i:s");
    $tasktracks->add($tasktracks);
  }
  include "addtask.php";
}
else
  include "addtasks.php";
?>