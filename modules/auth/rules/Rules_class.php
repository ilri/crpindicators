<?php 
require_once("RulesDBO.php");
class Rules
{				
	var $id;			
	var $levelid;			
	var $roleid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $rulesDBO;
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

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get roleid
	function getRoleid(){
		return $this->roleid;
	}
	//set roleid
	function setRoleid($roleid){
		$this->roleid=$roleid;
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
		$rulesDBO = new RulesDBO();
		if($rulesDBO->persist($obj)){		
			$this->id=$rulesDBO->id;
			return true;	
		}
	}			
	function edit($obj){			
		$rulesDBO = new RulesDBO();
		if($rulesDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$rulesDBO = new RulesDBO();
		if($rulesDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$rulesDBO = new RulesDBO();
		$this->table=$rulesDBO->table;
		$rulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$rulesDBO->sql;
		$this->result=$rulesDBO->result;
		$this->fetchObject=$rulesDBO->fetchObject;
		$this->affectedRows=$rulesDBO->affectedRows;
	}			
}				
?>
