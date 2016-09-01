<?php 
require_once("TargetsDBO.php");
class Targets
{				
	var $id;			
	var $tableid;			
	var $crpid;			
	var $target;			
	var $userid;			
	var $year;			
	var $datekeyed;			
	var $targetsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->tableid))
			$obj->tableid='NULL';
		$this->tableid=$obj->tableid;
		if(empty($obj->crpid))
			$obj->crpid='NULL';
		$this->crpid=$obj->crpid;
		$this->target=str_replace("'","\'",$obj->target);
		if(empty($obj->userid))
			$obj->userid='NULL';
		$this->userid=$obj->userid;
		$this->year=str_replace("'","\'",$obj->year);
		$this->datekeyed=str_replace("'","\'",$obj->datekeyed);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get tableid
	function getTableid(){
		return $this->tableid;
	}
	//set tableid
	function setTableid($tableid){
		$this->tableid=$tableid;
	}

	//get crpid
	function getCrpid(){
		return $this->crpid;
	}
	//set crpid
	function setCrpid($crpid){
		$this->crpid=$crpid;
	}

	//get target
	function getTarget(){
		return $this->target;
	}
	//set target
	function setTarget($target){
		$this->target=$target;
	}

	//get userid
	function getUserid(){
		return $this->userid;
	}
	//set userid
	function setUserid($userid){
		$this->userid=$userid;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get datekeyed
	function getDatekeyed(){
		return $this->datekeyed;
	}
	//set datekeyed
	function setDatekeyed($datekeyed){
		$this->datekeyed=$datekeyed;
	}

	function add($obj){
		$targetsDBO = new TargetsDBO();
		if($targetsDBO->persist($obj)){
			$this->id=$targetsDBO->id;
			$this->sql=$targetsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$targetsDBO = new TargetsDBO();
		if($targetsDBO->update($obj,$where)){
			$this->sql=$targetsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$targetsDBO = new TargetsDBO();
		if($targetsDBO->delete($obj,$where=""))		
			$this->sql=$targetsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$targetsDBO = new TargetsDBO();
		$this->table=$targetsDBO->table;
		$targetsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$targetsDBO->sql;
		$this->result=$targetsDBO->result;
		$this->fetchObject=$targetsDBO->fetchObject;
		$this->affectedRows=$targetsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tableid)){
			$error="CRP Indicator should be provided";
		}
		else if(empty($obj->crpid)){
			$error="CRP should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
