<?php 
require_once("RolesDBO.php");
class Roles
{				
	var $id;			
	var $name;			
	var $moduleid;			
	var $module;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $rolesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

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

	//get moduleid
	function getModuleid(){
		return $this->moduleid;
	}
	//set moduleid
	function setModuleid($moduleid){
		$this->moduleid=$moduleid;
	}

	//get module
	function getModule(){
		return $this->module;
	}
	//set module
	function setModule($module){
		$this->module=$module;
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
		$rolesDBO = new RolesDBO();
		if($rolesDBO->persist($obj)){		
			$this->id=$rolesDBO->id;
			return true;	
		}
	}			
	function edit($obj){			
		$rolesDBO = new RolesDBO();
		if($rolesDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$rolesDBO = new RolesDBO();
		if($rolesDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$rolesDBO = new RolesDBO();
		$this->table=$rolesDBO->table;
		$rolesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$rolesDBO->sql;
		$this->result=$rolesDBO->result;
		$this->fetchObject=$rolesDBO->fetchObject;
		$this->affectedRows=$rolesDBO->affectedRows;
	}			
}				
?>
