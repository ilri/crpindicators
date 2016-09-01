<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agsystemfieldtestin_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crp/crps/Crps_class.php");
require_once("../../crp/users/Users_class.php");
require_once("../../crp/agroecologicalzones/Agroecologicalzones_class.php");

require_once("../../crp/themes/Themes_class.php");
require_once("../../crp/valuechains/Valuechains_class.php");
require_once("../../crp/tables/Tables_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8867";//Edit
}
else{
	$auth->roleid="8865";//Add
}
$auth->levelid=$_SESSION['level'];


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$obj->crpattribution=false;

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
	$agsystemfieldtestin=new Agsystemfieldtestin();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$agsystemfieldtestin->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		//$agsystemfieldtestin=$agsystemfieldtestin->setObject($obj);
		if($agsystemfieldtestin->add($obj)){
			$error=SUCCESS;
			redirect("addagsystemfieldtestin_proc.php?id=".$agsystemfieldtestin->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$agsystemfieldtestin=new Agsystemfieldtestin();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$agsystemfieldtestin->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		//$agsystemfieldtestin=$agsystemfieldtestin->setObject($obj);
		if($agsystemfieldtestin->edit($obj)){
			$error=UPDATESUCCESS;
			redirect("addagsystemfieldtestin_proc.php?id=".$agsystemfieldtestin->id."&error=".$error);
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


	$users= new Users();
	$fields="crp_users.id, crp_users.user_login, crp_users.user_name, crp_users.user_pass, crp_users.user_email, crp_users.user_isadmin";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$agsystemfieldtestin=new Agsystemfieldtestin();
	$where=" where id=$id ";
	$fields="crp_agsystemfieldtestin.id, crp_agsystemfieldtestin.ecosystem_name, crp_agsystemfieldtestin.practice_name, crp_agsystemfieldtestin.country, crp_agsystemfieldtestin.region, crp_agsystemfieldtestin.decrease_inequality, crp_agsystemfieldtestin.crpid, crp_agsystemfieldtestin.rec_period, crp_agsystemfieldtestin.userid, crp_agsystemfieldtestin.url, crp_agsystemfieldtestin.valid_data";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agsystemfieldtestin->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$agsystemfieldtestin->fetchObject;
	
	$tables = new Tables();
	$tableid = $tables->getTable("agsystemfieldtestin");
	
			
	$crps = new Crps();
	$fields="*";
	$where="";
	$groupby="";
	$having="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($crps->result)){
	  $sql="select * from indcrpalloc where crpsid='$row->id' and valueid='$obj->id' and tableid='$tableid' ";
	  if(mysql_affected_rows()>0){
	    $obj->crpattribution=true;
	  }
	  $r=mysql_fetch_object(mysql_query($sql));
	  $id = $row->id;
	  $obj->$id=$r->alloc;
	}
	
	$themes = new Themes();
	$fields="*";
	$where="";
	$groupby="";
	$having="";
	$orderby="";
	$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($themes->result)){
	  $sql="select * from indthmalloc where themeid='$row->id' and valueid='$obj->id' and tableid='$tableid' ";
	  $r=mysql_fetch_object(mysql_query($sql));
	  $id = "theme".$row->id;
	  $_POST[$id]=$r->alloc;
	}
	
	$valuechains = new Valuechains();
	$fields="*";
	$where="";
	$groupby="";
	$having="";
	$orderby="";
	$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($valuechains->result)){
	  $sql="select * from indvlcalloc where valuechainid='$row->id' and valueid='$obj->id' and tableid='$tableid' ";
	  $r=mysql_fetch_object(mysql_query($sql));
	  $id = "valuechain".$row->id;
	  $_POST[$id]=$r->alloc;
	}

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$themes = new Themes();
		$fields="*";
		$where="";
		$groupby="";
		$having="";
		$orderby="";
		$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($row=mysql_fetch_object($themes->result)){
		  $sql="select * from crp_groupthemes where themeid='$row->id' and groupid in(select group_id from crp_usergroup where user_id='".$_SESSION['userid']."') ";//echo $sql;
		  mysql_query($sql);
		  
		  if(mysql_affected_rows()>0){
		    $id = "theme".$row->id;
		    $_POST[$id]=1;
		  }
		  
		}
		
		$valuechains = new Valuechains();
		$fields="*";
		$where="";
		$groupby="";
		$having="";
		$orderby="";
		$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($row=mysql_fetch_object($valuechains->result)){
		  $sql="select * from crp_groupvaluechains where valuechainid='$row->id' and groupid in(select group_id from crp_usergroup where user_id='".$_SESSION['userid']."') ";//echo $sql;
		  mysql_query($sql);
		  
		  if(mysql_affected_rows()>0){
		    $id = "valuechain".$row->id;
		    $_POST[$id]=1;
		  }
		  
		}
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Agsystemfieldtestin ";
include "addagsystemfieldtestin.php";
?>