<?php 
require_once("PeriodsDBO.php");
class Periods
{				
	var $id;			
	var $name;	
	var $remarks;
	var $status;		
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $periodsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$periodsDBO = new PeriodsDBO();
		if($periodsDBO->persist($obj)){
			$this->id=$periodsDBO->id;
			$this->sql=$periodsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$periodsDBO = new PeriodsDBO();
		if($periodsDBO->update($obj,$where)){
			$this->sql=$periodsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$periodsDBO = new PeriodsDBO();
		if($periodsDBO->delete($obj,$where=""))		
			$this->sql=$periodsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$periodsDBO = new PeriodsDBO();
		$this->table=$periodsDBO->table;
		$periodsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$periodsDBO->sql;
		$this->result=$periodsDBO->result;
		$this->fetchObject=$periodsDBO->fetchObject;
		$this->affectedRows=$periodsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Configuration Term should be provided";
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
