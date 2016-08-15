<?php 
require_once("TaskparticipantsDBO.php");
class Taskparticipants
{				
	var $id;			
	var $taskid;			
	var $employeeid;			
	var $description;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $taskparticipantsDBO;
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
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->description=str_replace("'","\'",$obj->description);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$taskparticipantsDBO = new TaskparticipantsDBO();
		if($taskparticipantsDBO->persist($obj)){
			$this->id=$taskparticipantsDBO->id;
			$this->sql=$taskparticipantsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$taskparticipantsDBO = new TaskparticipantsDBO();
		if($taskparticipantsDBO->update($obj,$where)){
			$this->sql=$taskparticipantsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$taskparticipantsDBO = new TaskparticipantsDBO();
		if($taskparticipantsDBO->delete($obj,$where=""))		
			$this->sql=$taskparticipantsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$taskparticipantsDBO = new TaskparticipantsDBO();
		$this->table=$taskparticipantsDBO->table;
		$taskparticipantsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$taskparticipantsDBO->sql;
		$this->result=$taskparticipantsDBO->result;
		$this->fetchObject=$taskparticipantsDBO->fetchObject;
		$this->affectedRows=$taskparticipantsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->taskid)){
			$error="Task should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Participant should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Participant should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
