<?php 
require_once("TaskalbumsDBO.php");
class Taskalbums
{				
	var $id;			
	var $taskid;			
	var $name;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $taskalbumsDBO;
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
		$this->name=str_replace("'","\'",$obj->name);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$taskalbumsDBO = new TaskalbumsDBO();
		if($taskalbumsDBO->persist($obj)){
			$this->id=$taskalbumsDBO->id;
			$this->sql=$taskalbumsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$taskalbumsDBO = new TaskalbumsDBO();
		if($taskalbumsDBO->update($obj,$where)){
			$this->sql=$taskalbumsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$taskalbumsDBO = new TaskalbumsDBO();
		if($taskalbumsDBO->delete($obj,$where=""))		
			$this->sql=$taskalbumsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$taskalbumsDBO = new TaskalbumsDBO();
		$this->table=$taskalbumsDBO->table;
		$taskalbumsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$taskalbumsDBO->sql;
		$this->result=$taskalbumsDBO->result;
		$this->fetchObject=$taskalbumsDBO->fetchObject;
		$this->affectedRows=$taskalbumsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->taskid)){
			$error="Task should be provided";
		}
		else if(empty($obj->name)){
			$error="Album should be provided";
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
