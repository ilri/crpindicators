<?php 
require_once("LevelsDBO.php");
class Levels
{				
	var $id;			
	var $name;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $levelsDBO;
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
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->persist($obj)){		
			$this->id=$levelsDBO->id;
			return true;	
		}
	}			
	function edit($obj){			
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$levelsDBO = new LevelsDBO();
		if($levelsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$levelsDBO = new LevelsDBO();
		$this->table=$levelsDBO->table;
		$levelsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$levelsDBO->sql;
		$this->result=$levelsDBO->result;
		$this->fetchObject=$levelsDBO->fetchObject;
		$this->affectedRows=$levelsDBO->affectedRows;
	}			
}				
?>
