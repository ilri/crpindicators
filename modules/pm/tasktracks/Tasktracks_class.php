<?php 
require_once("TasktracksDBO.php");
class Tasktracks
{				
	var $id;			
	var $taskid;			
	var $origtask;			
	var $statusid;			
	var $changedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tasktracksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->taskid))
			$obj->taskid='NULL';
		$this->taskid=$obj->taskid;
		$this->origtask=str_replace("'","\'",$obj->origtask);
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
		$this->changedon=str_replace("'","\'",$obj->changedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get taskid
	function getTaskid(){
		return $this->taskid;
	}
	//set taskid
	function setTaskid($taskid){
		$this->taskid=$taskid;
	}

	//get origtask
	function getOrigtask(){
		return $this->origtask;
	}
	//set origtask
	function setOrigtask($origtask){
		$this->origtask=$origtask;
	}

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
	}

	//get changedon
	function getChangedon(){
		return $this->changedon;
	}
	//set changedon
	function setChangedon($changedon){
		$this->changedon=$changedon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$tasktracksDBO = new TasktracksDBO();
		if($tasktracksDBO->persist($obj)){
			$this->id=$tasktracksDBO->id;
			$this->sql=$tasktracksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tasktracksDBO = new TasktracksDBO();
		if($tasktracksDBO->update($obj,$where)){
			$this->sql=$tasktracksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tasktracksDBO = new TasktracksDBO();
		if($tasktracksDBO->delete($obj,$where=""))		
			$this->sql=$tasktracksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tasktracksDBO = new TasktracksDBO();
		$this->table=$tasktracksDBO->table;
		$tasktracksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tasktracksDBO->sql;
		$this->result=$tasktracksDBO->result;
		$this->fetchObject=$tasktracksDBO->fetchObject;
		$this->affectedRows=$tasktracksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->taskid)){
			$error="Task should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
		}
		else if(empty($obj->changedon)){
			$error="Changed On should be provided";
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
